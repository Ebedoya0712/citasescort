<x-main-layout>
    <!-- Background pattern -->
    <div class="bg-gray-50 dark:bg-[#111] min-h-screen relative font-sans flex items-center justify-center py-20 px-4 sm:px-6 lg:px-8 transition-colors duration-300"
        style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%232a2a2e\' fill-opacity=\'0.2\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');">

        <div
            class="relative z-10 max-w-2xl w-full bg-white dark:bg-[#1c1c1e] p-8 md:p-12 rounded-2xl border border-gray-200 dark:border-[#2c2c2e] shadow-[0_10px_40px_rgba(0,0,0,0.1)] dark:shadow-[0_10px_40px_rgba(0,0,0,0.8)] transition-colors duration-300">

            <!-- Header -->
            <div class="text-center mb-10">
                <span
                    class="inline-block px-4 py-1.5 rounded-full border border-[#e11d48]/30 bg-[#e11d48]/10 text-[#e11d48] text-sm font-bold tracking-widest uppercase mb-4">
                    Contacto
                </span>
                <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 dark:text-white mb-4">
                    ¡Hablemos!
                </h1>
                <p class="text-gray-600 dark:text-gray-400 text-lg">
                    Déjanos tu mensaje y te responderemos a la brevedad.
                </p>
                <!-- Divider -->
                <div class="w-16 h-1 bg-[#e11d48] mx-auto mt-6 rounded-full"></div>
            </div>

            <!-- Success Message -->
            @if(session('success'))
                <div
                    class="bg-green-500/10 border border-green-500/30 text-green-400 rounded-xl p-4 mb-8 text-center flex items-center justify-center gap-2 font-medium">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                        <polyline points="22 4 12 14.01 9 11.01" />
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            <!-- Form -->
            <form action="{{ route('contact.store') }}" method="POST" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Name -->
                    <div class="space-y-2">
                        <label for="name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 ml-1">
                            Nombre
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                            </div>
                            <input id="name" name="name" type="text" autocomplete="name" required
                                class="block w-full pl-11 pr-4 py-3.5 bg-gray-50 dark:bg-[#111] border border-gray-300 dark:border-[#333] rounded-xl text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-[#e11d48] focus:border-transparent transition-all"
                                placeholder="Tu nombre completo">
                        </div>
                        @error('name')
                            <p class="text-[#e11d48] text-xs font-medium ml-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="space-y-2">
                        <label for="email" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 ml-1">
                            E-mail
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path
                                        d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z">
                                    </path>
                                    <polyline points="22,6 12,13 2,6"></polyline>
                                </svg>
                            </div>
                            <input id="email" name="email" type="email" autocomplete="email" required
                                class="block w-full pl-11 pr-4 py-3.5 bg-gray-50 dark:bg-[#111] border border-gray-300 dark:border-[#333] rounded-xl text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-[#e11d48] focus:border-transparent transition-all"
                                placeholder="tu@correo.com">
                        </div>
                        @error('email')
                            <p class="text-[#e11d48] text-xs font-medium ml-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Phone -->
                <div class="space-y-2">
                    <label for="phone" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 ml-1">
                        Teléfono <span class="text-gray-500 font-normal">(Opcional)</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path
                                    d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z">
                                </path>
                            </svg>
                        </div>
                        <input id="phone" name="phone" type="tel" autocomplete="tel"
                            class="block w-full pl-11 pr-4 py-3.5 bg-gray-50 dark:bg-[#111] border border-gray-300 dark:border-[#333] rounded-xl text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-[#e11d48] focus:border-transparent transition-all"
                            placeholder="Ej. 999 123 456">
                    </div>
                    @error('phone')
                        <p class="text-[#e11d48] text-xs font-medium ml-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Message -->
                <div class="space-y-2">
                    <label for="message" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 ml-1">
                        Mensaje
                    </label>
                    <div class="relative">
                        <div class="absolute top-4 left-0 pl-4 flex items-start pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                            </svg>
                        </div>
                        <textarea id="message" name="message" rows="5" required
                            class="block w-full pl-11 pr-4 py-3.5 bg-gray-50 dark:bg-[#111] border border-gray-300 dark:border-[#333] rounded-xl text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-[#e11d48] focus:border-transparent transition-all resize-y"
                            placeholder="¿En qué podemos ayudarte?"></textarea>
                    </div>
                    @error('message')
                        <p class="text-[#e11d48] text-xs font-medium ml-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="pt-4">
                    <button type="submit"
                        class="w-full flex justify-center items-center py-4 px-8 rounded-xl text-base font-bold uppercase tracking-wider text-white bg-gradient-to-r from-[#e11d48] to-[#000000] hover:from-[#f43f5e] hover:to-[#18181b] shadow-[0_0_20px_rgba(225,29,72,0.3)] border border-[#e11d48]/20 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-[0_0_30px_rgba(225,29,72,0.5)]">
                        <span>Enviar Mensaje</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </form>

            <p class="text-center text-gray-500 text-xs mt-8">
                Al enviar este formulario, aceptas nuestra Política de Privacidad y Términos de Uso.
            </p>
        </div>
</x-main-layout>