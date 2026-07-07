<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura de Suscripción - Citasescort</title>
</head>
<body style="margin: 0; padding: 0; background-color: #0f0f11; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background-color: #0f0f11; padding: 40px 20px;">
        <tr>
            <td align="center">
                <table role="presentation" width="600" cellspacing="0" cellpadding="0" style="max-width: 600px; width: 100%;">
                    
                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #ff2a7a 0%, #e91e63 50%, #c2185b 100%); padding: 40px 30px; border-radius: 16px 16px 0 0; text-align: center;">
                            <h1 style="color: #ffffff; font-size: 32px; margin: 0 0 8px 0; font-weight: 800; letter-spacing: 2px;">CITASESCORT</h1>
                            <p style="color: rgba(255,255,255,0.85); font-size: 14px; margin: 0; letter-spacing: 1px; text-transform: uppercase;">Factura de Suscripción</p>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="background-color: #18181b; padding: 40px 30px;">
                            
                            <!-- Greeting -->
                            <p style="color: #e4e4e7; font-size: 16px; margin: 0 0 8px 0;">Hola,</p>
                            <h2 style="color: #ffffff; font-size: 24px; margin: 0 0 24px 0; font-weight: 700;">{{ $escort->name }} 👋</h2>
                            
                            <p style="color: #a1a1aa; font-size: 15px; line-height: 1.6; margin: 0 0 30px 0;">
                                ¡Tu pago ha sido procesado exitosamente! A continuación te presentamos los detalles de tu factura.
                            </p>

                            <!-- Plan Badge -->
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="margin-bottom: 30px;">
                                <tr>
                                    <td align="center">
                                        <div style="display: inline-block; background: linear-gradient(135deg, #ff2a7a, #e91e63); padding: 12px 32px; border-radius: 50px;">
                                            <span style="color: #ffffff; font-size: 18px; font-weight: 800; letter-spacing: 1px; text-transform: uppercase;">
                                                @if(strtolower($plan->name) === 'diamante')
                                                    💎 Plan {{ $plan->name }}
                                                @elseif(strtolower($plan->name) === 'plata')
                                                    🥈 Plan {{ $plan->name }}
                                                @else
                                                    Plan {{ $plan->name }}
                                                @endif
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                            </table>

                            <!-- Invoice Details -->
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background-color: #27272a; border-radius: 12px; overflow: hidden; margin-bottom: 30px;">
                                <tr>
                                    <td style="padding: 20px 24px; border-bottom: 1px solid #3f3f46;">
                                        <table role="presentation" width="100%" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td style="color: #a1a1aa; font-size: 14px;">Plan Adquirido</td>
                                                <td align="right" style="color: #ffffff; font-size: 14px; font-weight: 700;">{{ $plan->name }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 20px 24px; border-bottom: 1px solid #3f3f46;">
                                        <table role="presentation" width="100%" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td style="color: #a1a1aa; font-size: 14px;">Monto Pagado</td>
                                                <td align="right" style="color: #ff2a7a; font-size: 20px; font-weight: 800;">${{ number_format($plan->price, 2) }} USD</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 20px 24px; border-bottom: 1px solid #3f3f46;">
                                        <table role="presentation" width="100%" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td style="color: #a1a1aa; font-size: 14px;">Método de Pago</td>
                                                <td align="right" style="color: #ffffff; font-size: 14px; font-weight: 600;">{{ ucfirst($payment->gateway) }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 20px 24px; border-bottom: 1px solid #3f3f46;">
                                        <table role="presentation" width="100%" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td style="color: #a1a1aa; font-size: 14px;">ID Transacción</td>
                                                <td align="right" style="color: #71717a; font-size: 12px; font-weight: 600; font-family: monospace;">{{ $payment->transaction_id ?: str_pad($payment->id, 2, '0', STR_PAD_LEFT) }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 20px 24px;">
                                        <table role="presentation" width="100%" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td style="color: #a1a1aa; font-size: 14px;">Válido Hasta</td>
                                                <td align="right" style="color: #10b981; font-size: 14px; font-weight: 700;">{{ $expiresAt }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <!-- Benefits -->
                            <div style="background-color: #27272a; border-radius: 12px; padding: 24px; margin-bottom: 30px; border-left: 4px solid #ff2a7a;">
                                <h3 style="color: #ffffff; font-size: 16px; margin: 0 0 16px 0; font-weight: 700;">✨ Beneficios Activos</h3>
                                <table role="presentation" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td style="padding: 6px 0; color: #10b981; font-size: 14px;">✓</td>
                                        <td style="padding: 6px 0 6px 10px; color: #e4e4e7; font-size: 14px;">Posicionamiento VIP en la página principal</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 6px 0; color: #10b981; font-size: 14px;">✓</td>
                                        <td style="padding: 6px 0 6px 10px; color: #e4e4e7; font-size: 14px;">Badge y bordes especiales en tu anuncio</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 6px 0; color: #10b981; font-size: 14px;">✓</td>
                                        <td style="padding: 6px 0 6px 10px; color: #e4e4e7; font-size: 14px;">Atención y soporte 24/7 prioritario</td>
                                    </tr>
                                </table>
                            </div>

                            <!-- CTA -->
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td align="center">
                                        <a href="{{ config('app.url') }}" style="display: inline-block; background: linear-gradient(135deg, #ff2a7a, #e91e63); color: #ffffff; text-decoration: none; padding: 14px 40px; border-radius: 50px; font-size: 15px; font-weight: 700; letter-spacing: 0.5px;">
                                            Ir a mi Escritorio →
                                        </a>
                                    </td>
                                </tr>
                            </table>

                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #0f0f11; padding: 30px; text-align: center; border-top: 1px solid #27272a;">
                            <p style="color: #52525b; font-size: 12px; margin: 0 0 8px 0;">
                                Este correo fue enviado automáticamente. No responder a este mensaje.
                            </p>
                            <p style="color: #3f3f46; font-size: 11px; margin: 0;">
                                &copy; {{ date('Y') }} Citasescort. Todos los derechos reservados.
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>

