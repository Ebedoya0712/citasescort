<div x-data="{ open: false }"
     @open-filters.window="open = true; document.body.style.overflow = 'hidden';"
     @close-filters.window="open = false; document.body.style.overflow = '';"
     class="relative z-[100]"
     style="display: none;"
     x-show="open">

    <!-- Overlay -->
    <div x-show="open"
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 backdrop-blur-sm"
         style="background-color: rgba(0, 0, 0, 0.5) !important;"
         @click="$dispatch('close-filters')"></div>

    <!-- Sidebar -->
    <div x-show="open"
         x-transition:enter="transition ease-in-out duration-300 transform"
         x-transition:enter-start="-translate-x-full"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transition ease-in-out duration-300 transform"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="-translate-x-full"
         class="fixed inset-y-0 left-0 flex w-full max-w-xs md:max-w-sm flex-col bg-white dark:bg-[#131313] shadow-2xl overflow-y-auto overflow-x-hidden border-r border-gray-200 dark:border-zinc-800 transition-colors duration-300 scroll-smooth custom-scrollbar">

        <!-- Header -->
        <div class="flex items-center justify-between bg-red-600 text-white px-4 py-4 sticky top-0 z-10 shadow-md">
            <h2 class="text-lg font-bold flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="21" y1="4" x2="14" y2="4"></line><line x1="10" y1="4" x2="3" y2="4"></line><line x1="21" y1="12" x2="12" y2="12"></line><line x1="8" y1="12" x2="3" y2="12"></line><line x1="21" y1="20" x2="16" y2="20"></line><line x1="12" y1="20" x2="3" y2="20"></line><line x1="14" y1="2" x2="14" y2="6"></line><line x1="8" y1="10" x2="8" y2="14"></line><line x1="16" y1="18" x2="16" y2="22"></line></svg>
                Filtros
            </h2>
            <button @click="$dispatch('close-filters')" class="text-white hover:text-gray-200 focus:outline-none hover:scale-110 transition-transform">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
            </button>
        </div>

        <form action="/" method="GET" class="flex flex-col h-full" id="filter-form">
            <div class="px-4 pt-4 pb-2">
                <div class="relative">
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Buscar nombre, palabra clave..."
                        class="w-full bg-gray-50 dark:bg-zinc-900/50 border border-gray-200 dark:border-zinc-800 rounded-xl outline-none px-4 py-3 pl-10 text-sm text-gray-700 dark:text-gray-200 focus:border-red-600 focus:ring-1 focus:ring-red-600 transition-colors">
                    <svg class="w-5 h-5 absolute left-3 top-3.5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                </div>
            </div>

            <div class="flex-1 px-2 pb-4 space-y-2">

                <!-- Ubicación y Precio -->
                <div x-data="{ expanded: true }" class="border-b border-gray-100 dark:border-zinc-800/50 pb-2">
                    <button type="button" @click="expanded = !expanded" class="w-full flex items-center justify-between px-3 py-3 text-left focus:outline-none hover:bg-gray-50 dark:hover:bg-zinc-800/50 rounded-lg transition-colors">
                        <span class="font-semibold text-white flex items-center gap-2 text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-red-600"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                            Ubicación y Precio
                        </span>
                        <svg class="w-4 h-4 text-gray-400 transform transition-transform duration-200" :class="expanded ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="expanded" x-collapse>
                        <div class="px-4 py-3 space-y-4">
                            <!-- Precio Range Slider -->
                            <div class="pt-2" x-data="{
                                        maxPrice: {{ (int)request('max_price', 5000) }},
                                        max: 5000,
                                        step: 100,
                                        get maxPercent() {
                                            return (this.maxPrice / this.max) * 100;
                                        }
                                    }">
                                <label class="flex items-center justify-between text-xs font-semibold text-gray-300 uppercase tracking-wider mb-4">
                                    <span>Precio por hora</span>
                                    <span class="bg-red-600 text-white px-2 py-0.5 rounded-full font-bold text-[10px]"
                                          x-text="'0$ a ' + maxPrice + '$'"></span>
                                </label>
                                <div class="relative w-full h-8 mb-4">
                                    <input type="hidden" name="min_price" value="0">
                                    <!-- Track -->
                                    <div class="absolute top-1/2 -translate-y-1/2 left-0 right-0 h-1.5 bg-gray-200 dark:bg-zinc-700 rounded-full"></div>
                                    <!-- Highlighted Track -->
                                    <div class="absolute top-1/2 -translate-y-1/2 left-0 h-1.5 bg-red-600 rounded-full transition-all duration-75"
                                         :style="`width: ${maxPercent}%`"></div>
                                    <!-- Thumb -->
                                    <input type="range" name="max_price" x-model="maxPrice" min="0" :max="max" :step="step"
                                           class="absolute top-1/2 -translate-y-1/2 w-full appearance-none bg-transparent custom-range z-10">
                                </div>
                            </div>
                            


                            <!-- Moneda -->
                            {{--
                            <div>
                                <label class="block text-xs text-gray-500 dark:text-gray-400 mb-1 flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><path d="M16 8h-6a2 2 0 1 0 0 4h4a2 2 0 1 1 0 4H8"></path><line x1="12" y1="18" x2="12" y2="22"></line><line x1="12" y1="2" x2="12" y2="6"></line></svg>
                                    Moneda
                                </label>
                                <select name="currency" class="w-full bg-gray-50 dark:bg-zinc-900/50 border border-gray-200 dark:border-zinc-800 rounded-lg outline-none px-3 py-2 text-sm text-gray-700 dark:text-gray-200 focus:border-red-600 focus:ring-1 focus:ring-red-600 transition-colors">
                                    <option value="PEN" {{ request('currency') == 'PEN' ? 'selected' : '' }}>PEN (S/)</option>
                                    <option value="USD" {{ request('currency') == 'USD' ? 'selected' : '' }}>USD ($)</option>
                                </select>
                            </div>
                            --}}

                            <!-- Ubicación -->
                            @php
                                $ubigeoPath = storage_path('app/peru-locations.json');
                                $ubigeoJson = file_exists($ubigeoPath) ? file_get_contents($ubigeoPath) : '{}';
                            @endphp
                            <div x-data='{
                                ubigeo: {{ $ubigeoJson }},
                                selectedCity: "{{ request("city", "") }}",
                                selectedProvince: "{{ request("province", "") }}",
                                selectedDistrict: "{{ request("district", "") }}",
                                provinces: {},
                                districts: [],
                                
                                init() {
                                    this.updateProvinces();
                                    this.updateDistricts();
                                },
                                
                                updateProvinces() {
                                    if (this.selectedCity && this.ubigeo[this.selectedCity]) {
                                        this.provinces = this.ubigeo[this.selectedCity];
                                    } else {
                                        this.provinces = {};
                                        this.selectedProvince = "";
                                        this.selectedDistrict = "";
                                    }
                                    this.updateDistricts();
                                },
                                
                                updateDistricts() {
                                    if (this.selectedCity && this.selectedProvince && this.ubigeo[this.selectedCity] && this.ubigeo[this.selectedCity][this.selectedProvince]) {
                                        this.districts = this.ubigeo[this.selectedCity][this.selectedProvince];
                                    } else {
                                        this.districts = [];
                                        this.selectedDistrict = "";
                                    }
                                }
                            }' class="space-y-4">
                                <div>
                                    <label class="block text-xs text-gray-500 dark:text-gray-400 mb-1 flex items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="3 6 9 3 15 6 21 3 21 18 15 21 9 18 3 21"></polygon><line x1="9" y1="3" x2="9" y2="18"></line><line x1="15" y1="6" x2="15" y2="21"></line></svg>
                                        Departamento
                                    </label>
                                    <select name="city" x-model="selectedCity" @change="updateProvinces()" class="w-full bg-gray-50 dark:bg-zinc-900/50 border border-gray-200 dark:border-zinc-800 rounded-lg outline-none px-3 py-2 text-sm text-gray-700 dark:text-gray-200 focus:border-red-600 focus:ring-1 focus:ring-red-600 transition-colors">
                                        <option value="">Todos los departamentos</option>
                                        <template x-for="(provList, depName) in ubigeo" :key="depName">
                                            <option :value="depName" x-text="depName" :selected="selectedCity == depName"></option>
                                        </template>
                                    </select>
                                </div>

                                <div x-show="Object.keys(provinces).length > 0" style="display: none;">
                                    <label class="block text-xs text-gray-500 dark:text-gray-400 mb-1 flex items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="3 6 9 3 15 6 21 3 21 18 15 21 9 18 3 21"></polygon><line x1="9" y1="3" x2="9" y2="18"></line><line x1="15" y1="6" x2="15" y2="21"></line></svg>
                                        Provincia
                                    </label>
                                    <select name="province" x-model="selectedProvince" @change="updateDistricts()" class="w-full bg-gray-50 dark:bg-zinc-900/50 border border-gray-200 dark:border-zinc-800 rounded-lg outline-none px-3 py-2 text-sm text-gray-700 dark:text-gray-200 focus:border-red-600 focus:ring-1 focus:ring-red-600 transition-colors">
                                        <option value="">Todas las provincias</option>
                                        <template x-for="(distList, provName) in provinces" :key="provName">
                                            <option :value="provName" x-text="provName" :selected="selectedProvince == provName"></option>
                                        </template>
                                    </select>
                                </div>

                                <div x-show="districts.length > 0" style="display: none;">
                                    <label class="block text-xs text-gray-500 dark:text-gray-400 mb-1 flex items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="3 6 9 3 15 6 21 3 21 18 15 21 9 18 3 21"></polygon><line x1="9" y1="3" x2="9" y2="18"></line><line x1="15" y1="6" x2="15" y2="21"></line></svg>
                                        Distrito
                                    </label>
                                    <select name="district" x-model="selectedDistrict" class="w-full bg-gray-50 dark:bg-zinc-900/50 border border-gray-200 dark:border-zinc-800 rounded-lg outline-none px-3 py-2 text-sm text-gray-700 dark:text-gray-200 focus:border-red-600 focus:ring-1 focus:ring-red-600 transition-colors">
                                        <option value="">Todos los distritos</option>
                                        <template x-for="distName in districts" :key="distName">
                                            <option :value="distName" x-text="distName" :selected="selectedDistrict == distName"></option>
                                        </template>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Clasificación -->
                @php
                    $categories = ['Apto. propio', 'Casa de masajes', 'Cola + 100', 'De lujo', 'Económicas', 'Extranjeras', 'Lolas + 100', 'Milf', 'Universitarias'];
                    $selectedCategories = request('category', []);
                    if(!is_array($selectedCategories)) $selectedCategories = [$selectedCategories];
                @endphp
                <div x-data="{ expanded: {{ !empty($selectedCategories) ? 'true' : 'false' }} }" class="border-b border-gray-100 dark:border-zinc-800/50 pb-2">
                    <button type="button" @click="expanded = !expanded" class="w-full flex items-center justify-between px-3 py-3 text-left focus:outline-none hover:bg-gray-50 dark:hover:bg-zinc-800/50 rounded-lg transition-colors">
                        <span class="font-semibold text-white flex items-center gap-2 text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-red-600"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg>
                            Clasificación
                        </span>
                        <svg class="w-4 h-4 text-gray-400 transform transition-transform duration-200" :class="expanded ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="expanded" x-collapse>
                        <div class="px-4 py-3">
                            <p class="text-xs text-gray-500 mb-3">Filtrá por categoría del perfil.</p>
                            <div class="flex flex-wrap gap-2">
                                @foreach($categories as $cat)
                                    <label class="cursor-pointer">
                                        <input type="checkbox" name="category[]" value="{{ $cat }}" class="peer sr-only" {{ in_array($cat, $selectedCategories) ? 'checked' : '' }}>
                                        <div class="px-3 py-1.5 rounded-full border border-gray-200 dark:border-zinc-700 text-xs text-gray-600 dark:text-gray-400 peer-checked:border-red-600 peer-checked:bg-red-600/10 peer-checked:text-red-600 transition-all hover:border-red-600/50">
                                            {{ $cat }}
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Servicios -->
                @php
                    $services = ['Besos', 'Masaje Erótico', 'Baile', 'GFE', 'Lluvia Dorada', 'Juguetes', 'Disfraces', 'Saso', 'Dúplex', 'Compañía', 'Cenas y Eventos', 'Viajes', 'Sexo Oral', 'Con Condón', 'Sin Condón', 'BDSM'];
                    $selectedServices = request('services', []);
                @endphp
                <div x-data="{ expanded: {{ !empty($selectedServices) ? 'true' : 'false' }} }" class="border-b border-gray-100 dark:border-zinc-800/50 pb-2">
                    <button type="button" @click="expanded = !expanded" class="w-full flex items-center justify-between px-3 py-3 text-left focus:outline-none hover:bg-gray-50 dark:hover:bg-zinc-800/50 rounded-lg transition-colors">
                        <span class="font-semibold text-white flex items-center gap-2 text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-red-600"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>
                            Servicios
                        </span>
                        <svg class="w-4 h-4 text-gray-400 transform transition-transform duration-200" :class="expanded ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="expanded" x-collapse>
                        <div class="px-4 py-3">
                            <div class="flex flex-wrap gap-2">
                                @foreach($services as $srv)
                                    <label class="cursor-pointer">
                                        <input type="checkbox" name="services[]" value="{{ $srv }}" class="peer sr-only" {{ in_array($srv, $selectedServices) ? 'checked' : '' }}>
                                        <div class="px-3 py-1.5 rounded-full border border-gray-200 dark:border-zinc-700 text-xs text-gray-600 dark:text-gray-400 peer-checked:border-red-600 peer-checked:bg-red-600/10 peer-checked:text-red-600 transition-all hover:border-red-600/50">
                                            {{ $srv }}
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Atiende en -->
                @php
                    $attendsIn = ['Hoteles', 'Apartamento Propio', 'Domicilio', 'Casa de Masajes', 'Club'];
                    $selectedAttendsIn = request('attends_in', []);
                @endphp
                <div x-data="{ expanded: {{ !empty($selectedAttendsIn) ? 'true' : 'false' }} }" class="border-b border-gray-100 dark:border-zinc-800/50 pb-2">
                    <button type="button" @click="expanded = !expanded" class="w-full flex items-center justify-between px-3 py-3 text-left focus:outline-none hover:bg-gray-50 dark:hover:bg-zinc-800/50 rounded-lg transition-colors">
                        <span class="font-semibold text-white flex items-center gap-2 text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-red-600"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                            Atiende en
                        </span>
                        <svg class="w-4 h-4 text-gray-400 transform transition-transform duration-200" :class="expanded ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="expanded" x-collapse>
                        <div class="px-4 py-3">
                            <div class="flex flex-wrap gap-2">
                                @foreach($attendsIn as $att)
                                    <label class="cursor-pointer">
                                        <input type="checkbox" name="attends_in[]" value="{{ $att }}" class="peer sr-only" {{ in_array($att, $selectedAttendsIn) ? 'checked' : '' }}>
                                        <div class="px-3 py-1.5 rounded-full border border-gray-200 dark:border-zinc-700 text-xs text-gray-600 dark:text-gray-400 peer-checked:border-red-600 peer-checked:bg-red-600/10 peer-checked:text-red-600 transition-all hover:border-red-600/50">
                                            {{ $att }}
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Footer Buttons -->
            <div class="sticky bottom-0 bg-white dark:bg-[#131313] border-t border-gray-200 dark:border-zinc-800 p-4 flex gap-3 z-10 transition-colors duration-300">
                <a href="{{ url('/') }}" class="flex-1 px-4 py-3 bg-gray-100 dark:bg-zinc-800 text-gray-700 dark:text-gray-300 rounded-xl text-sm font-bold text-center hover:bg-gray-200 dark:hover:bg-zinc-700 transition-colors">
                    Limpiar
                </a>
                <button type="submit" class="flex-1 px-4 py-3 bg-red-600 text-white rounded-xl text-sm font-bold shadow-lg shadow-red-600/30 hover:bg-red-700 transition-colors">
                    Aplicar
                </button>
            </div>
        </form>
    </div>

    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background-color: var(--color-red-600);
            border-radius: 20px;
        }
        /* Custom dual range slider thumbs */
        .custom-range::-webkit-slider-thumb {
            pointer-events: auto;
            appearance: none;
            width: 16px;
            height: 16px;
            background-color: var(--color-red-600);
            border-radius: 50%;
            cursor: pointer;
            box-shadow: 0 0 5px rgba(0,0,0,0.2);
        }
        .custom-range::-moz-range-thumb {
            pointer-events: auto;
            width: 16px;
            height: 16px;
            background-color: var(--color-red-600);
            border-radius: 50%;
            border: none;
            cursor: pointer;
            box-shadow: 0 0 5px rgba(0,0,0,0.2);
        }
    </style>
</div>
