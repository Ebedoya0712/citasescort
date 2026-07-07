<x-mail::message>
# ¡Felicidades, {{ $escort->name }}! 🎉

Tu perfil en **{{ config('app.name') }}** ha sido revisado y **aprobado** con éxito.

Ya eres una escort verificada en nuestra plataforma. Esto significa que a partir de este momento puedes acceder a tu panel de control y **subir tu primer anuncio** para empezar a conseguir clientes de forma segura.

<x-mail::panel>
**Siguiente Paso:** Entra a tu cuenta, adquiere o selecciona un plan de suscripción y publica tu anuncio para que todos puedan verte.
</x-mail::panel>

<x-mail::button :url="route('filament.escort.pages.dashboard')">
Ir a mi Panel de Control
</x-mail::button>

Si tienes alguna pregunta o necesitas ayuda, no dudes en contactarnos.

Atentamente,<br>
El equipo de **{{ config('app.name') }}**
</x-mail::message>
