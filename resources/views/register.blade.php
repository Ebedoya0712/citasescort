<x-main-layout no-hero>
    <div class="min-h-[calc(100vh-140px)] flex flex-col md:flex-row bg-black transition-colors duration-300"
        x-data="{ 
            step: 1,
            showPass: false, 
            showConfirmPass: false,
            email: '',
            password: '',
            confirmPassword: '',
            name: '',
            phone: '',
            gender: 'mujer',
            category: '',
            establishment_type: '',
            role: 'user',
            terms: false,
            isLoading: false,
            errorMessage: '',
            async register() {
                this.isLoading = true;
                this.errorMessage = '';

                if (this.password !== this.confirmPassword) {
                    this.errorMessage = 'Las contraseñas no coinciden.';
                    this.isLoading = false;
                    return;
                }
                
                if (!this.terms) {
                    this.errorMessage = 'Debes aceptar los términos y condiciones.';
                    this.isLoading = false;
                    return;
                }

                try {
                    const response = await fetch('/api/auth/register', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            name: this.name,
                            email: this.email,
                            password: this.password,
                            role: this.role,
                            phone: this.phone ? ('+51' + this.phone.replace(/^\+51/, '').replace(/\D/g, '')) : '',
                            gender: this.gender,
                            category: this.category,
                            establishment_type: this.establishment_type
                        })
                    });

                    const data = await response.json();

                    if (response.ok) {
                        localStorage.setItem('token', data.authorization.token);
                        localStorage.setItem('user', JSON.stringify(data.user));
                        window.location.href = data.redirect_to || '/dashboard';
                    } else {
                        const errors = typeof data === 'string' ? JSON.parse(data) : data;
                         const errorMsg = errors.error || Object.values(errors).flat().join(', ');
                        this.errorMessage = errorMsg || 'Error al registrar. Intenta nuevamente.';
                    }
                } catch (error) {
                    console.error('Registration error:', error);
                    this.errorMessage = 'Ocurrió un error inesperado.';
                } finally {
                    this.isLoading = false;
                }
            }
        }">
        <!-- Form Section (Left) -->
        <div class="w-full md:w-1/2 flex flex-col items-center justify-center p-8 lg:p-16 py-40">
            <div class="w-full max-w-2xl space-y-16">
                 <!-- Title -->
                 <div class="space-y-4">
                     <div class="text-4xl md:text-5xl font-black tracking-widest uppercase">
                         <span class="text-red-600">CITAS</span><span class="text-white">ESCORT</span>
                     </div>
                     <div class="space-y-1">
                         <h1 class="text-white text-xl font-medium tracking-tight">Crear nueva cuenta</h1>
                         <div class="w-52 h-0.5 bg-red-600"></div>
                     </div>
                     <p x-show="errorMessage" x-text="errorMessage" class="text-red-500 text-sm mt-4 animate-pulse"></p>
                 </div>

                <!-- Step 1: Account Details -->
                <div x-show="step === 1" x-cloak class="space-y-8 animate-in fade-in slide-in-from-left-4 duration-500">

                    <!-- Role Selection Cards -->
                    <div class="space-y-3">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">¿Qué buscas en
                            Citasescort?</label>
                        <div class="grid grid-cols-2 gap-4">
                            <!-- User Role -->
                            <button @click="role = 'user'"
                                class="relative group p-4 rounded-2xl border-2 transition-all duration-300 flex flex-col items-center justify-center gap-3 text-center"
                                :class="role === 'user' 
                                    ? 'border-red-600 bg-red-600/5 dark:bg-red-600/10' 
                                    : 'border-gray-200 dark:border-zinc-800 hover:border-red-600/50 hover:bg-gray-50 dark:hover:bg-zinc-800/50'">

                                <div class="w-12 h-12 rounded-full flex items-center justify-center transition-colors duration-300"
                                    :class="role === 'user' ? 'bg-red-600 text-white shadow-lg shadow-red-600/30' : 'bg-gray-100 dark:bg-zinc-800 text-gray-500 group-hover:bg-red-600/10 group-hover:text-red-600'">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path
                                            d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z" />
                                    </svg>
                                </div>

                                <div>
                                    <span class="block font-bold text-sm transition-colors duration-300"
                                        :class="role === 'user' ? 'text-red-600' : 'text-gray-700 dark:text-gray-300'">
                                        Ver Escorts
                                    </span>
                                    <span class="text-[10px] text-gray-400 font-medium">
                                        Busco compañía
                                    </span>
                                </div>

                                <!-- Checkmark -->
                                <div x-show="role === 'user'" x-transition.scale
                                    class="absolute top-3 right-3 text-red-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <polyline points="20 6 9 17 4 12" />
                                    </svg>
                                </div>
                            </button>

                            <!-- Escort Role -->
                            <button @click="role = 'escort'"
                                class="relative group p-4 rounded-2xl border-2 transition-all duration-300 flex flex-col items-center justify-center gap-3 text-center"
                                :class="role === 'escort' 
                                    ? 'border-red-600 bg-red-600/5 dark:bg-red-600/10' 
                                    : 'border-gray-200 dark:border-zinc-800 hover:border-red-600/50 hover:bg-gray-50 dark:hover:bg-zinc-800/50'">

                                <div class="w-12 h-12 rounded-full flex items-center justify-center transition-colors duration-300"
                                    :class="role === 'escort' ? 'bg-red-600 text-white shadow-lg shadow-red-600/30' : 'bg-gray-100 dark:bg-zinc-800 text-gray-500 group-hover:bg-red-600/10 group-hover:text-red-600'">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path
                                            d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275L12 3Z" />
                                    </svg>
                                </div>

                                <div>
                                    <span class="block font-bold text-sm transition-colors duration-300"
                                        :class="role === 'escort' ? 'text-red-600' : 'text-gray-700 dark:text-gray-300'">
                                        Ser Escort
                                    </span>
                                    <span class="text-[10px] text-gray-400 font-medium">
                                        Quiero publicarme
                                    </span>
                                </div>

                                <!-- Checkmark -->
                                <div x-show="role === 'escort'" x-transition.scale
                                    class="absolute top-3 right-3 text-red-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <polyline points="20 6 9 17 4 12" />
                                    </svg>
                                </div>
                            </button>

                            <!-- Establishment Role -->
                            <button @click="role = 'establishment'"
                                class="relative group p-4 rounded-2xl border-2 transition-all duration-300 flex flex-col items-center justify-center gap-3 text-center sm:col-span-2 md:col-span-1"
                                :class="role === 'establishment' 
                                    ? 'border-red-600 bg-red-600/5 dark:bg-red-600/10' 
                                    : 'border-gray-200 dark:border-zinc-800 hover:border-red-600/50 hover:bg-gray-50 dark:hover:bg-zinc-800/50'">

                                <div class="w-12 h-12 rounded-full flex items-center justify-center transition-colors duration-300"
                                    :class="role === 'establishment' ? 'bg-red-600 text-white shadow-lg shadow-red-600/30' : 'bg-gray-100 dark:bg-zinc-800 text-gray-500 group-hover:bg-red-600/10 group-hover:text-red-600'">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M3 21h18" />
                                        <path d="M9 8h1" />
                                        <path d="M9 12h1" />
                                        <path d="M9 16h1" />
                                        <path d="M14 8h1" />
                                        <path d="M14 12h1" />
                                        <path d="M14 16h1" />
                                        <path d="M5 21V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16" />
                                    </svg>
                                </div>

                                <div>
                                    <span class="block font-bold text-sm transition-colors duration-300"
                                        :class="role === 'establishment' ? 'text-red-600' : 'text-gray-700 dark:text-gray-300'">
                                        Establecimiento
                                    </span>
                                    <span class="text-[10px] text-gray-400 font-medium whitespace-nowrap">
                                        Masajes, Whiskería...
                                    </span>
                                </div>

                                <!-- Checkmark -->
                                <div x-show="role === 'establishment'" x-transition.scale
                                    class="absolute top-3 right-3 text-red-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <polyline points="20 6 9 17 4 12" />
                                    </svg>
                                </div>
                            </button>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <!-- Email -->
                        <div class="relative">
                            <input x-model="email" type="email" placeholder="Dirección de correo electrónico *"
                                class="w-full bg-transparent border-2 border-red-600 rounded-3xl py-4.5 px-8 text-white placeholder-white/80 focus:border-red-600 outline-none transition-all text-sm">
                            <div class="absolute right-8 top-1/2 -translate-y-1/2 text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
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
                                class="w-full bg-transparent border-2 border-red-600 rounded-3xl py-4.5 px-8 text-white placeholder-white/80 focus:border-red-600 outline-none transition-all text-sm">
                            <div class="absolute right-8 top-1/2 -translate-y-1/2 text-white cursor-pointer"
                                @click="showPass = !showPass">
                                <svg x-show="!showPass" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M9.88 9.88 3.59 3.59" />
                                    <path d="m21 21-6.41-6.41" />
                                    <path d="M2 2l20 20" />
                                    <path d="M12.42 17.1a7 7 0 0 1-7.7-7.7" />
                                    <path d="M13.8 4.6a7 7 0 0 1 7.7 7.7" />
                                </svg>
                                <svg x-show="showPass" x-cloak xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path
                                        d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0z" />
                                    <circle cx="12" cy="12" r="3" />
                                </svg>
                            </div>
                        </div>

                        <!-- Confirm Password -->
                        <div class="relative">
                            <input x-model="confirmPassword" :type="showConfirmPass ? 'text' : 'password'"
                                placeholder="Confirmar Contraseña *"
                                class="w-full bg-transparent border-2 border-red-600 rounded-3xl py-4.5 px-8 text-white placeholder-white/80 focus:border-red-600 outline-none transition-all text-sm">
                            <div class="absolute right-8 top-1/2 -translate-y-1/2 text-white cursor-pointer"
                                @click="showConfirmPass = !showConfirmPass">
                                <svg x-show="!showConfirmPass" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M9.88 9.88 3.59 3.59" />
                                    <path d="m21 21-6.41-6.41" />
                                    <path d="M2 2l20 20" />
                                    <path d="M12.42 17.1a7 7 0 0 1-7.7-7.7" />
                                    <path d="M13.8 4.6a7 7 0 0 1 7.7 7.7" />
                                </svg>
                                <svg x-show="showConfirmPass" x-cloak xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path
                                        d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0z" />
                                    <circle cx="12" cy="12" r="3" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <button @click="step = 2"
                            class="w-full border-2 border-red-600 rounded-3xl py-4 font-bold text-red-600 hover:bg-red-600 hover:text-white transition-all text-lg flex items-center justify-center gap-2 group">
                            Siguiente <span class="transition-transform group-hover:translate-x-1">></span>
                        </button>
                        <p class="text-gray-400 text-sm mt-4 text-center">
                            ¿Ya tienes una cuenta?
                            <a href="{{ route('login') }}" class="text-red-600 hover:underline font-bold">Inicia
                                sesión aquí</a>
                        </p>
                    </div>
                </div>

                <!-- Step 2: Details -->
                <div x-show="step === 2" x-cloak
                    class="space-y-8 animate-in fade-in slide-in-from-right-4 duration-500">
                    <div class="space-y-8">

                        <!-- Name is for everyone -->
                        <div class="relative">
                            <input x-model="name" type="text"
                                :placeholder="role === 'escort' ? 'Nombre Artístico *' : (role === 'establishment' ? 'Nombre del Establecimiento *' : 'Nombre de Usuario *')"
                                class="w-full bg-transparent border-2 border-red-600 rounded-3xl py-4.5 px-8 text-white placeholder-white/80 focus:border-red-600 outline-none transition-all text-sm">
                        </div>

                        <!-- Escort Specific Fields -->
                        <template x-if="role === 'escort'">
                            <div class="space-y-8">


                                <div class="flex items-center w-full bg-transparent border-2 border-red-600 rounded-3xl overflow-hidden focus-within:border-red-600 transition-all">
                                    <div class="flex items-center gap-2 pl-6 pr-3 border-r border-red-600/30 text-white font-bold text-sm select-none">
                                        <svg class="w-5 h-3.5 rounded-sm shadow-sm object-cover" viewBox="0 0 9 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <rect width="3" height="6" fill="#D91414"/>
                                            <rect x="3" width="3" height="6" fill="#F5F5F5"/>
                                            <rect x="6" width="3" height="6" fill="#D91414"/>
                                        </svg>
                                        <span>+51</span>
                                    </div>
                                    <input x-model="phone" type="tel" placeholder="Celular de trabajo *"
                                        class="w-full bg-transparent py-4.5 px-4 text-white placeholder-white/80 outline-none text-sm">
                                </div>

                                <div class="relative">
                                    <select x-model="category"
                                        class="w-full bg-transparent border-2 border-red-600 rounded-3xl py-4.5 px-8 text-white focus:border-red-600 outline-none appearance-none transition-all text-sm">
                                        <option value="" class="bg-black text-gray-500">¿Qué tipo de
                                            escort eres? *</option>
                                        <option value="escort" class="bg-black">Escort</option>
                                        <option value="masajista" class="bg-black">Masajista</option>
                                        <option value="acompanante" class="bg-black">Acompañante</option>
                                    </select>
                                    <div
                                        class="absolute right-8 top-1/2 -translate-y-1/2 text-red-600 pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="4"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path d="m6 9 6 6 6-6" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </template>

                        <!-- Establishment Specific Fields -->
                        <template x-if="role === 'establishment'">
                            <div class="space-y-8">
                                <div class="flex items-center w-full bg-transparent border-2 border-red-600 rounded-3xl overflow-hidden focus-within:border-red-600 transition-all">
                                    <div class="flex items-center gap-2 pl-6 pr-3 border-r border-red-600/30 text-white font-bold text-sm select-none">
                                        <svg class="w-5 h-3.5 rounded-sm shadow-sm object-cover" viewBox="0 0 9 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <rect width="3" height="6" fill="#D91414"/>
                                            <rect x="3" width="3" height="6" fill="#F5F5F5"/>
                                            <rect x="6" width="3" height="6" fill="#D91414"/>
                                        </svg>
                                        <span>+51</span>
                                    </div>
                                    <input x-model="phone" type="tel" placeholder="Teléfono del establecimiento *"
                                        class="w-full bg-transparent py-4.5 px-4 text-white placeholder-white/80 outline-none text-sm">
                                </div>

                                <div class="relative">
                                    <select x-model="establishment_type"
                                        class="w-full bg-transparent border-2 border-red-600 rounded-3xl py-4.5 px-8 text-white focus:border-red-600 outline-none appearance-none transition-all text-sm">
                                        <option value="" class="bg-black text-gray-500">¿Qué tipo de
                                            establecimiento tienes? *</option>
                                        <option value="massage" class="bg-black">Casa de Masajes</option>
                                        <option value="whiskeria" class="bg-black">Whiskería</option>
                                        <option value="motel" class="bg-black">Motel / Hotel</option>
                                    </select>
                                    <div
                                        class="absolute right-8 top-1/2 -translate-y-1/2 text-red-600 pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="4"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path d="m6 9 6 6 6-6" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </template>

                        <!-- Age Agreement -->
                        <label class="flex items-center gap-4 cursor-pointer group">
                            <div class="relative flex items-center justify-center">
                                <input x-model="terms" type="checkbox"
                                    class="peer appearance-none w-6 h-6 border-2 border-white bg-transparent rounded focus:ring-0 cursor-pointer checked:bg-white transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="4" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="absolute hidden peer-checked:block pointer-events-none text-black">
                                    <polyline points="20 6 9 17 4 12" />
                                </svg>
                            </div>
                            <span class="text-white text-sm font-medium">Soy mayor de edad y acepto los
                                términos y condiciones *</span>
                        </label>
                    </div>

                    <div class="space-y-4">
                        <button @click="register()" :disabled="isLoading"
                            class="w-full bg-red-600 border-2 border-red-600 rounded-3xl py-4 font-bold text-white hover:bg-red-600/90 transition-all text-lg disabled:opacity-50 disabled:cursor-not-allowed">
                            <span x-show="!isLoading">Registrarme</span>
                            <span x-show="isLoading" class="animate-pulse">Registrando...</span>
                        </button>
                        <button @click="step = 1"
                            class="w-full text-gray-500 text-xs hover:text-white transition-colors underline underline-offset-4">
                            Volver al paso anterior
                        </button>
                        <p class="text-gray-400 text-sm mt-4 text-center">
                            ¿Ya tienes una cuenta?
                            <a href="{{ route('login') }}" class="text-red-600 hover:underline font-bold">Inicia
                                sesión aquí</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Image Section (Right) -->
        <div class="hidden md:block w-1/2 h-full bg-gray-900">
            <img src="{{ asset('images/modelo-ejemplo.jpg') }}" alt="Registration" class="w-full h-full object-cover">
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

        @keyframes slide-in-from-right {
            from {
                transform: translateX(1rem);
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

        .slide-in-from-right-4 {
            animation-name: slide-in-from-right;
        }
    </style>
</x-main-layout>