<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use App\Models\VisitLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Carbon;

class VisitorTrackingController extends Controller
{
    /**
     * Registra o actualiza la visita del usuario y crea un registro de log de página.
     */
    public function track(Request $request)
    {
        $request->validate([
            'visitor_uuid' => 'required|string',
            'url' => 'required|string',
            'referrer' => 'nullable|string',
            'utm_source' => 'nullable|string',
            'utm_medium' => 'nullable|string',
            'utm_campaign' => 'nullable|string',
            'utm_content' => 'nullable|string',
            'utm_term' => 'nullable|string',
            'gclid' => 'nullable|string',
            'fbclid' => 'nullable|string',
        ]);

        $uuid = $request->input('visitor_uuid');
        $ip = $request->ip();
        $userAgent = $request->userAgent();

        // 1. Detección de navegador y dispositivo
        list($browser, $device) = $this->parseUserAgent($userAgent);

        // 2. Geolocalización por IP
        list($city, $country) = $this->getGeoLocation($ip);

        // 3. Buscar o crear el visitante
        $visitor = Visitor::find($uuid);
        $now = Carbon::now();

        if ($visitor) {
            // Visitante recurrente
            $visitor->total_visits += 1;
            $visitor->last_visit_at = $now;
            
            // Actualizar IP y localización más reciente
            $visitor->ip_address = $ip;
            $visitor->user_agent = $userAgent;
            $visitor->browser = $browser;
            $visitor->device = $device;
            $visitor->city = $city;
            $visitor->country = $country;

            // Actualizar campañas si vienen nuevas
            if ($request->filled('utm_source')) {
                $visitor->utm_source = $request->input('utm_source');
                $visitor->utm_medium = $request->input('utm_medium');
                $visitor->utm_campaign = $request->input('utm_campaign');
                $visitor->utm_content = $request->input('utm_content');
                $visitor->utm_term = $request->input('utm_term');
            }
            if ($request->filled('gclid')) $visitor->gclid = $request->input('gclid');
            if ($request->filled('fbclid')) $visitor->fbclid = $request->input('fbclid');

            $visitor->save();
        } else {
            // Primer visita
            $visitor = Visitor::create([
                'id' => $uuid,
                'first_visit_at' => $now,
                'last_visit_at' => $now,
                'total_visits' => 1,
                'whatsapp_clicks' => 0,
                'utm_source' => $request->input('utm_source'),
                'utm_medium' => $request->input('utm_medium'),
                'utm_campaign' => $request->input('utm_campaign'),
                'utm_content' => $request->input('utm_content'),
                'utm_term' => $request->input('utm_term'),
                'gclid' => $request->input('gclid'),
                'fbclid' => $request->input('fbclid'),
                'ip_address' => $ip,
                'user_agent' => $userAgent,
                'browser' => $browser,
                'device' => $device,
                'city' => $city,
                'country' => $country,
            ]);
        }

        // 4. Crear el log de la página visitada
        $log = VisitLog::create([
            'visitor_id' => $visitor->id,
            'url' => $request->input('url'),
            'referrer' => $request->input('referrer'),
            'duration' => 0,
        ]);

        return response()->json([
            'success' => true,
            'visit_log_id' => $log->id,
            'visitor' => [
                'has_whatsapp' => !empty($visitor->whatsapp_number),
                'name' => $visitor->name,
                'whatsapp' => $visitor->whatsapp_number
            ]
        ]);
    }

    /**
     * Incrementa la duración de permanencia en la página actual.
     */
    public function heartbeat(Request $request)
    {
        $request->validate([
            'visit_log_id' => 'required|integer',
        ]);

        $log = VisitLog::find($request->input('visit_log_id'));
        if ($log) {
            $log->duration += 10; // suma 10 segundos
            $log->save();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Log no encontrado'], 404);
    }

    /**
     * Registra un clic en el botón de WhatsApp.
     */
    public function trackClick(Request $request)
    {
        $request->validate([
            'visitor_uuid' => 'required|string',
        ]);

        $visitor = Visitor::find($request->input('visitor_uuid'));
        if ($visitor) {
            $visitor->whatsapp_clicks += 1;
            $visitor->save();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Visitante no encontrado'], 404);
    }

    /**
     * Asocia el número de WhatsApp y nombre al visitante con su consentimiento.
     */
    public function saveWhatsApp(Request $request)
    {
        $request->validate([
            'visitor_uuid' => 'required|string',
            'whatsapp_number' => 'required|string',
            'name' => 'nullable|string',
            'consent' => 'required|accepted',
        ]);

        $visitor = Visitor::find($request->input('visitor_uuid'));
        if ($visitor) {
            $visitor->whatsapp_number = $request->input('whatsapp_number');
            if ($request->filled('name')) {
                $visitor->name = $request->input('name');
            }
            $visitor->save();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Visitante no encontrado'], 404);
    }

    /**
     * Parsea el agente de usuario de manera básica para obtener navegador y dispositivo.
     */
    private function parseUserAgent($userAgent)
    {
        $browser = 'Desconocido';
        $device = 'Escritorio';

        if (empty($userAgent)) {
            return [$browser, $device];
        }

        // Detectar dispositivo
        if (preg_match('/(tablet|ipad|playbook|silk)|(android(?!.*mobi))/i', $userAgent)) {
            $device = 'Tablet';
        } elseif (preg_match('/(mobi|ipod|phone|blackberry|opera mini|fennec|minimo|symbian|psp|nintendo)/i', $userAgent)) {
            $device = 'Móvil';
        } else {
            $device = 'Escritorio';
        }

        // Detectar navegador
        if (preg_match('/msie/i', $userAgent) && !preg_match('/opera/i', $userAgent)) {
            $browser = 'Internet Explorer';
        } elseif (preg_match('/firefox/i', $userAgent)) {
            $browser = 'Firefox';
        } elseif (preg_match('/chrome/i', $userAgent)) {
            if (preg_match('/edg/i', $userAgent)) {
                $browser = 'Edge';
            } elseif (preg_match('/opr/i', $userAgent)) {
                $browser = 'Opera';
            } else {
                $browser = 'Chrome';
            }
        } elseif (preg_match('/safari/i', $userAgent)) {
            $browser = 'Safari';
        } elseif (preg_match('/opera/i', $userAgent)) {
            $browser = 'Opera';
        }

        return [$browser, $device];
    }

    /**
     * Obtiene la geolocalización aproximada a través de la IP.
     */
    private function getGeoLocation($ip)
    {
        $city = 'Desconocido';
        $country = 'Desconocido';

        // Evitar llamar al API en localhost
        if (in_array($ip, ['127.0.0.1', '::1']) || filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false) {
            return ['Localhost', 'Uruguay'];
        }

        try {
            $response = Http::timeout(2)->get("http://ip-api.com/json/{$ip}");
            if ($response->successful()) {
                $data = $response->json();
                if (($data['status'] ?? '') === 'success') {
                    $city = $data['city'] ?? 'Desconocido';
                    $country = $data['country'] ?? 'Desconocido';
                }
            }
        } catch (\Exception $e) {
            // Failsafe
        }

        return [$city, $country];
    }
}
