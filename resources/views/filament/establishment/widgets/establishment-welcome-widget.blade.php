<x-filament-widgets::widget>
    <div style="background: linear-gradient(135deg, #f76c95 0%, #e14d7a 100%); border-radius: 12px; padding: 2rem; color: white; position: relative; overflow: hidden; box-shadow: 0 10px 25px -5px rgba(247, 108, 149, 0.4); margin-bottom: 1rem;">
        <!-- Background Decoration -->
        <div style="position: absolute; right: -4rem; top: -4rem; width: 16rem; height: 16rem; border-radius: 9999px; background: rgba(255,255,255,0.1); filter: blur(40px);"></div>

        <div style="display: flex; flex-direction: column; gap: 1.5rem; position: relative; z-index: 10;">
            <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1.5rem;">
                
                <div style="display: flex; align-items: center; gap: 1.5rem; flex: 1; min-width: 300px;">
                    <div style="display: flex; align-items: center; justify-content: center; width: 4rem; height: 4rem; border-radius: 1rem; background: rgba(255,255,255,0.2); backdrop-filter: blur(4px);">
                        <svg style="width: 32px; height: 32px;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.999 2.999 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.999 2.999 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72m-13.5 8.65h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.75c0 .415.336.75.75.75z" />
                        </svg>
                    </div>
                    
                    <div>
                        <h2 style="font-size: 1.75rem; font-weight: 800; margin: 0; line-height: 1.2;">
                            Escritorio de <span style="text-decoration: underline; text-decoration-color: rgba(255,255,255,0.4); text-underline-offset: 4px;">{{ auth()->user()->establishment?->name ?? 'tu negocio' }}</span>
                        </h2>
                        <p style="font-size: 1.05rem; margin-top: 0.5rem; opacity: 0.9;">
                            Gestiona tu presencia, revisa tus métricas y mantén tu perfil actualizado para maximizar tus visitas.
                        </p>
                    </div>
                </div>

                <a href="{{ \App\Filament\Establishment\Pages\EditProfile::getUrl() }}" style="display: inline-flex; align-items: center; gap: 0.5rem; background: white; color: #f76c95; padding: 0.75rem 1.5rem; border-radius: 0.75rem; font-weight: bold; text-decoration: none; transition: transform 0.2s, box-shadow 0.2s;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 10px 15px -3px rgba(0,0,0,0.1)'" onmouseout="this.style.transform='none'; this.style.boxShadow='none'">
                    <svg style="width: 18px; height: 18px;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                    </svg>
                    Configurar Perfil
                </a>
            </div>
        </div>
    </div>
</x-filament-widgets::widget>