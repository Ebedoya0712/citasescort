<div x-data="ageVerification()" 
     x-init="init()"
     x-show="show" 
     style="display: none;"
     class="fixed inset-0 z-[100] bg-black/95 backdrop-blur-md flex items-center justify-center p-4">
    
    <div x-show="show"
         x-transition:enter="transition ease-out duration-500"
         x-transition:enter-start="opacity-0 scale-90 translate-y-8"
         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
         class="bg-zinc-900 border border-zinc-800 rounded-3xl p-8 md:p-12 max-w-2xl w-full text-center shadow-[0_0_100px_-20px_rgba(255,42,122,0.3)] relative overflow-hidden">
        
        <!-- Decorative Glow -->
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-1/2 bg-red-600/20 blur-[100px] pointer-events-none rounded-full"></div>

        <div class="relative z-10">
            <!-- Icon -->
            <div class="w-24 h-24 bg-red-500/10 rounded-full flex items-center justify-center mx-auto mb-8 border-2 border-red-500/30">
                <span class="text-4xl font-black text-red-500">+18</span>
            </div>

            <!-- Content -->
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-6 tracking-tight">Advertencia de Contenido</h2>
            
            <p class="text-gray-400 text-base md:text-lg leading-relaxed mb-10 max-w-lg mx-auto">
                Este sitio web contiene material adulto explícito. Debes tener <strong>al menos 18 años de edad</strong> (o la mayoría de edad legal en tu jurisdicción) para acceder a este sitio web.
            </p>

            <!-- Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <button @click="verify()" 
                    class="w-full sm:w-auto px-8 py-4 bg-red-600 border border-red-600 rounded-xl font-bold text-white hover:bg-red-600/90 hover:shadow-lg hover:shadow-red-600/20 active:scale-95 transition-all duration-200 text-lg uppercase tracking-wider">
                    SÍ, SOY MAYOR DE 18 AÑOS
                </button>
                
                <a href="https://www.google.com" 
                    class="w-full sm:w-auto px-8 py-4 bg-zinc-800 border border-zinc-700 rounded-xl font-bold text-gray-300 hover:bg-zinc-700 hover:text-white active:scale-95 transition-all duration-200 text-lg uppercase tracking-wider flex items-center justify-center">
                    NO, SALIR DE AQUÍ
                </a>
            </div>
            
            <!-- Legal Terms -->
            <p class="text-zinc-500 text-xs mt-10 max-w-md mx-auto leading-relaxed">
                Al hacer clic en "Sí", confirmas que has leído y aceptas nuestros términos de servicio y políticas de privacidad.
            </p>
        </div>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('ageVerification', () => ({
            show: false,
            
            init() {
                // Check if user has already verified their age
                if (!localStorage.getItem('citasescort_age_verified')) {
                    this.show = true;
                    document.body.classList.add('overflow-hidden');
                }
            },
            
            verify() {
                // Set item in local storage to remember verification
                localStorage.setItem('citasescort_age_verified', 'true');
                this.show = false;
                document.body.classList.remove('overflow-hidden');
            }
        }))
    })
</script>
