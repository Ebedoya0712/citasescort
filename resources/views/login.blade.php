<x-main-layout no-hero>
    <div
        class="min-h-[calc(100vh-135px)] flex flex-col md:flex-row bg-white dark:bg-black transition-colors duration-300 overflow-hidden">
        <!-- Form Section (Left) -->
        <div class="w-full md:w-1/2 flex flex-col items-center justify-center p-4 sm:p-8 lg:p-12 overflow-y-auto">
            <div class="w-full max-w-2xl space-y-10" x-data="{ 
                    showPass: false,
                    email: '',
                    password: '',
                    isLoading: false,
                    errorMessage: '',
                    async login() {
                        this.isLoading = true;
                        this.errorMessage = '';
                        try {
                            const token = document.querySelector('meta[name=\'csrf-token\']').getAttribute('content');
                            const response = await fetch('/web-login', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json',
                                    'X-CSRF-TOKEN': token
                                },
                                body: JSON.stringify({
                                    email: this.email,
                                    password: this.password
                                })
                            });

                            const data = await response.json();

                            if (response.ok) {
                                localStorage.setItem('token', data.access_token);
                                localStorage.setItem('user', JSON.stringify(data.user));
                                
                                if (data.redirect_to) {
                                    window.location.href = data.redirect_to;
                                } else if (data.user && data.user.role === 'admin') {
                                    window.location.href = '/admin';
                                } else {
                                    window.location.href = '/dashboard';
                                }
                            } else {
                                const errorMsg = data.errors?.email?.[0] || 'Credenciales incorrectas.';
                                this.errorMessage = errorMsg;
                            }
                        } catch (error) {
                            this.errorMessage = 'Ocurrió un error. Por favor intenta más tarde.';
                            console.error('Login error:', error);
                        } finally {
                            this.isLoading = false;
                        }
                    }
                 }">
                <!-- Title -->
                <div class="space-y-1">
                    <h1 class="text-black dark:text-white text-xl font-medium tracking-tight whitespace-nowrap">Iniciar
                        sesión en la cuenta</h1>
                    <div class="w-64 h-0.5 bg-brand-pink"></div>
                    <p x-show="errorMessage" x-text="errorMessage" class="text-red-500 text-sm mt-2 animate-pulse"></p>
                </div>

                <div class="space-y-8">
                    <!-- Email -->
                    <div class="relative">
                        <input x-model="email" type="email" placeholder="Dirección de correo electrónico *"
                            class="w-full bg-transparent border-2 border-brand-pink rounded-3xl py-4.5 px-8 text-black dark:text-white placeholder-black/50 dark:placeholder-white/80 focus:border-brand-pink outline-none transition-all text-sm">
                        <div class="absolute right-8 top-1/2 -translate-y-1/2 text-black dark:text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <rect width="20" height="16" x="2" y="4" rx="2" />
                                <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7" />
                            </svg>
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="relative">
                        <input x-model="password" :type="showPass ? 'text' : 'password'" placeholder="Contraseña *"
                            class="w-full bg-transparent border-2 border-brand-pink rounded-3xl py-4.5 px-8 text-black dark:text-white placeholder-black/50 dark:placeholder-white/80 focus:border-brand-pink outline-none transition-all text-sm">
                        <div class="absolute right-8 top-1/2 -translate-y-1/2 text-black dark:text-white cursor-pointer"
                            @click="showPass = !showPass">
                            <!-- Eye Off (Hidden) -->
                            <svg x-show="!showPass" xmlns="http://www.w3.org/2000/svg" width="28" height="28"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M9.88 9.88 3.59 3.59" />
                                <path d="m21 21-6.41-6.41" />
                                <path d="M2 2l20 20" />
                                <path d="M12.42 17.1a7 7 0 0 1-7.7-7.7" />
                                <path d="M13.8 4.6a7 7 0 0 1 7.7 7.7" />
                            </svg>
                            <!-- Eye (Visible) -->
                            <svg x-show="showPass" x-cloak xmlns="http://www.w3.org/2000/svg" width="28" height="28"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path
                                    d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0z" />
                                <circle cx="12" cy="12" r="3" />
                            </svg>
                        </div>
                    </div>

                    <!-- Extra Actions: Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between">
                        <label class="flex items-center gap-4 cursor-pointer group">
                            <div class="relative flex items-center justify-center">
                                <input type="checkbox"
                                    class="peer appearance-none w-6 h-6 border-2 border-black dark:border-white bg-transparent rounded focus:ring-0 cursor-pointer checked:bg-black dark:checked:bg-white transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="4" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="absolute hidden peer-checked:block pointer-events-none text-white dark:text-black">
                                    <polyline points="20 6 9 17 4 12" />
                                </svg>
                            </div>
                            <span class="text-black dark:text-white text-sm font-medium">Acuérdate de mí</span>
                        </label>
                        <a href="{{ route('password.request') }}" class="text-brand-pink text-sm font-semibold hover:underline">Has olvidado tu
                            contraseña</a>
                    </div>
                </div>

                <div class="space-y-6">
                    <!-- Login Button -->
                    <button @click="login()" :disabled="isLoading"
                        class="w-full bg-brand-pink border-2 border-brand-pink rounded-3xl py-4 font-bold text-white hover:bg-brand-pink/90 transition-all text-lg uppercase tracking-wider flex items-center justify-center gap-2">
                        <span x-show="!isLoading">Inicia sesión en mi cuenta</span>
                        <span x-show="isLoading" x-cloak>Cargando...</span>
                        <svg x-show="isLoading" x-cloak class="animate-spin h-5 w-5 text-current"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                            </circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                    </button>

                    <!-- Create Account Button -->
                    <a href="{{ route('register') }}"
                        class="w-full border-2 border-black dark:border-white rounded-3xl py-4 font-bold text-black dark:text-white hover:bg-black dark:hover:bg-white hover:text-white dark:hover:text-black transition-all text-lg uppercase tracking-wider flex items-center justify-center">
                        Crear una nueva cuenta
                    </a>
                </div>
            </div>
        </div>

        <!-- Image Section (Right) -->
        <div class="hidden md:block w-1/2 h-full bg-gray-900 border-l border-white/10">
            <img src="{{ asset('images/modelo-ejemplo.jpg') }}" alt="Login"
                class="w-full h-full object-cover object-top">
        </div>
    </div>

    <!-- Additional Styles for Alpine x-cloak and Animations -->
    <style>
        [x-cloak] {
            display: none !important;
        }

        @keyframes fade-in {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes slide-in-from-left {
            from {
                transform: translateX(-1rem);
            }

            to {
                transform: translateX(0);
            }
        }

        .animate-in {
            animation-duration: 500ms;
            animation-fill-mode: both;
        }

        .fade-in {
            animation-name: fade-in;
        }

        .slide-in-from-left-4 {
            animation-name: slide-in-from-left;
        }
    </style>
</x-main-layout>