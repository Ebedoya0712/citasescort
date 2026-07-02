<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use App\Models\Plan;
use App\Models\Payment;
use App\Models\Escort;

class PayPalSubscriptionController extends Controller
{
    /**
     * Create a subscription for the given plan.
     */
    public function createSubscription(Request $request, $planId)
    {
        $plan = Plan::findOrFail($planId);
        $escort = auth()->user()->escort;

        if (!$escort) {
            return redirect()->back()->with('error', 'Debes ser una escort para comprar un plan.');
        }

        if (!config('settings.enable_payments')) {
            return redirect()->back()->with('error', 'Los pagos en lÃ­nea estÃ¡n deshabilitados temporalmente.');
        }

        try {
            $provider = new PayPalClient;
            $provider->setApiCredentials(config('paypal'));
            $token = $provider->getAccessToken();
            if (!isset($token['access_token'])) {
                \Log::error("PayPal Token Error: " . json_encode($token));
            }
            $provider->setAccessToken($token);

            // 1. Create Product
            $product = $provider->createProduct([
                "name" => "Plan " . $plan->name,
                "description" => $plan->description ?? "SuscripciÃ³n para " . $plan->name,
                "type" => "SERVICE",
                "category" => "SOFTWARE"
            ]);

            // 2. Create Billing Plan
            $intervalCount = $plan->duration_days == 90 ? 3 : 1;
            
            $billingPlan = $provider->createPlan([
                "product_id" => $product['id'],
                "name" => "SuscripciÃ³n " . $plan->name,
                "description" => "Cobro para el plan " . $plan->name,
                "status" => "ACTIVE",
                "billing_cycles" => [
                    [
                        "frequency" => [
                            "interval_unit" => "MONTH",
                            "interval_count" => $intervalCount
                        ],
                        "tenure_type" => "REGULAR",
                        "sequence" => 1,
                        "total_cycles" => 0, // Infinite
                        "pricing_scheme" => [
                            "fixed_price" => [
                                "value" => $plan->price,
                                "currency_code" => "USD"
                            ]
                        ]
                    ]
                ],
                "payment_preferences" => [
                    "auto_bill_outstanding" => true,
                    "setup_fee" => [
                        "value" => "0",
                        "currency_code" => "USD"
                    ],
                    "setup_fee_failure_action" => "CONTINUE",
                    "payment_failure_threshold" => 3
                ]
            ]);

            // 3. Create Subscription
            $subscription = $provider->createSubscription([
                "plan_id" => $billingPlan['id'],
                "application_context" => [
                    "brand_name" => "Citasescort",
                    "locale" => "es-UY",
                    "shipping_preference" => "NO_SHIPPING",
                    "user_action" => "SUBSCRIBE_NOW",
                    "return_url" => route('paypal.success', ['plan_id' => $plan->id, 'escort_id' => $escort->id]),
                    "cancel_url" => route('paypal.cancel')
                ]
            ]);

            if (isset($subscription['id']) && $subscription['status'] == 'APPROVAL_PENDING') {
                foreach ($subscription['links'] as $link) {
                    if ($link['rel'] === 'approve') {
                        return redirect()->away($link['href']);
                    }
                }
            }

            return redirect()->back()->with('error', 'Error al crear la suscripciÃ³n con PayPal.');

        } catch (\Exception $e) {
            \Log::error("PayPal Subscription Error: " . $e->getMessage());
            return redirect()->back()->with('error', 'Error interno al contactar con PayPal.');
        }
    }

    /**
     * Handle successful subscription approval.
     */
    public function success(Request $request)
    {
        $subscriptionId = $request->input('subscription_id');
        $planId = $request->input('plan_id');
        $escortId = $request->input('escort_id');

        if (!$subscriptionId || !$planId || !$escortId) {
            return redirect()->route('filament.escort.pages.dashboard')->with('error', 'Datos de pago invÃ¡lidos.');
        }

        try {
            $provider = new PayPalClient;
            $provider->setApiCredentials(config('paypal'));
            $token = $provider->getAccessToken();
            $provider->setAccessToken($token);

            $subscriptionDetails = $provider->showSubscriptionDetails($subscriptionId);

            if (isset($subscriptionDetails['status']) && $subscriptionDetails['status'] === 'ACTIVE') {
                $plan = Plan::findOrFail($planId);
                $escort = Escort::findOrFail($escortId);

                // Register the payment
                $payment = Payment::create([
                    'user_id' => $escort->user_id,
                    'amount' => $plan->price,
                    'status' => 'completed',
                    'gateway' => 'paypal',
                    'transaction_id' => $subscriptionId,
                    'receipt_image' => 'paypal_subscription'
                ]);

                // Update escort level and plan
                $level = strtolower($plan->name);
                $expiresAt = now()->addDays($plan->duration_days);
                $escort->update([
                    'level' => $level,
                    'plan_id' => $plan->id,
                    'plan_expires_at' => $expiresAt,
                ]);

                // Send Email Invoice
                try {
                    \Illuminate\Support\Facades\Mail::to($escort->user->email)->send(new \App\Mail\SubscriptionInvoice($payment, $plan, $escort, $expiresAt->format('d/m/Y')));
                } catch (\Exception $e) {
                    \Log::error("Mail sending failed: " . $e->getMessage());
                }

                return redirect()->route('filament.escort.pages.dashboard')->with('success', 'Â¡SuscripciÃ³n activada con Ã©xito! Tu perfil ahora es ' . $plan->name);
            }

            return redirect()->route('filament.escort.pages.dashboard')->with('warning', 'La suscripciÃ³n estÃ¡ pendiente de activaciÃ³n por PayPal.');

        } catch (\Exception $e) {
            \Log::error("PayPal Success Error: " . $e->getMessage());
            return redirect()->route('filament.escort.pages.dashboard')->with('error', 'Error al verificar la suscripciÃ³n.');
        }
    }

    /**
     * Handle canceled subscription.
     */
    public function cancel()
    {
        return redirect()->route('filament.escort.pages.dashboard')->with('error', 'Has cancelado el proceso de pago.');
    }

    /**
     * Webhook for automatic monthly renewals or cancellations.
     */
    public function webhook(Request $request)
    {
        $eventType = $request->input('event_type');
        $resource = $request->input('resource');

        if (!$resource || !isset($resource['id'])) {
            return response()->json(['status' => 'ignored']);
        }

        switch ($eventType) {
            case 'BILLING.SUBSCRIPTION.CANCELLED':
            case 'BILLING.SUBSCRIPTION.SUSPENDED':
            case 'BILLING.SUBSCRIPTION.EXPIRED':
                $subscriptionId = $resource['id'];
                
                $payment = Payment::where('transaction_id', $subscriptionId)->first();
                if ($payment) {
                    $escort = Escort::where('user_id', $payment->user_id)->first();
                    if ($escort) {
                        $escort->update(['level' => 'general']);
                    }
                    $payment->update(['status' => 'failed']);
                }
                break;
                
            case 'PAYMENT.SALE.COMPLETED':
                $subscriptionId = $resource['billing_agreement_id'] ?? null;
                if ($subscriptionId) {
                    $payment = Payment::where('transaction_id', $subscriptionId)->first();
                    if ($payment) {
                        Payment::create([
                            'user_id' => $payment->user_id,
                            'amount' => $resource['amount']['total'] ?? 0,
                            'status' => 'completed',
                            'gateway' => 'paypal',
                            'transaction_id' => $subscriptionId,
                            'receipt_image' => 'paypal_recurring'
                        ]);
                    }
                }
                break;
        }

        return response()->json(['status' => 'success']);
    }
}

