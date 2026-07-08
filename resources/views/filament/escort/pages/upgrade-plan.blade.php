<x-filament-panels::page>
    <div style="display: flex; flex-wrap: wrap; gap: 2.5rem; justify-content: center; max-width: 1200px; margin: 0 auto; padding: 2rem 0;">
        
        <!-- Plan Gratis -->
        <div style="flex: 1 1 320px; max-width: 380px; background: #18181b; border: 1px solid #3f3f46; border-radius: 1.5rem; padding: 2.5rem; display: flex; flex-direction: column; opacity: 0.8;">
            <h2 style="font-size: 2rem; font-weight: 700; color: #a1a1aa; margin-bottom: 0.5rem; text-align: center; text-transform: uppercase;">
                General
            </h2>
            <p style="margin-bottom: 2rem; min-height: 3.5rem; font-size: 0.95rem; color: #71717a; text-align: center; line-height: 1.5;">
                Plan gratuito por defecto. Visibilidad nula o muy baja en la plataforma.
            </p>
            <div style="margin-bottom: 2.5rem; display: flex; align-items: baseline; justify-content: center; border-bottom: 1px solid #3f3f46; padding-bottom: 2rem;">
                <span style="font-size: 3.5rem; font-weight: 700; color: #d4d4d8; line-height: 1;">$0</span>
                <span style="margin-left: 0.5rem; font-size: 1.2rem; color: #71717a; font-weight: 600;">/ mes</span>
            </div>
            <ul style="margin-bottom: 2.5rem; list-style: none; padding: 0; font-size: 0.95rem; color: #71717a; flex-grow: 1;">
                <li style="display: flex; align-items: flex-start; margin-bottom: 1.25rem;">
                    <svg style="width: 22px; height: 22px; margin-right: 0.75rem; color: #ef4444; flex-shrink: 0; margin-top: 2px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    <span>Sin posicionamiento VIP</span>
                </li>
                <li style="display: flex; align-items: flex-start; margin-bottom: 1.25rem;">
                    <svg style="width: 22px; height: 22px; margin-right: 0.75rem; color: #ef4444; flex-shrink: 0; margin-top: 2px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    <span>Sin bordes ni efectos especiales</span>
                </li>
            </ul>
            @php $currentPlanId = auth()->user()->escort->plan_id ?? null; @endphp
            @if(!$currentPlanId)
                <div style="display: flex; align-items: center; justify-content: center; width: 100%; padding: 0.875rem 1.5rem; background-color: #27272a; border: 1px solid #3f3f46; border-radius: 0.5rem; cursor: default;">
                    <span style="color: #a1a1aa; font-weight: 700; font-size: 1.1rem; letter-spacing: 0.5px;">Plan Actual</span>
                </div>
            @else
                <div style="text-align: center; color: #71717a; font-size: 0.9rem;">
                    Plan básico
                </div>
            @endif
        </div>

        @forelse($plans as $plan)
            <!-- Black and Red Card -->
            <div style="flex: 1 1 320px; max-width: 380px; position: relative; background: #0f0f11; border: 2px solid #ef4444; border-radius: 1.5rem; padding: 2.5rem; box-shadow: 0 10px 30px -10px rgba(239, 68, 68, 0.4); display: flex; flex-direction: column; transition: transform 0.3s ease;">
                
                @if(strtolower($plan->name) == 'diamante' || strtolower($plan->name) == 'premium' || strtolower($plan->name) == 'vip')
                <div style="position: absolute; top: -15px; left: 50%; transform: translateX(-50%); background: #ef4444; color: white; padding: 0.25rem 1rem; border-radius: 9999px; font-weight: bold; font-size: 0.85rem; letter-spacing: 0.05em; text-transform: uppercase; box-shadow: 0 4px 6px rgba(239, 68, 68, 0.3); white-space: nowrap;">
                    ★ Más Popular ★
                </div>
                @endif

                <h2 style="font-size: 2rem; font-weight: 900; color: white; margin-bottom: 0.5rem; text-align: center; text-transform: uppercase; letter-spacing: 1px;">
                    {{ $plan->name }}
                </h2>

                <p style="margin-bottom: 2rem; min-height: 3.5rem; font-size: 0.95rem; color: #a1a1aa; text-align: center; line-height: 1.5;">
                    {{ $plan->description ?? 'Destaca tu perfil en los primeros resultados y consigue más clientes.' }}
                </p>

                <div style="margin-bottom: 2rem; display: flex; flex-direction: column; align-items: center; justify-content: center; border-bottom: 1px solid rgba(239, 68, 68, 0.2); padding-bottom: 1.5rem;">
                    @php 
                        $priceSoles = $plan->price;
                    @endphp
                    <div style="display: flex; align-items: baseline; white-space: nowrap;">
                        <span style="font-size: clamp(2.5rem, 8vw, 3.5rem); font-weight: 900; color: #ef4444; line-height: 1;">S/&nbsp;{{ number_format($priceSoles, 0) }}</span>
                        <span style="margin-left: 0.5rem; font-size: clamp(1rem, 4vw, 1.2rem); color: #a1a1aa; font-weight: 600;">PEN {{ $plan->duration_days == 90 ? '/ 3 meses' : '/ mes' }}</span>
                    </div>
                </div>

                <ul style="margin-bottom: 2.5rem; list-style: none; padding: 0; font-size: 0.95rem; color: #e4e4e7; flex-grow: 1;">
                    <li style="display: flex; align-items: flex-start; margin-bottom: 1.25rem;">
                        <svg style="width: 22px; height: 22px; margin-right: 0.75rem; color: #ef4444; flex-shrink: 0; margin-top: 2px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                        <span>Aceptamos pagos por Yape</span>
                    </li>
                    <li style="display: flex; align-items: flex-start; margin-bottom: 1.25rem;">
                        <svg style="width: 22px; height: 22px; margin-right: 0.75rem; color: #ef4444; flex-shrink: 0; margin-top: 2px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                        <span>Posicionamiento VIP en la página principal</span>
                    </li>
                    <li style="display: flex; align-items: flex-start; margin-bottom: 1.25rem;">
                        <svg style="width: 22px; height: 22px; margin-right: 0.75rem; color: #ef4444; flex-shrink: 0; margin-top: 2px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                        <span>Atención y soporte 24/7 prioritario</span>
                    </li>
                </ul>

                @php
                    $currentPlan = auth()->user()->escort->plan ?? null;
                    $currentPlanId = $currentPlan ? $currentPlan->id : null;
                    $currentPrice = $currentPlan ? $currentPlan->price : 0;
                @endphp
                
                @if($currentPlanId == $plan->id)
                    <div style="display: flex; align-items: center; justify-content: center; width: 100%; padding: 0.875rem 1.5rem; background-color: #27272a; border: 1px solid #3f3f46; border-radius: 0.5rem; cursor: default;">
                        <svg style="width: 24px; height: 24px; margin-right: 0.75rem; color: #10b981;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                        <span style="color: #a1a1aa; font-weight: 700; font-size: 1.1rem; letter-spacing: 0.5px;">Plan Ya Incluido</span>
                    </div>
                @else
                    @php
                        if ($currentPlanId) {
                            if ($plan->price > $currentPrice) {
                                $buttonText = 'Mejorar plan de anuncio';
                            } else {
                                $buttonText = 'Volver al plan anterior';
                            }
                        } else {
                            $buttonText = 'Mejorar plan de anuncio';
                        }
                    @endphp
                    <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                        <!-- Yape Button -->
                        <button type="button" wire:click="mountAction('payWithYape', { plan_id: {{ $plan->id }}, amount: {{ $plan->price }} })"
                           style="display: flex; align-items: center; justify-content: center; width: 100%; padding: 0.875rem 1.5rem; background-color: #7B2282; border-radius: 0.5rem; text-decoration: none; transition: opacity 0.2s; cursor: pointer; border: none;"
                           onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                           <img src="{{ asset('images/yape-seeklogo.png') }}" alt="Yape" style="height: 24px; margin-right: 0.5rem; object-fit: contain;">
                           <span style="color: white; font-weight: 700; font-size: 1.1rem; letter-spacing: 0.5px;">{{ $buttonText }} con Yape</span>
                        </button>
                    </div>
                @endif
            </div>
        @empty
            <div style="width: 100%; text-align: center; padding: 4rem; background: #0f0f11; border-radius: 1rem; border: 1px solid #27272a;">
                <h3 style="font-size: 1.5rem; font-weight: bold; color: white; margin-bottom: 1rem;">No hay planes disponibles</h3>
                <p style="color: #a1a1aa;">El administrador aún no ha configurado los planes de suscripción.</p>
            </div>
        @endforelse
    </div>
</x-filament-panels::page>
