<section
    class="bg-white dark:bg-black py-16 px-4 lg:px-8 border-t border-gray-200 dark:border-gray-800 transition-colors duration-300">
    @php
        // Fetch all cities sorted by name
        $cities = \App\Models\City::orderBy('name', 'asc')->get();
    @endphp

    <div class="max-w-7xl mx-auto mb-16">
        <h3 class="text-center text-brand-pink font-bold text-lg mb-8">Encontrá escorts en</h3>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-x-4 gap-y-2">
            @foreach($cities as $city)
                <a href="{{ route('escorts.index', ['city' => $city->name]) }}"
                    class="text-gray-400 hover:text-brand-pink text-sm transition-colors flex items-center justify-between group">
                    <span>{{ $city->name }}</span>
                </a>
            @endforeach

            @if($cities->isEmpty())
                <div class="col-span-full text-center text-gray-500 text-sm">
                    No hay ciudades registradas.
                </div>
            @endif
        </div>
    </div>

    <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-12 relative border-t border-zinc-800 pt-12">
        <div class="space-y-6">
            <a href="/" class="inline-flex items-center gap-0.5 font-black text-xl tracking-tighter select-none">
                @if(config('settings.site_logo'))
                    <img src="{{ asset('storage/' . config('settings.site_logo')) }}" alt="{{ config('settings.site_name', 'CITASESCORTS') }}" class="h-8 w-auto object-contain">
                @else
                    @if(config('settings.site_name'))
                        @php
                            $name = config('settings.site_name');
                            $splitAt = min(5, strlen($name));
                        @endphp
                        <span class="text-brand-pink">{{ strtoupper(substr($name, 0, $splitAt)) }}</span><span class="text-black dark:text-white">{{ strtoupper(substr($name, $splitAt)) }}</span>
                    @else
                        <span class="text-red-600">CITAS</span><span class="text-white">ESCORTS</span>
                    @endif
                @endif
            </a>

            <a href="#"
                class="inline-block bg-brand-pink text-white text-[11px] font-bold px-4 py-2 rounded-lg uppercase tracking-wider hover:opacity-90 transition-opacity">
                Publicar en Citasescort
            </a>

            <div class="flex items-center gap-4 text-black dark:text-white">
                @if(config('settings.facebook_url'))
                    <a href="{{ config('settings.facebook_url') }}" target="_blank" class="hover:text-brand-pink transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                            fill="currentColor">
                            <path
                                d="M22 12c0-5.52-4.48-10-10-10S2 6.48 2 12c0 4.84 3.44 8.87 8 9.8V15H8v-3h2V9.5C10 7.57 11.57 6 13.5 6H16v3h-2c-.55 0-1 .45-1 1V12h3l-1 3h-2v6.8c4.56-.93 8-4.96 8-9.8z" />
                        </svg>
                    </a>
                @endif
                @if(config('settings.instagram_url'))
                    <a href="{{ config('settings.instagram_url') }}" target="_blank" class="hover:text-brand-pink transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect width="20" height="20" x="2" y="2" rx="5" ry="5" />
                            <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z" />
                            <line x1="17.5" x2="17.51" y1="6.5" y2="6.5" />
                        </svg>
                    </a>
                @endif
            </div>
        </div>

        <!-- Col 1: Escorts y acompañantes -->
        <div class="space-y-4">
            <h4 class="text-brand-pink font-bold text-sm">Escorts y acompañantes</h4>
            <div class="flex flex-col gap-2 text-gray-500 dark:text-gray-400 text-sm font-medium">
                <a href="/#stories" class="hover:text-black dark:hover:text-white transition-colors">Activas/os
                    (Historias
                    recientes)</a>
                <a href="{{ route('escorts.index', ['filter' => 'new']) }}"
                    class="hover:text-black dark:hover:text-white transition-colors">Nuevas (Recién publicadas)</a>
                <a href="{{ route('escorts.index', ['gender' => 'female']) }}"
                    class="hover:text-black dark:hover:text-white transition-colors">Mujeres</a>
                <a href="{{ route('escorts.index') }}"
                    class="hover:text-black dark:hover:text-white transition-colors">Todos los servicios</a>
            </div>
        </div>

        <!-- Col 2: Noticias -->
        <div class="space-y-4">
            <h4 class="text-brand-pink font-bold text-sm">Noticias</h4>
            <div class="flex flex-col gap-2 text-gray-500 dark:text-gray-400 text-sm font-medium">
                <a href="{{ route('posts.index') }}"
                    class="hover:text-black dark:hover:text-white transition-colors">Últimas Noticias</a>
                <a href="{{ route('posts.show', 'guia-de-sitios-de-escorts-en-uruguay') }}"
                    class="hover:text-black dark:hover:text-white transition-colors">Guía De Sitios De Escorts En
                    Perú</a>
                <a href="{{ route('posts.show', 'advertencias-sobre-perfiles-falsos') }}"
                    class="hover:text-black dark:hover:text-white transition-colors">Advertencias Sobre Perfiles
                    Falsos</a>
            </div>
        </div>

        <!-- Col 3: Para Escorts -->
        <div class="space-y-4">
            <h4 class="text-brand-pink font-bold text-sm">Para Escorts</h4>
            <div class="flex flex-col gap-2 text-gray-500 dark:text-gray-400 text-sm font-medium">
                <a href="{{ route('register') }}"
                    class="hover:text-black dark:hover:text-white transition-colors">Publicá en Citasescort</a>
                <a href="{{ route('login') }}" class="hover:text-black dark:hover:text-white transition-colors">Iniciar
                    sesión</a>
            </div>
        </div>
    </div>
</section>