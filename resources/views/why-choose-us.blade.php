<x-main-layout>
    <!-- Custom Styles for Animations -->
    <style>
        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        .animate-float-delayed {
            animation: float 8s ease-in-out infinite 2s;
        }

        @keyframes gradient-x {

            0%,
            100% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }
        }

        .animate-gradient-x {
            background-size: 200% 200%;
            animation: gradient-x 15s ease infinite;
        }
    </style>

    <!-- Hero Section -->
    <div class="relative bg-gray-50 dark:bg-black py-24 lg:py-40 overflow-hidden transition-colors duration-300" x-data="{ shown: false }"
        x-init="setTimeout(() => shown = true, 100)">

        <!-- Animated Background -->
        <div class="absolute inset-0 z-0">
            <div class="absolute inset-0 bg-gradient-to-br from-gray-50 via-gray-100 to-gray-50 dark:from-black dark:via-zinc-900 dark:to-black z-10 transition-colors duration-300"></div>
            <!-- Dynamic Orbs -->
            <div
                class="absolute top-0 right-0 w-[500px] h-[500px] bg-red-600/20 rounded-full blur-[100px] -translate-y-1/2 translate-x-1/2 animate-float">
            </div>
            <div
                class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-red-900/10 rounded-full blur-[100px] translate-y-1/2 -translate-x-1/2 animate-float-delayed">
            </div>

            <img src="/images/hero-bg-2.jpg" alt="Background"
                class="w-full h-full object-cover opacity-20 mix-blend-overlay">
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 lg:px-8 text-center lg:text-left">
            <div class="transition-all duration-1000 transform"
                :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'">
                <h1 class="text-5xl lg:text-7xl font-black text-gray-900 dark:text-white mb-6 tracking-tight leading-tight">
                    ¿Por qué <br>
                    <span
                        class="text-transparent bg-clip-text bg-gradient-to-r from-red-600 via-red-500 to-black animate-gradient-x">Elegirnos?</span>
                </h1>
                <p class="text-xl lg:text-2xl text-gray-600 dark:text-gray-300 max-w-2xl leading-relaxed lg:mx-0 mx-auto">
                    Redefiniendo los encuentros con los más altos estándares de seguridad, discreción y calidad en
                    Perú.
                </p>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="bg-zinc-50 dark:bg-zinc-900 py-20 lg:py-32 relative">
        <div class="max-w-7xl mx-auto px-4 lg:px-8">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 lg:gap-12">
                <!-- Feature 1 -->
                <div x-data="{ show: false }" x-intersect.threshold.0.5="show = true"
                    class="group relative bg-white dark:bg-zinc-800/50 p-8 rounded-3xl border border-gray-100 dark:border-white/5 transition-all duration-700 transform hover:scale-[1.02] hover:shadow-2xl hover:shadow-red-600/10"
                    :class="show ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'">

                    <div
                        class="absolute inset-0 bg-gradient-to-br from-red-600/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity rounded-3xl">
                    </div>

                    <div class="relative z-10">
                        <div
                            class="w-20 h-20 rounded-2xl bg-gradient-to-br from-red-600 to-red-700 flex items-center justify-center text-white mb-6 shadow-lg shadow-red-600/30 group-hover:rotate-6 transition-transform">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                            </svg>
                        </div>
                        <h3
                            class="text-2xl font-bold text-gray-900 dark:text-white mb-3 group-hover:text-red-600 transition-colors">
                            Verificación Rigurosa</h3>
                        <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                            No dejamos nada al azar. Cada perfil pasa por un proceso de validación manual. Garantizamos
                            que quien ves en las fotos es quien realmente conocerás.
                        </p>
                    </div>
                </div>

                <!-- Feature 2 -->
                <div x-data="{ show: false }" x-intersect.threshold.0.5="show = true"
                    class="group relative bg-white dark:bg-zinc-800/50 p-8 rounded-3xl border border-gray-100 dark:border-white/5 transition-all duration-700 delay-150 transform hover:scale-[1.02] hover:shadow-2xl hover:shadow-red-600/10"
                    :class="show ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'">

                    <div
                        class="absolute inset-0 bg-gradient-to-br from-red-600/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity rounded-3xl">
                    </div>

                    <div class="relative z-10">
                        <div
                            class="w-20 h-20 rounded-2xl bg-gradient-to-br from-red-600 to-red-600 flex items-center justify-center text-white mb-6 shadow-lg shadow-red-600/30 group-hover:-rotate-6 transition-transform">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path
                                    d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24" />
                                <line x1="1" y1="1" x2="23" y2="23" />
                            </svg>
                        </div>
                        <h3
                            class="text-2xl font-bold text-gray-900 dark:text-white mb-3 group-hover:text-red-600 transition-colors">
                            Privacidad Absoluta</h3>
                        <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                            Navega con tranquilidad. Implementamos tecnologías de cifrado y anonimato para que tu
                            experiencia sea segura, privada y libre de rastros.
                        </p>
                    </div>
                </div>

                <!-- Feature 3 -->
                <div x-data="{ show: false }" x-intersect.threshold.0.5="show = true"
                    class="group relative bg-white dark:bg-zinc-800/50 p-8 rounded-3xl border border-gray-100 dark:border-white/5 transition-all duration-700 delay-300 transform hover:scale-[1.02] hover:shadow-2xl hover:shadow-red-600/10"
                    :class="show ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'">

                    <div
                        class="absolute inset-0 bg-gradient-to-br from-red-600/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity rounded-3xl">
                    </div>

                    <div class="relative z-10">
                        <div
                            class="w-20 h-20 rounded-2xl bg-gradient-to-br from-gray-700 to-black flex items-center justify-center text-white mb-6 shadow-lg shadow-black/30 group-hover:scale-110 transition-transform">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M12 20h9" />
                                <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z" />
                            </svg>
                        </div>
                        <h3
                            class="text-2xl font-bold text-gray-900 dark:text-white mb-3 group-hover:text-red-600 transition-colors">
                            Reseñas Verificadas</h3>
                        <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                            Una comunidad activa que comparte experiencias reales. Las reseñas te ayudan a elegir con
                            confianza, manteniendo la calidad en cada encuentro.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Stats Section (Social Proof) -->
            <div x-data="{ count1: 0, count2: 0, count3: 0, show: false }" x-intersect.once.threshold.0.1="
                    show = true;
                    $interval = setInterval(() => {
                        if(count1 < 100) count1++;
                        if(count2 < 5000) count2+=50;
                        if(count3 < 24) count3++;
                        if(count1 >= 100 && count2 >= 5000 && count3 >= 24) clearInterval($interval);
                    }, 20);
                "
                class="mt-24 mb-24 grid grid-cols-1 md:grid-cols-3 gap-8 text-center text-gray-900 dark:text-white transition-opacity duration-1000"
                :class="show ? 'opacity-100' : 'opacity-0'">

                <div
                    class="p-8 rounded-3xl bg-white dark:bg-zinc-900 border border-gray-200 dark:border-zinc-800 shadow-xl dark:shadow-2xl hover:border-red-600/30 transition-colors">
                    <div class="text-5xl font-black text-red-600 mb-2 flex justify-center items-center">
                        <span x-text="count1">0</span>%
                    </div>
                    <div class="text-lg font-medium text-gray-600 dark:text-gray-400">Perfiles Verificados</div>
                </div>

                <div
                    class="p-8 rounded-3xl bg-white dark:bg-zinc-900 border border-gray-200 dark:border-zinc-800 shadow-xl dark:shadow-2xl hover:border-red-600/30 transition-colors">
                    <div class="text-5xl font-black text-red-600 mb-2 flex justify-center items-center">
                        +<span x-text="count2">0</span>
                    </div>
                    <div class="text-lg font-medium text-gray-600 dark:text-gray-400">Usuarios Activos</div>
                </div>

                <div
                    class="p-8 rounded-3xl bg-white dark:bg-zinc-900 border border-gray-200 dark:border-zinc-800 shadow-xl dark:shadow-2xl hover:border-red-600/30 transition-colors">
                    <div class="text-5xl font-black text-red-600 mb-2 flex justify-center items-center">
                        <span x-text="count3">0</span>/7
                    </div>
                    <div class="text-lg font-medium text-gray-600 dark:text-gray-400">Soporte y Monitoreo</div>
                </div>
            </div>

            <!-- FAQ Section -->
            <div class="mt-24 max-w-4xl mx-auto" x-data="{ active: null, show: false }"
                x-intersect.once.threshold.0.1="show = true"
                :class="show ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'"
                class="transition-all duration-700">
                <h2 class="text-3xl font-bold text-center mb-12 dark:text-white">Preguntas Frecuentes</h2>

                <div class="space-y-4">
                    <!-- Q1 -->
                    <div class="border rounded-2xl overflow-hidden bg-white dark:bg-zinc-800/50 transition-colors duration-300"
                        :class="active === 1 ? 'border-red-600 shadow-lg shadow-red-600/10' : 'border-gray-200 dark:border-zinc-800 hover:border-red-600/30'">
                        <button @click="active === 1 ? active = null : active = 1"
                            class="w-full flex items-center justify-between p-6 text-left hover:bg-gray-50 dark:hover:bg-zinc-800 transition-colors">
                            <span class="font-bold text-lg transition-colors"
                                :class="active === 1 ? 'text-red-600' : 'dark:text-white'">¿Cómo verifican los
                                perfiles?</span>
                            <span class="transform transition-transform duration-300"
                                :class="active === 1 ? 'rotate-180 text-red-600' : 'text-gray-400'">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </span>
                        </button>
                        <div x-show="active === 1" x-collapse>
                            <div class="p-6 pt-0 text-gray-600 dark:text-gray-400">
                                Solicitamos foto de documento y una selfi en tiempo real con un gesto específico. Esto
                                garantiza que la persona detrás del perfil es real y coincide con las fotos publicadas.
                            </div>
                        </div>
                    </div>

                    <!-- Q2 -->
                    <div class="border rounded-2xl overflow-hidden bg-white dark:bg-zinc-800/50 transition-colors duration-300"
                        :class="active === 2 ? 'border-red-600 shadow-lg shadow-red-600/10' : 'border-gray-200 dark:border-zinc-800 hover:border-red-600/30'">
                        <button @click="active === 2 ? active = null : active = 2"
                            class="w-full flex items-center justify-between p-6 text-left hover:bg-gray-50 dark:hover:bg-zinc-800 transition-colors">
                            <span class="font-bold text-lg transition-colors"
                                :class="active === 2 ? 'text-red-600' : 'dark:text-white'">¿Es seguro navegar por el
                                sitio?</span>
                            <span class="transform transition-transform duration-300"
                                :class="active === 2 ? 'rotate-180 text-red-600' : 'text-gray-400'">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </span>
                        </button>
                        <div x-show="active === 2" x-collapse>
                            <div class="p-6 pt-0 text-gray-600 dark:text-gray-400">
                                Absolutamente. Utilizamos encriptación SSL de grado bancario y no almacenamos registros
                                de actividad de nuestros usuarios.
                            </div>
                        </div>
                    </div>

                    <!-- Q3 -->
                    <div class="border rounded-2xl overflow-hidden bg-white dark:bg-zinc-800/50 transition-colors duration-300"
                        :class="active === 3 ? 'border-red-600 shadow-lg shadow-red-600/10' : 'border-gray-200 dark:border-zinc-800 hover:border-red-600/30'">
                        <button @click="active === 3 ? active = null : active = 3"
                            class="w-full flex items-center justify-between p-6 text-left hover:bg-gray-50 dark:hover:bg-zinc-800 transition-colors">
                            <span class="font-bold text-lg transition-colors"
                                :class="active === 3 ? 'text-red-600' : 'dark:text-white'">¿Cómo contacto a una
                                escort?</span>
                            <span class="transform transition-transform duration-300"
                                :class="active === 3 ? 'rotate-180 text-red-600' : 'text-gray-400'">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </span>
                        </button>
                        <div x-show="active === 3" x-collapse>
                            <div class="p-6 pt-0 text-gray-600 dark:text-gray-400">
                                Puedes contactarlas directamente a través de WhatsApp o llamada telefónica usando los
                                botones disponibles en cada perfil. No cobramos comisión ni intermediamos.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CTA -->
            <div x-data="{ show: false }" x-intersect.once.threshold.0.1="show = true"
                class="mt-32 relative p-10 md:p-16 rounded-[2.5rem] bg-gradient-to-r from-red-600 to-black overflow-hidden transform transition-all duration-1000 border border-red-600/20"
                :class="show ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'">

                <div
                    class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10">
                </div>
                <div class="absolute -top-24 -right-24 w-96 h-96 bg-white/10 rounded-full blur-3xl animate-float"></div>
                <div
                    class="absolute -bottom-24 -left-24 w-96 h-96 bg-black/10 rounded-full blur-3xl animate-float-delayed">
                </div>

                <div
                    class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-10 text-center md:text-left">
                    <div class="text-white max-w-xl">
                        <h2 class="text-3xl md:text-5xl font-black mb-4 tracking-tight">Experiencias inolvidables te
                            esperan.</h2>
                        <p class="text-red-100 text-lg">Únete a la plataforma más exclusiva de Perú.</p>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-4 w-full md:w-auto">
                        <a href="{{ route('register') }}"
                            class="group relative bg-white text-red-600 hover:text-red-600 font-bold py-4 px-10 rounded-2xl transition-all shadow-xl hover:shadow-2xl hover:-translate-y-1 w-full md:w-auto text-center overflow-hidden">
                            <span class="relative z-10">Crear Cuenta</span>
                        </a>
                        <a href="/"
                            class="group bg-black/30 backdrop-blur-sm text-white hover:bg-black/40 font-bold py-4 px-10 rounded-2xl transition-all border border-white/20 hover:border-white/40 w-full md:w-auto text-center">
                            Ver Perfiles
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-main-layout>