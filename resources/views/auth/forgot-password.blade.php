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
                    <h1 class="text-3xl md:text-4xl font-bold text-white mb-4 tracking-tight">¿Olvidaste tu contraseña?</h1>
                    <p class="text-gray-400 text-base md:text-lg leading-relaxed max-w-lg mx-auto">
                        No te preocupes. Ingresa tu correo electrónico y te enviaremos un enlace seguro para restablecer tu contraseña inmediatamente.
                    </p>
                </div>

                <!-- Success Message -->
                @if(session('status'))
                    <div class="mb-8 bg-green-500/10 border border-green-500/30 rounded-2xl p-5 flex items-start gap-4">
                        <svg class="w-6 h-6 text-green-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <p class="text-green-400 text-base font-medium">{{ session('status') }}</p>
                    </div>
                @endif

                <!-- Error Message -->
                @if($errors->any())
                    <div class="mb-8 bg-red-500/10 border border-red-500/30 rounded-2xl p-5 flex items-start gap-4">
                        <svg class="w-6 h-6 text-red-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        <p class="text-red-400 text-base font-medium">{{ $errors->first() }}</p>
                    </div>
                @endif

                <!-- Form -->
                <form method="POST" action="{{ route('password.email') }}" class="space-y-8">
                    @csrf

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-base font-medium text-gray-300 mb-3">Tu Correo Electrónico</label>
                        <div class="relative">
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                                placeholder="ejemplo@correo.com"
                                class="w-full bg-black/50 border border-zinc-700 text-white rounded-2xl px-5 py-4 pl-14 text-lg focus:ring-2 focus:ring-red-600 focus:border-transparent outline-none transition-all placeholder-gray-600">
                            <svg class="absolute left-5 top-1/2 -translate-y-1/2 w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                        class="w-full bg-red-600 border-2 border-red-600 rounded-2xl py-4 font-bold text-white cursor-pointer hover:bg-red-600/90 hover:shadow-[0_0_20px_rgba(255,42,122,0.4)] active:scale-95 transition-all duration-200 text-lg uppercase tracking-wider flex items-center justify-center gap-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                        Enviar enlace de recuperación
                    </button>
                </form>

                <!-- Back to login -->
                <div class="mt-10 text-center">
                    <a href="{{ route('login') }}" class="text-gray-400 text-base font-medium hover:text-red-600 transition-colors inline-flex items-center gap-2 group">
                        <svg class="w-5 h-5 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Volver a iniciar sesión
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-main-layout>
