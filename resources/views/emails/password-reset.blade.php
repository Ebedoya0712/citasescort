<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer Contraseña - Citasescort</title>
</head>
<body style="margin: 0; padding: 0; background-color: #0f0f11; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background-color: #0f0f11; padding: 40px 20px;">
        <tr>
            <td align="center">
                <table role="presentation" width="600" cellspacing="0" cellpadding="0" style="max-width: 600px; width: 100%;">
                    
                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #dc2626 0%, #b91c1c 50%, #991b1b 100%); padding: 40px 30px; border-radius: 16px 16px 0 0; text-align: center;">
                            <h1 style="color: #ffffff; font-size: 32px; margin: 0 0 8px 0; font-weight: 800; letter-spacing: 2px;">CITASESCORT</h1>
                            <p style="color: rgba(255,255,255,0.85); font-size: 14px; margin: 0; letter-spacing: 1px; text-transform: uppercase;">Recuperar Contraseña</p>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="background-color: #18181b; padding: 40px 30px;">
                            
                            <h2 style="color: #ffffff; font-size: 22px; margin: 0 0 16px 0; font-weight: 700;">Hola 👋</h2>
                            
                            <p style="color: #a1a1aa; font-size: 15px; line-height: 1.7; margin: 0 0 30px 0;">
                                Recibimos una solicitud para restablecer la contraseña de tu cuenta en Citasescort. Haz clic en el botón de abajo para crear una nueva contraseña.
                            </p>

                            <!-- CTA Button -->
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="margin-bottom: 30px;">
                                <tr>
                                    <td align="center">
                                        <a href="{{ $url }}" style="display: inline-block; background: linear-gradient(135deg, #dc2626, #b91c1c); color: #ffffff; text-decoration: none; padding: 16px 48px; border-radius: 50px; font-size: 16px; font-weight: 700; letter-spacing: 0.5px;">
                                            Restablecer mi Contraseña
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <!-- Expiry Notice -->
                            <div style="background-color: #27272a; border-radius: 12px; padding: 20px; margin-bottom: 30px; border-left: 4px solid #f59e0b;">
                                <p style="color: #fbbf24; font-size: 13px; margin: 0 0 4px 0; font-weight: 700;">⏰ Importante</p>
                                <p style="color: #a1a1aa; font-size: 13px; margin: 0; line-height: 1.5;">
                                    Este enlace expirará en <strong style="color: #e4e4e7;">60 minutos</strong>. Si no solicitaste este cambio, puedes ignorar este correo y tu contraseña seguirá siendo la misma.
                                </p>
                            </div>

                            <!-- Alternative Link -->
                            <p style="color: #71717a; font-size: 12px; line-height: 1.5; margin: 0;">
                                Si el botón no funciona, copia y pega este enlace en tu navegador:<br>
                                <a href="{{ $url }}" style="color: #dc2626; word-break: break-all; font-size: 11px;">{{ $url }}</a>
                            </p>

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
