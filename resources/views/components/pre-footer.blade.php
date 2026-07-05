<section
    class="bg-white dark:bg-black py-16 px-4 lg:px-8 border-t border-gray-200 dark:border-gray-800 transition-colors duration-300">
    @php
        // Fetch all cities sorted by name
        $cities = \App\Models\City::orderBy('name', 'asc')->get();
    @endphp

    @php
        $ubigeoPath = storage_path('app/peru-locations.json');
        $ubigeoJsonData = file_exists($ubigeoPath) ? json_decode(file_get_contents($ubigeoPath), true) : [];
    @endphp

    <div class="max-w-7xl mx-auto mb-16" x-data="{}">
        <h3 class="text-center text-red-600 font-bold text-lg mb-8">Encontrá escorts en</h3>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-x-4 gap-y-2">
            @foreach($cities as $city)
                <button @click="$dispatch('open-locations-wizard', '{{ $city->name }}')"
                    class="text-gray-400 hover:text-red-600 text-sm transition-colors flex items-center justify-between group text-left w-full cursor-pointer focus:outline-none">
                    <span>{{ $city->name }}</span>
                </button>
            @endforeach

            @if($cities->isEmpty())
                <div class="col-span-full text-center text-gray-500 text-sm">
                    No hay ciudades registradas.
                </div>
            @endif
        </div>
    </div>

    <!-- Locations Wizard Modal -->
    <div x-data="{
        open: false,
        ubigeo: {},
        step: 1,
        selectedCity: '',
        selectedProvince: '',
        selectedDistrict: '',
        provinces: [],
        districts: [],

        init() {
            this.ubigeo = @json($ubigeoJsonData);
        },

        openWizard(depName) {
            this.selectedCity = depName;
            this.selectedProvince = '';
            this.selectedDistrict = '';
            this.provinces = Object.keys(this.ubigeo[depName] || {});
            this.districts = [];
            this.step = 2;
            this.open = true;
            document.body.style.overflow = 'hidden';
        },

        selectProvince(provName) {
            this.selectedProvince = provName;
            this.districts = this.ubigeo[this.selectedCity][provName] || [];
            this.selectedDistrict = '';
            if (this.districts.length) {
                this.step = 3;
            } else {
                this.finish();
            }
        },

        selectDistrict(distName) {
            this.selectedDistrict = distName;
            this.finish();
        },

        goBack() {
            if (this.step !== 1) {
                this.step--;
            }
        },

        close() {
            this.open = false;
            document.body.style.overflow = '';
        },

        finish() {
            let url = '{{ route("escorts.index") }}?city=' + encodeURIComponent(this.selectedCity);
            if (this.selectedProvince) {
                url += '&province=' + encodeURIComponent(this.selectedProvince);
            }
            if (this.selectedDistrict) {
                url += '&district=' + encodeURIComponent(this.selectedDistrict);
            }
            window.location.href = url;
        }
    }" @open-locations-wizard.window="openWizard($event.detail)" class="relative z-[150]">
        <!-- Modal Backdrop -->
        <div x-show="open" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-black/85 backdrop-blur-md flex items-center justify-center p-4"
             style="display: none;">
            
            <!-- Modal Card -->
            <div @click.outside="close()" 
                 class="bg-zinc-950 border border-zinc-800 rounded-3xl w-full max-w-2xl overflow-hidden shadow-2xl flex flex-col max-h-[90vh]">
                
                <!-- Header -->
                <div class="px-6 py-6 border-b border-zinc-800 flex items-center justify-between shrink-0">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-red-600/10 border border-red-600/30 flex items-center justify-center">
                            <svg class="w-4 h-4 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-white font-bold text-base">Ubicación de Búsqueda</h4>
                            <p class="text-zinc-500 text-xs mt-0.5">Encuentra escorts cerca de ti</p>
                        </div>
                    </div>
                    <button @click="close()" class="text-zinc-400 hover:text-white transition-colors p-1 rounded-full hover:bg-zinc-900">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Steps Indicator -->
                <div class="px-6 py-4 bg-zinc-900/30 border-b border-zinc-800 flex items-center justify-center gap-4 shrink-0 select-none">
                    <!-- Step 1: Dept -->
                    <button @click="step = 1" :disabled="step === 1" class="flex items-center gap-2 group disabled:cursor-default">
                        <div class="w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold transition-all border"
                             :class="step !== 0 ? 'bg-red-600 border-red-600 text-white shadow-lg shadow-red-600/20' : 'border-zinc-700 text-zinc-500'">
                            1
                        </div>
                        <span class="text-xs font-semibold" :class="step !== 0 ? 'text-white' : 'text-zinc-500'">Departamento</span>
                    </button>

                    <div class="w-8 h-[2px] bg-zinc-800" :class="step !== 1 ? 'bg-red-600' : ''"></div>

                    <!-- Step 2: Prov -->
                    <button @click="step = 2" :disabled="step === 1 || step === 2" class="flex items-center gap-2 group disabled:cursor-default">
                        <div class="w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold transition-all border"
                             :class="step !== 1 ? 'bg-red-600 border-red-600 text-white shadow-lg shadow-red-600/20' : 'border-zinc-700 text-zinc-500'">
                            2
                        </div>
                        <span class="text-xs font-semibold" :class="step !== 1 ? 'text-white' : 'text-zinc-500'">Provincia</span>
                    </button>

                    <div class="w-8 h-[2px] bg-zinc-800" :class="step === 3 ? 'bg-red-600' : ''"></div>

                    <!-- Step 3: Dist -->
                    <div class="flex items-center gap-2">
                        <div class="w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold transition-all border"
                             :class="step === 3 ? 'bg-red-600 border-red-600 text-white shadow-lg shadow-red-600/20' : 'border-zinc-700 text-zinc-500'">
                            3
                        </div>
                        <span class="text-xs font-semibold" :class="step === 3 ? 'text-white' : 'text-zinc-500'">Distrito</span>
                    </div>
                </div>

                <!-- Content Area -->
                <div class="flex-1 overflow-y-auto p-6 custom-scrollbar max-h-[50vh]">
                    
                    <!-- STEP 1: DEPARTAMENTO -->
                    <div x-show="step === 1" x-transition class="space-y-4" style="display: none;">
                        <h5 class="text-white font-bold text-lg text-center">¿En qué departamento buscas?</h5>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                            <template x-for="(provList, depName) in ubigeo" :key="depName">
                                <button @click="selectedCity = depName; provinces = Object.keys(provList); step = 2; updateDistricts();"
                                        class="py-3 px-4 rounded-xl bg-zinc-900 border border-zinc-800 text-zinc-300 hover:text-white hover:bg-zinc-850 hover:border-zinc-700 text-sm font-semibold transition-all text-center focus:outline-none cursor-pointer"
                                        :class="selectedCity === depName ? 'border-red-600 text-red-500 bg-red-600/5' : ''">
                                    <span x-text="depName"></span>
                                </button>
                            </template>
                        </div>
                    </div>

                    <!-- STEP 2: PROVINCIA -->
                    <div x-show="step === 2" x-transition class="space-y-4" style="display: none;">
                        <div class="text-center">
                            <span class="text-xs font-bold text-red-600 uppercase tracking-wider" x-text="selectedCity"></span>
                            <h5 class="text-white font-bold text-lg mt-1">Escoge la provincia donde buscas escorts</h5>
                        </div>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                            <!-- Option: Todas las provincias -->
                            <button @click="selectedProvince = ''; selectedDistrict = ''; finish();"
                                    class="py-3 px-4 rounded-xl bg-red-600/10 border border-red-600/30 text-red-500 hover:bg-red-600 hover:text-white hover:border-red-600 text-sm font-bold transition-all text-center focus:outline-none cursor-pointer">
                                Todo <span x-text="selectedCity"></span>
                            </button>
                            
                            <template x-for="provName in provinces" :key="provName">
                                <button @click="selectProvince(provName)"
                                        class="py-3 px-4 rounded-xl bg-zinc-900 border border-zinc-800 text-zinc-300 hover:text-white hover:bg-zinc-850 hover:border-zinc-700 text-sm font-semibold transition-all text-center focus:outline-none cursor-pointer"
                                        :class="selectedProvince === provName ? 'border-red-600 text-red-500 bg-red-600/5' : ''">
                                    <span x-text="provName"></span>
                                </button>
                            </template>
                        </div>
                    </div>

                    <!-- STEP 3: DISTRITO -->
                    <div x-show="step === 3" x-transition class="space-y-4" style="display: none;">
                        <div class="text-center">
                            <span class="text-xs font-bold text-red-600 uppercase tracking-wider" x-text="selectedCity + ' › ' + selectedProvince"></span>
                            <h5 class="text-white font-bold text-lg mt-1">Escoge el distrito</h5>
                        </div>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                            <!-- Option: Todos los distritos -->
                            <button @click="selectedDistrict = ''; finish();"
                                    class="py-3 px-4 rounded-xl bg-red-600/10 border border-red-600/30 text-red-500 hover:bg-red-600 hover:text-white hover:border-red-600 text-sm font-bold transition-all text-center focus:outline-none cursor-pointer">
                                Todo <span x-text="selectedProvince"></span>
                            </button>
                            
                            <template x-for="distName in districts" :key="distName">
                                <button @click="selectDistrict(distName)"
                                        class="py-3 px-4 rounded-xl bg-zinc-900 border border-zinc-800 text-zinc-300 hover:text-white hover:bg-zinc-850 hover:border-zinc-700 text-sm font-semibold transition-all text-center focus:outline-none cursor-pointer"
                                        :class="selectedDistrict === distName ? 'border-red-600 text-red-500 bg-red-600/5' : ''">
                                    <span x-text="distName"></span>
                                </button>
                            </template>
                        </div>
                    </div>

                </div>

                <!-- Footer / Action bar -->
                <div class="px-6 py-4 bg-zinc-950 border-t border-zinc-900 flex justify-between shrink-0">
                    <button @click="goBack()" 
                            x-show="step !== 1" 
                            class="px-5 py-2.5 rounded-xl border border-zinc-800 text-zinc-400 hover:text-white hover:bg-zinc-900 text-sm font-semibold transition-all focus:outline-none flex items-center gap-2 cursor-pointer"
                            style="display: none;">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                        </svg>
                        Atrás
                    </button>
                    <div x-show="step === 1" class="w-1"></div>
                    
                    <button @click="finish()" 
                            x-show="selectedCity"
                            class="px-5 py-2.5 rounded-xl bg-red-600 hover:bg-red-700 text-white text-sm font-bold shadow-lg shadow-red-600/20 hover:shadow-red-600/30 transition-all focus:outline-none cursor-pointer ml-auto"
                            style="display: none;">
                        Ver Escorts
                    </button>
                </div>
                
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8 md:gap-12 relative border-t border-zinc-800 pt-12">
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
                        <span class="text-red-600">{{ strtoupper(substr($name, 0, $splitAt)) }}</span><span class="text-black dark:text-white">{{ strtoupper(substr($name, $splitAt)) }}</span>
                    @else
                        <span class="text-red-600">CITAS</span><span class="text-white">ESCORTS</span>
                    @endif
                @endif
            </a>

            <a href="#"
                class="inline-block bg-red-600 text-white text-[11px] font-bold px-4 py-2 rounded-lg uppercase tracking-wider hover:opacity-90 transition-opacity">
                Publicar en Citasescort
            </a>

            <div class="flex items-center gap-4 text-black dark:text-white">
                @if(config('settings.instagram_url'))
                    <a href="{{ config('settings.instagram_url') }}" target="_blank" class="hover:text-red-600 transition-colors">
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
            <h4 class="text-red-600 font-bold text-sm">Escorts y acompañantes</h4>
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
            <h4 class="text-red-600 font-bold text-sm">Noticias</h4>
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
            <h4 class="text-red-600 font-bold text-sm">Para Escorts</h4>
            <div class="flex flex-col gap-2 text-gray-500 dark:text-gray-400 text-sm font-medium">
                <a href="{{ route('register') }}"
                    class="hover:text-black dark:hover:text-white transition-colors">Publicá en Citasescort</a>
                <a href="{{ route('login') }}" class="hover:text-black dark:hover:text-white transition-colors">Iniciar
                    sesión</a>
            </div>
        </div>
    </div>
</section>