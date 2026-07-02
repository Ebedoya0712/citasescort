<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'message' => 'required|string',
        ]);

        ContactMessage::create($validated);

        // Asociar número de WhatsApp y nombre al visitante si tiene cookie de rastreo
        $visitorUuid = $request->cookie('visitor_uuid');
        if ($visitorUuid) {
            $visitor = \App\Models\Visitor::find($visitorUuid);
            if ($visitor) {
                if (!empty($validated['phone'])) {
                    $visitor->whatsapp_number = $validated['phone'];
                }
                if (!empty($validated['name'])) {
                    $visitor->name = $validated['name'];
                }
                $visitor->save();
            }
        }

        // Enviar correo a los administradores
        $adminEmails = \App\Models\User::where('role', 'admin')->pluck('email')->toArray();
        if (empty($adminEmails)) {
            $adminEmails = [config('mail.from.address')];
        }

        try {
            \Illuminate\Support\Facades\Mail::raw(
                "Has recibido un nuevo mensaje de contacto en " . config('app.name') . ":\n\n" .
                "Nombre: " . $validated['name'] . "\n" .
                "Email: " . $validated['email'] . "\n" .
                "Teléfono: " . ($validated['phone'] ?? 'No especificado') . "\n\n" .
                "Mensaje:\n" . $validated['message'],
                function ($message) use ($adminEmails, $validated) {
                    $message->to($adminEmails)
                        ->subject('Nuevo mensaje de contacto de: ' . $validated['name']);
                }
            );
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Error enviando correo de contacto al administrador: " . $e->getMessage());
        }

        return back()->with('success', 'Mensaje enviado a nuestro equipo.');
    }
}
