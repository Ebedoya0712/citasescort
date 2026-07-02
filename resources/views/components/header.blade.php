<header class="bg-white dark:bg-brand-dark text-black dark:text-white px-4 lg:px-8 transition-colors duration-300">
    <div class="max-w-7xl mx-auto flex items-center justify-between h-20">
        <!-- Left Side: Logo & Theme Switcher -->
        <div class="flex items-center gap-6">
            <a href="/" class="flex items-center gap-0.5 font-black text-2xl tracking-tighter select-none">
                @if(config('settings.site_logo'))
                    <img src="{{ asset('storage/' . config('settings.site_logo')) }}" alt="{{ config('settings.site_name', 'CITASESCORTS') }}" class="h-10 w-auto object-contain">
                @else
                    @if(config('settings.site_name'))
                        @php
                            $name = config('settings.site_name');
                            $splitAt = min(5, strlen($name));
                        @endphp
                        <span class="text-brand-pink">{{ strtoupper(substr($name, 0, $splitAt)) }}</span><span class="text-black dark:text-white">{{ strtoupper(substr($name, $splitAt)) }}</span>
                    @else
                        <span class="text-brand-pink">CITAS</span><span class="text-black dark:text-white">ESCORTS</span>
                    @endif
                @endif
            </a>

            <!-- Luxury Minimal Theme Switcher (Pink Pill) -->
            {{-- 
            <div x-data="{ 
                dark: document.documentElement.classList.contains('dark'),
                toggle() {
                    const newTheme = document.documentElement.classList.contains('dark') ? 'light' : 'dark';
                    window.applyTheme(newTheme);
                    this.dark = (newTheme === 'dark');
                }
            }" class="relative flex items-center rounded-full cursor-pointer transition-all duration-300 w-12 h-6 select-none shadow-sm"
                style="background-color: var(--color-brand-pink) !important; border-radius: 9999px !important;" @click="toggle()">

                <!-- The Toggle Button (Thumb) -->
                <!-- Use dynamic background: White in Light mode, Black in Dark mode -->
                <div class="absolute top-0.5 left-0.5 w-5 h-5 rounded-full shadow-sm transform transition-all duration-300 ease-[cubic-bezier(0.4,0,0.2,1)] z-20"
                    style="border-radius: 50%;" :class="dark ? 'translate-x-6 bg-black' : 'translate-x-0 bg-white'">
                </div>

                <!-- Icons Background -->
                <div class="absolute inset-0 flex items-center justify-between px-1 z-10 pointer-events-none">
                    <!-- Moon Icon (Visible when Dark - Thumb is Right) -->
                    <!-- Outline style to match reference -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 text-white" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="3">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                    </svg>

                    <!-- Sun Icon (Visible when Light - Thumb is Left) -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-white" viewBox="0 0 24 24"
                        fill="currentColor">
                        <path
                            d="M12 7a5 5 0 100 10 5 5 0 000-10zM12 1a1 1 0 011 1v2a1 1 0 11-2 0V2a1 1 0 011-1zm0 18a1 1 0 011 1v2a1 1 0 11-2 0v-2a1 1 0 011-1zm10-8a1 1 0 01-1 1h-2a1 1 0 110-2h2a1 1 0 011 1zM5 12a1 1 0 01-1 1H2a1 1 0 110-2h2a1 1 0 011 1zm13.364-7.778a1 1 0 010 1.414l-1.414 1.414a1 1 0 11-1.414-1.414l1.414-1.414a1 1 0 011.414 0zM7.05 16.95a1 1 0 010 1.414l-1.414 1.414a1 1 0 11-1.414-1.414l1.414-1.414a1 1 0 010 1.414zm11.314 1.414a1 1 0 01-1.414 0l-1.414-1.414a1 1 0 111.414-1.414l1.414 1.414a1 1 0 010 1.414zM5.636 5.636a1 1 0 011.414 0l1.414 1.414a1 1 0 01-1.414 1.414L5.636 7.05a1 1 0 010-1.414z" />
                    </svg>
                </div>
            </div>
            --}}
        </div>

        <!-- Center: Navigation Menu -->
        <nav class="hidden xl:flex items-center gap-6 whitespace-nowrap">
            <a href="{{ route('why-choose-us') }}"
                class="flex items-center gap-2 text-sm font-medium hover:text-brand-pink transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polygon
                        points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
                </svg>
                ¿Por qué elegirnos?
            </a>
            <a href="{{ route('escorts.index') }}"
                class="flex items-center gap-2 text-sm font-medium hover:text-brand-pink transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                    <circle cx="9" cy="7" r="4" />
                    <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                    <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                </svg>
                Escorts
            </a>
            <a href="{{ route('posts.index') }}"
                class="flex items-center gap-2 text-sm font-medium hover:text-brand-pink transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path
                        d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 1-2 2Zm0 0a2 2 0 0 1-2-2v-9c0-1.1.9-2 2-2h2" />
                    <path d="M18 14h-8" />
                    <path d="M15 18h-5" />
                    <path d="M10 6h8v4h-8Z" />
                </svg>
                Noticias
            </a>
            <a href="{{ route('establishments.index') }}"
                class="flex items-center gap-2 text-sm font-medium hover:text-brand-pink transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                    <polyline points="9 22 9 12 15 12 15 22" />
                </svg>
                Establecimientos
            </a>
            <a href="{{ route('contact.index') }}"
                class="flex items-center gap-2 text-sm font-medium hover:text-brand-pink transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path
                        d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z" />
                </svg>
                Contacto
            </a>
        </nav>

        <!-- Right Side: Account, Search, Register -->
        <div class="flex items-center gap-3 lg:gap-6">
            @auth
                <div x-data="{ open: false }" class="relative" @click.outside="open = false">
                    <button @click="open = !open"
                        class="flex items-center gap-2 text-sm font-medium hover:text-brand-pink transition-colors whitespace-nowrap focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                            <circle cx="12" cy="7" r="4" />
                        </svg>
                        <span>{{ Auth::user()->name }}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="transition-transform duration-200" :class="open ? 'rotate-180' : ''">
                            <polyline points="6 9 12 15 18 9"></polyline>
                        </svg>
                    </button>

                    <!-- Dropdown Menu -->
                    <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="transform opacity-0 scale-95"
                        x-transition:enter-end="transform opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="transform opacity-100 scale-100"
                        x-transition:leave-end="transform opacity-0 scale-95"
                        class="absolute right-0 mt-2 w-48 bg-white dark:bg-zinc-900 rounded-lg shadow-lg py-1 border border-gray-100 dark:border-zinc-800 z-50">

                        <a href="{{ Auth::user()->isAdmin() ? route('filament.admin.pages.dashboard') : (Auth::user()->isEscort() ? route('filament.escort.pages.dashboard') : (Auth::user()->isEstablishment() ? route('filament.establishment.pages.dashboard') : route('user.dashboard'))) }}"
                            class="flex items-center gap-2 px-4 py-3 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-zinc-800 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                                <circle cx="12" cy="7" r="4" />
                            </svg>
                            Mi Perfil
                        </a>

                        <div class="h-px bg-gray-100 dark:bg-zinc-800 my-1"></div>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full flex items-center gap-2 text-left px-4 py-3 text-sm text-red-600 hover:bg-gray-100 dark:hover:bg-zinc-800 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                                    <polyline points="16 17 21 12 16 7" />
                                    <line x1="21" y1="12" x2="9" y2="12" />
                                </svg>
                                Cerrar Sesión
                            </button>
                        </form>
                    </div>
                </div>
            @endauth

            <div x-data class="relative flex items-center">
                <button @click="$dispatch('open-filters')" class="hover:text-brand-pink transition-colors focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8" />
                        <path d="m21 21-4.3-4.3" />
                    </svg>
                </button>
            </div>

            @guest
                <div class="flex items-center gap-2">
                    <a href="{{ route('login') }}"
                        class="border border-brand-pink text-brand-pink hover:bg-brand-pink hover:text-white transition-all font-bold px-3 py-2 rounded-md uppercase text-[10px] tracking-widest whitespace-nowrap">
                        Ingresar
                    </a>
                    <a href="{{ route('register') }}"
                        class="bg-brand-pink hover:bg-opacity-90 transition-all font-bold px-3 py-2 rounded-md uppercase text-[10px] tracking-widest whitespace-nowrap text-white">
                        Registrarse
                    </a>
                </div>
            @endguest
        </div>

        <!-- Mobile Menu Button (Hamburger) -->
        <button class="xl:hidden">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="4" x2="20" y1="12" y2="12" />
                <line x1="4" x2="20" y1="6" y2="6" />
                <line x1="4" x2="20" y1="18" y2="18" />
            </svg>
        </button>
    </div>
</header>