<x-main-layout no-hero>
    <div class="min-h-[calc(100vh-135px)] flex flex-col items-center justify-center bg-white dark:bg-black transition-colors duration-300 px-4 py-12 relative overflow-hidden">
        
        <!-- Fondo decorativo (glow) -->
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-red-600/10 rounded-full blur-[120px] pointer-events-none"></div>

        <div class="w-full max-w-2xl relative z-10 flex flex-col items-center">
            
            <a href="/" class="inline-flex items-center gap-0.5 font-black text-4xl tracking-tighter select-none mb-10">
                <span class="text-red-600">CITAS</span><span class="text-white">ESCORT</span>
            </a>

            <!-- Card -->
            <div class="w-full bg-zinc-900/80 backdrop-blur-xl border border-zinc-800 rounded-[2rem] p-8 md:p-14 shadow-[0_0_50px_-12px_rgba(255,42,122,0.15)]">
                
                <!-- Header -->
                <div class="text-center mb-10">
                    <h1 class="text-3xl md:text-4xl font-bold text-white mb-4 tracking-tight">Restablecer Contraseña</h1>
                    <p class="text-gray-400 text-base md:text-lg leading-relaxed max-w-lg mx-auto">
                        Ingresa tu nueva contraseña para acceder nuevamente a tu cuenta en Citasescort.
                    </p>
                </div>

                <!-- Error Message -->
                @if($errors->any())
                    <div class="mb-8 bg-red-500/10 border border-red-500/30 rounded-2xl p-5 flex items-start gap-4">
                        <svg class="w-6 h-6 text-red-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        <div>
                            @foreach($errors->all() as $error)
                                <p class="text-red-400 text-base font-medium">{{ $error }}</p>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Form -->
                <form method="POST" action="{{ route('password.update') }}" class="space-y-8" x-data="{ showPass: false, showConfirm: false }">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-base font-medium text-gray-300 mb-3">Correo electrónico</label>
                        <div class="relative">
                            <input type="email" id="email" name="email" value="{{ $email ?? old('email') }}" required readonly
                                class="w-full bg-black/30 border border-zinc-800 text-gray-500 rounded-2xl px-5 py-4 pl-14 text-lg outline-none cursor-not-allowed">
                            <svg class="absolute left-5 top-1/2 -translate-y-1/2 w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    </div>

                    <!-- New Password -->
                    <div>
                        <label for="password" class="block text-base font-medium text-gray-300 mb-3">Nueva contraseña</label>
                        <div class="relative">
                            <input :type="showPass ? 'text' : 'password'" id="password" name="password" required autofocus
                                placeholder="Mínimo 8 caracteres"
                                class="w-full bg-black/50 border border-zinc-700 text-white rounded-2xl px-5 py-4 pl-14 pr-12 text-lg focus:ring-2 focus:ring-red-600 focus:border-transparent outline-none transition-all placeholder-gray-600">
                            <svg class="absolute left-5 top-1/2 -translate-y-1/2 w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                            <!-- Toggle Button -->
                            <button type="button" @click="showPass = !showPass" class="absolute right-5 top-1/2 -translate-y-1/2 text-gray-500 hover:text-red-600 transition-colors cursor-pointer">
                                <!-- Eye Icon -->
                                <svg x-show="!showPass" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                <!-- Eye Slash Icon -->
                                <svg x-show="showPass" style="display: none;" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-base font-medium text-gray-300 mb-3">Confirmar contraseña</label>
                        <div class="relative">
                            <input :type="showConfirm ? 'text' : 'password'" id="password_confirmation" name="password_confirmation" required
                                placeholder="Repite tu nueva contraseña"
                                class="w-full bg-black/50 border border-zinc-700 text-white rounded-2xl px-5 py-4 pl-14 pr-12 text-lg focus:ring-2 focus:ring-red-600 focus:border-transparent outline-none transition-all placeholder-gray-600">
                            <svg class="absolute left-5 top-1/2 -translate-y-1/2 w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                            <!-- Toggle Button -->
                            <button type="button" @click="showConfirm = !showConfirm" class="absolute right-5 top-1/2 -translate-y-1/2 text-gray-500 hover:text-red-600 transition-colors cursor-pointer">
                                <!-- Eye Icon -->
                                <svg x-show="!showConfirm" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                <!-- Eye Slash Icon -->
                                <svg x-show="showConfirm" style="display: none;" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                        class="w-full bg-red-600 border-2 border-red-600 rounded-2xl py-4 font-bold text-white hover:bg-red-600/90 transition-all text-lg uppercase tracking-wider flex items-center justify-center gap-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Guardar Contraseña
                    </button>
                </form>

                <!-- Back to login -->
                <div class="mt-10 text-center">
                    <a href="{{ route('login') }}" class="text-gray-400 text-base font-medium hover:text-red-600 transition-colors inline-flex items-center gap-2 group">
                        <svg class="w-5 h-5 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Cancelar y volver al login
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-main-layout>

