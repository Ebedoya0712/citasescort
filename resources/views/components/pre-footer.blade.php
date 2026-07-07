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

    <!-- Safe UBIGEO Data Script -->
    <script id="ubigeo-data" type="application/json">
        @json($ubigeoJsonData)
    </script>

    <!-- Locations Wizard Widget (Inline) -->
    <div x-data="{
        ubigeo: {},
        step: 1,
        loading: false,
        selectedCity: '',
        selectedProvince: '',
        selectedDistrict: '',
        provinces: [],
        districts: [],

        init() {
            this.ubigeo = JSON.parse(document.getElementById('ubigeo-data').textContent);
        },

        selectCity(depName) {
            this.selectedCity = depName;
            this.selectedProvince = '';
            this.selectedDistrict = '';
            this.provinces = Object.keys(this.ubigeo[depName] || {});
            this.districts = [];
            
            this.loading = true;
            setTimeout(() => {
                this.step = 2;
                this.loading = false;
            }, 300);
        },

        selectProvince(provName) {
            this.selectedProvince = provName;
            this.districts = this.ubigeo[this.selectedCity][provName] || [];
            this.selectedDistrict = '';
            
            this.loading = true;
            setTimeout(() => {
                if (this.districts.length) {
                    this.step = 3;
                } else {
                    this.finish();
                }
                this.loading = false;
            }, 300);
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
    }" class="max-w-7xl mx-auto mb-16 select-none">
        
        <h3 class="text-center text-red-600 font-bold text-lg mb-6">Encontrá escorts en</h3>

        <!-- Steps Progress Circles -->
        <div class="flex items-center justify-center gap-4 mb-8 text-xs font-semibold">
            <!-- Step 1: Departamento -->
            <button @click="if (step !== 1) { step = 1; selectedProvince = ''; selectedDistrict = ''; }" 
                    :disabled="step === 1" 
                    class="flex items-center gap-2 focus:outline-none hover:text-red-500 disabled:hover:text-inherit transition-colors cursor-pointer">
                <div class="w-6 h-6 rounded-full flex items-center justify-center border font-bold transition-all text-xs"
                     :class="step === 1 ? 'border-red-600 bg-red-600 text-white shadow-lg shadow-red-600/20' : 'border-zinc-700 text-zinc-500'">
                    1
                </div>
                <span :class="step === 1 ? 'text-white' : 'text-zinc-500'">Departamento</span>
            </button>

            <div class="w-8 h-[1px] bg-zinc-800" :class="step !== 1 ? 'bg-red-600' : ''"></div>

            <!-- Step 2: Provincia -->
            <button @click="if (step === 3) { step = 2; selectedDistrict = ''; }" 
                    :disabled="step === 1 || step === 2" 
                    class="flex items-center gap-2 focus:outline-none hover:text-red-500 disabled:hover:text-inherit transition-colors cursor-pointer">
                <div class="w-6 h-6 rounded-full flex items-center justify-center border font-bold transition-all text-xs"
                     :class="step === 2 ? 'border-red-600 bg-red-600 text-white shadow-lg shadow-red-600/20' : 'border-zinc-700 text-zinc-500'">
                    2
                </div>
                <span :class="step === 2 ? 'text-white' : 'text-zinc-500'">Provincia</span>
            </button>

            <div class="w-8 h-[1px] bg-zinc-800" :class="step === 3 ? 'bg-red-600' : ''"></div>

            <!-- Step 3: Distrito -->
            <div class="flex items-center gap-2">
                <div class="w-6 h-6 rounded-full flex items-center justify-center border font-bold transition-all text-xs"
                     :class="step === 3 ? 'border-red-600 bg-red-600 text-white shadow-lg shadow-red-600/20' : 'border-zinc-700 text-zinc-500'">
                    3
                </div>
                <span :class="step === 3 ? 'text-white' : 'text-zinc-500'">Distrito</span>
            </div>
        </div>

        <!-- Selected Breadcrumb Info -->
        <div x-show="selectedCity" class="flex items-center justify-center gap-2 text-xs text-zinc-400 mb-8" style="display: none;">
            <span x-text="selectedCity" class="text-white font-semibold"></span>
            <span x-show="selectedProvince"> › </span>
            <span x-text="selectedProvince" class="text-white font-semibold" x-show="selectedProvince"></span>
            <button @click="step = 1; selectedCity = ''; selectedProvince = ''; selectedDistrict = '';" class="text-red-500 hover:underline ml-2">
                Reiniciar
            </button>
        </div>

        <!-- Loader -->
        <div x-show="loading" class="flex flex-col items-center justify-center py-12" style="display: none;">
            <svg class="animate-spin h-8 w-8 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span class="text-zinc-500 text-xs mt-3">Cargando ubicaciones...</span>
        </div>

        <!-- Main Panel Content -->
        <div x-show="!loading">
            
            <!-- STEP 1: DEPARTAMENTOS -->
            <div x-show="step === 1" class="grid grid-cols-2 md:grid-cols-4 gap-x-4 gap-y-2">
                @foreach($cities as $city)
                    <button @click="selectCity('{{ $city->name }}')"
                        class="text-gray-400 hover:text-red-600 text-sm transition-colors flex items-center justify-between group text-left w-full cursor-pointer focus:outline-none">
                        <span>{{ $city->name }}</span>
                    </button>
                @endforeach

                @if($cities->isEmpty())
                    <div class="col-span-full text-center text-gray-500 text-sm">
                        No hay departamentos registrados.
                    </div>
                @endif
            </div>

            <!-- STEP 2: PROVINCIAS -->
            <div x-show="step === 2" style="display: none;" class="space-y-6">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-x-4 gap-y-2">
                    <!-- Option: Todas las provincias de este departamento -->
                    <button @click="selectedProvince = ''; selectedDistrict = ''; finish();"
                            class="text-red-500 hover:text-red-600 font-bold text-sm transition-colors text-left w-full cursor-pointer focus:outline-none">
                        Todo <span x-text="selectedCity"></span>
                    </button>
                    
                    <template x-for="provName in provinces" :key="provName">
                        <button @click="selectProvince(provName)"
                                class="text-gray-400 hover:text-red-600 text-sm transition-colors flex items-center justify-between group text-left w-full cursor-pointer focus:outline-none">
                            <span x-text="provName"></span>
                        </button>
                    </template>
                </div>
                
                <div class="flex justify-start border-t border-zinc-900 pt-4">
                    <button @click="step = 1; selectedCity = '';" class="text-zinc-500 hover:text-white text-xs font-semibold flex items-center gap-1 cursor-pointer">
                        ‹ Volver a Departamentos
                    </button>
                </div>
            </div>

            <!-- STEP 3: DISTRITOS -->
            <div x-show="step === 3" style="display: none;" class="space-y-6">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-x-4 gap-y-2">
                    <!-- Option: Todos los distritos de esta provincia -->
                    <button @click="selectedDistrict = ''; finish();"
                            class="text-red-500 hover:text-red-600 font-bold text-sm transition-colors text-left w-full cursor-pointer focus:outline-none">
                        Todo <span x-text="selectedProvince"></span>
                    </button>
                    
                    <template x-for="distName in districts" :key="distName">
                        <button @click="selectDistrict(distName)"
                                class="text-gray-400 hover:text-red-600 text-sm transition-colors flex items-center justify-between group text-left w-full cursor-pointer focus:outline-none">
                            <span x-text="distName"></span>
                        </button>
                    </template>
                </div>
                
                <div class="flex justify-start border-t border-zinc-900 pt-4">
                    <button @click="step = 2; selectedProvince = '';" class="text-zinc-500 hover:text-white text-xs font-semibold flex items-center gap-1 cursor-pointer">
                        ‹ Volver a Provincias
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
                            $name = str_replace(' ', '', config('settings.site_name'));
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