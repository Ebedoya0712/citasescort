@php
    $hasNewPosts = \App\Models\Post::where('is_published', true)
        ->where('created_at', '>=', now()->subDays(7))
        ->exists();
@endphp
<style>
    @keyframes custom-ping {
        75%, 100% { transform: scale(2); opacity: 0; }
    }
    .custom-animate-ping { animation: custom-ping 1s cubic-bezier(0, 0, 0.2, 1) infinite; }
</style>
<header class="bg-brand-dark text-white px-4 lg:px-8 transition-colors duration-300" x-data="{ mobileMenu: false }">
    <div class="max-w-7xl mx-auto flex items-center justify-between h-16 md:h-20">
        <!-- Left Side: Logo -->
        <div class="flex items-center gap-4 md:gap-6 shrink-0">
            <a href="/" class="flex items-center gap-0.5 font-black text-xl md:text-2xl tracking-tighter select-none">
                @if(config('settings.site_logo'))
                    <img src="{{ asset('storage/' . config('settings.site_logo')) }}" alt="{{ config('settings.site_name', 'CITASESCORTS') }}" class="h-8 md:h-10 w-auto object-contain">
                @else
                    @if(config('settings.site_name'))
                        @php
                            $name = config('settings.site_name');
                            $splitAt = min(5, strlen($name));
                        @endphp
                        <span class="text-red-600">{{ strtoupper(substr($name, 0, $splitAt)) }}</span><span class="text-white">{{ strtoupper(substr($name, $splitAt)) }}</span>
                    @else
                        <span class="text-red-600">CITAS</span><span class="text-white">ESCORTS</span>
                    @endif
                @endif
            </a>
        </div>

        <!-- Center: Navigation Menu (Desktop only) -->
        <nav class="hidden xl:flex items-center gap-6 whitespace-nowrap">
            <a href="{{ route('why-choose-us') }}"
                class="flex items-center gap-2 text-sm font-medium hover:text-red-600 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polygon
                        points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
                </svg>
                ¿Por qué elegirnos?
            </a>
            <a href="{{ route('escorts.index') }}"
                class="flex items-center gap-2 text-sm font-medium hover:text-red-600 transition-colors">
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
                class="flex items-center gap-2 text-sm font-medium hover:text-red-600 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path
                        d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 1-2 2Zm0 0a2 2 0 0 1-2-2v-9c0-1.1.9-2 2-2h2" />
                    <path d="M18 14h-8" />
                    <path d="M15 18h-5" />
                    <path d="M10 6h8v4h-8Z" />
                </svg>
                <div class="flex items-center gap-1.5">
                    Noticias
                    @if($hasNewPosts)
                        <span class="relative flex h-2 w-2">
                            <span class="custom-animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-red-600"></span>
                        </span>
                    @endif
                </div>
            </a>
            {{--
            <a href="{{ route('establishments.index') }}"
                class="flex items-center gap-2 text-sm font-medium hover:text-red-600 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                    <polyline points="9 22 9 12 15 12 15 22" />
                </svg>
                Establecimientos
            </a>
            --}}
            <a href="{{ route('contact.index') }}"
                class="flex items-center gap-2 text-sm font-medium hover:text-red-600 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path
                        d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z" />
                </svg>
                Contacto
            </a>
        </nav>

        <!-- Right Side: Account, Search, Register, Hamburger -->
        <div class="flex items-center gap-2 md:gap-4">
            @auth
                <div x-data="{ open: false }" class="relative" @click.outside="open = false">
                    <button @click="open = !open"
                        class="flex items-center gap-1 md:gap-2 text-sm font-medium hover:text-red-600 transition-colors whitespace-nowrap focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                            <circle cx="12" cy="7" r="4" />
                        </svg>
                        <span class="hidden sm:inline max-w-[100px] truncate">{{ Auth::user()->name }}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="transition-transform duration-200 hidden sm:block" :class="open ? 'rotate-180' : ''">
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
                        class="absolute right-0 mt-2 w-48 bg-zinc-900 rounded-lg shadow-lg py-1 border border-zinc-800 z-50">

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
                <button @click="$dispatch('open-filters')" class="hover:text-red-600 transition-colors focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8" />
                        <path d="m21 21-4.3-4.3" />
                    </svg>
                </button>
            </div>

            @guest
                <div class="hidden sm:flex items-center gap-2">
                    <a href="{{ route('login') }}"
                        class="border border-red-600 text-red-600 hover:bg-red-600 hover:text-white transition-all font-bold px-3 py-2 rounded-md uppercase text-[10px] tracking-widest whitespace-nowrap">
                        Ingresar
                    </a>
                    <a href="{{ route('register') }}"
                        class="bg-red-600 hover:bg-opacity-90 transition-all font-bold px-3 py-2 rounded-md uppercase text-[10px] tracking-widest whitespace-nowrap text-white">
                        Registrarse
                    </a>
                </div>
            @endguest

            <!-- Mobile Menu Button (Hamburger) -->
            <button @click="mobileMenu = !mobileMenu" class="xl:hidden p-1 focus:outline-none" aria-label="Menú">
                <svg x-show="!mobileMenu" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="4" x2="20" y1="12" y2="12" />
                    <line x1="4" x2="20" y1="6" y2="6" />
                    <line x1="4" x2="20" y1="18" y2="18" />
                </svg>
                <svg x-show="mobileMenu" x-cloak xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18" />
                    <line x1="6" y1="6" x2="18" y2="18" />
                </svg>
            </button>
        </div>
    </div>

    <!-- Mobile Navigation Menu -->
    <div x-show="mobileMenu" x-cloak
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-2"
        class="xl:hidden border-t border-gray-200 dark:border-zinc-800 pb-4">
        <nav class="flex flex-col gap-1 pt-3">
            <a href="{{ route('why-choose-us') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium hover:text-red-600 hover:bg-gray-50 dark:hover:bg-zinc-900 rounded-lg transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" /></svg>
                ¿Por qué elegirnos?
            </a>
            <a href="{{ route('escorts.index') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium hover:text-red-600 hover:bg-gray-50 dark:hover:bg-zinc-900 rounded-lg transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" /><circle cx="9" cy="7" r="4" /><path d="M22 21v-2a4 4 0 0 0-3-3.87" /><path d="M16 3.13a4 4 0 0 1 0 7.75" /></svg>
                Escorts
            </a>
            <a href="{{ route('posts.index') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium hover:text-red-600 hover:bg-gray-50 dark:hover:bg-zinc-900 rounded-lg transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 1-2 2Zm0 0a2 2 0 0 1-2-2v-9c0-1.1.9-2 2-2h2" /><path d="M18 14h-8" /><path d="M15 18h-5" /><path d="M10 6h8v4h-8Z" /></svg>
                <div class="flex items-center gap-1.5">
                    Noticias
                    @if($hasNewPosts)
                        <span class="relative flex h-2 w-2">
                            <span class="custom-animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-red-600"></span>
                        </span>
                    @endif
                </div>
            </a>
            {{--
            <a href="{{ route('establishments.index') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium hover:text-red-600 hover:bg-gray-50 dark:hover:bg-zinc-900 rounded-lg transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" /><polyline points="9 22 9 12 15 12 15 22" /></svg>
                Establecimientos
            </a>
            --}}
            <a href="{{ route('contact.index') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium hover:text-red-600 hover:bg-gray-50 dark:hover:bg-zinc-900 rounded-lg transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z" /></svg>
                Contacto
            </a>

            @guest
                <div class="sm:hidden flex flex-col gap-2 px-4 pt-3 border-t border-gray-200 dark:border-zinc-800 mt-2">
                    <a href="{{ route('login') }}"
                        class="border border-red-600 text-red-600 hover:bg-red-600 hover:text-white transition-all font-bold px-4 py-2.5 rounded-lg uppercase text-xs tracking-widest text-center">
                        Ingresar
                    </a>
                    <a href="{{ route('register') }}"
                        class="bg-red-600 hover:bg-opacity-90 transition-all font-bold px-4 py-2.5 rounded-lg uppercase text-xs tracking-widest text-center text-white">
                        Registrarse
                    </a>
                </div>
            @endguest
        </nav>
    </div>
</header>