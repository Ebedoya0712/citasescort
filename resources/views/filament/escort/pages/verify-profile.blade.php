<x-filament-panels::page>
    @php
        $status = $this->getEscortStatus();
    @endphp

    @if($status === 'pending')
        <style>
            @keyframes spin-slow {
                to {
                    transform: rotate(360deg);
                }
            }

            @keyframes pulse-ring {

                0%,
                100% {
                    opacity: 0.6;
                    transform: scale(1);
                }

                50% {
                    opacity: 0.2;
                    transform: scale(1.12);
                }
            }

            .clock-spin {
                animation: spin-slow 8s linear infinite;
            }

            .pulse-ring {
                animation: pulse-ring 2s ease-in-out infinite;
            }
        </style>
        <div
            style="background:rgba(234,179,8,0.08); border:1px solid rgba(234,179,8,0.2); border-radius:16px; padding:40px 24px; display:flex; flex-direction:column; align-items:center; gap:16px; text-align:center; max-width:460px; margin:40px auto;">
            <!-- Animated clock -->
            <div style="position:relative; width:80px; height:80px;">
                <!-- Outer pulsing ring -->
                <div class="pulse-ring"
                    style="position:absolute; inset:-10px; border-radius:50%; border:2px solid rgba(234,179,8,0.4);"></div>
                <!-- Clock icon -->
                <svg class="clock-spin" style="width:80px; height:80px; color:#eab308;" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="1.5">
                    <circle cx="12" cy="12" r="9.5" stroke="currentColor" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.5v5.5l3 3" />
                </svg>
            </div>
            <h2 style="font-size:1.2rem; font-weight:700; color:#fff; margin:0;">Verificación en Proceso</h2>
            <p style="color:#9ca3af; font-size:0.875rem; line-height:1.6; margin:0; max-width:340px;">
                Tus documentos han sido recibidos correctamente y están siendo revisados por nuestro equipo.
                Te notificaremos en cuanto tu perfil haya sido verificado.
            </p>
        </div>
    @elseif($status === 'approved')
        <div
            style="background:rgba(34,197,94,0.08); border:1px solid rgba(34,197,94,0.2); border-radius:16px; padding:40px 24px; display:flex; flex-direction:column; align-items:center; gap:16px; text-align:center; max-width:460px; margin:40px auto;">
            <svg style="width:80px; height:80px; color:#22c55e;" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                stroke-width="1.5">
                <circle cx="12" cy="12" r="9.5" stroke="currentColor" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.5 12.5l2.5 2.5 4.5-4.5" />
            </svg>
            <h2 style="font-size:1.2rem; font-weight:700; color:#fff; margin:0;">¡Perfil Verificado!</h2>
            <p style="color:#9ca3af; font-size:0.875rem; line-height:1.6; margin:0; max-width:340px;">
                Tu identidad ha sido confirmada con éxito. Ya tenés el distintivo de perfil verificado, lo que brindará más
                confianza a los usuarios.
            </p>
        </div>
    @else
        @if($status === 'rejected')
            <div class="mb-6 bg-red-500/10 border border-red-500/20 rounded-xl p-4 flex items-start gap-3">
                <x-heroicon-o-exclamation-triangle class="w-6 h-6 text-red-500 shrink-0 mt-0.5" />
                <div>
                    <h3 class="text-red-500 font-bold">Verificación Rechazada</h3>
                    <p class="text-sm text-red-400/80 mt-1">
                        Hubo un problema con los documentos o el video que enviaste. Por favor, lee las instrucciones
                        cuidadosamente y vuelve a intentarlo.
                    </p>
                </div>
            </div>
        @endif

        <form wire:submit="save">
            {{ $this->form }}

            <div class="mt-6 flex justify-end">
                <x-filament::button type="submit" icon="heroicon-o-paper-airplane">
                    Enviar para Revisión
                </x-filament::button>
            </div>
        </form>
    @endif
</x-filament-panels::page>