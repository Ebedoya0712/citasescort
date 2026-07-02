<x-main-layout>

    <!-- Map Section -->
    <div class="w-full bg-gray-50 dark:bg-[#111] transition-colors duration-300">
        <div class="relative">
            <div id="map" class="w-full h-[350px] md:h-[500px] z-0"></div>
            <!-- Map Department Selector -->
            <div class="absolute top-4 right-4 z-[400]">
                <select id="department-select" class="bg-white dark:bg-[#1c1c1e] text-gray-900 dark:text-white px-4 py-2 rounded-lg shadow-lg border border-gray-200 dark:border-[#2c2c2e] focus:outline-none focus:ring-2 focus:ring-[#e11d48] font-semibold text-sm cursor-pointer">
                    <option value="">🗺️ Todo el Perú</option>
                    <!-- Opciones pobladas por JS -->
                </select>
            </div>
        </div>
        
        <!-- Legend / Buttons below map -->
        <div class="flex flex-wrap justify-center bg-gray-50 dark:bg-[#111] py-4 px-4 gap-8 items-center border-b border-gray-200 dark:border-[#222] transition-colors duration-300">
            <!-- Whiskerias -->
            <button onclick="scrollToSection('whiskerias')" class="flex items-center gap-3 group">
                <div class="bg-[#f06e28] text-white p-2 w-8 h-8 md:w-10 md:h-10 flex items-center justify-center transform group-hover:scale-105 transition-transform" style="border-radius: 5px 5px 5px 0; clip-path: polygon(0 0, 100% 0, 100% 100%, 50% 100%, 0 70%);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/></svg>
                </div>
                <span class="text-gray-900 dark:text-white text-xs md:text-sm font-semibold group-hover:text-[#f06e28] transition-colors">Whiskerías</span>
            </button>

            <!-- Casas de Masajes -->
            <button onclick="scrollToSection('massage')" class="flex items-center gap-3 group">
                <div class="bg-[#e11d48] text-white p-2 w-8 h-8 md:w-10 md:h-10 flex items-center justify-center transform group-hover:scale-105 transition-transform" style="border-radius: 5px 5px 5px 0; clip-path: polygon(0 0, 100% 0, 100% 100%, 50% 100%, 0 70%);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2"><path d="M2 4v16"/><path d="M2 8h18a2 2 0 0 1 2 2v10"/><path d="M2 17h20"/><path d="M6 8v9"/></svg>
                </div>
                <span class="text-gray-900 dark:text-white text-xs md:text-sm font-semibold group-hover:text-[#e11d48] transition-colors">Casas de Masajes</span>
            </button>

            <!-- Moteles -->
            <button onclick="scrollToSection('motels')" class="flex items-center gap-3 group">
                <div class="bg-white text-black p-2 w-8 h-8 md:w-10 md:h-10 flex items-center justify-center transform group-hover:scale-105 transition-transform" style="border-radius: 5px 5px 5px 0; clip-path: polygon(0 0, 100% 0, 100% 100%, 50% 100%, 0 70%);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                </div>
                <span class="text-gray-900 dark:text-white text-xs md:text-sm font-semibold group-hover:text-gray-500 dark:group-hover:text-gray-300 transition-colors">Motel</span>
            </button>
        </div>
    </div>

    <!-- Content Sections -->
    <div class="bg-gray-100 dark:bg-[#111] min-h-screen text-gray-900 dark:text-white pb-20 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 py-8">
            
            <!-- Whiskerías Section -->
            @if($whiskerias->count() > 0)
            <section id="whiskerias">
                <div class="flex justify-center mb-8 mt-4">
                    <div class="bg-white dark:bg-black border border-gray-200 dark:border-white/10 rounded-full px-6 py-2 flex items-center gap-3 text-sm font-bold uppercase tracking-widest text-[#f06e28] shadow-md transition-colors duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/></svg>
                        <span class="text-gray-900 dark:text-white">WHISKERÍAS</span>
                    </div>
                </div>
                <div class="flex flex-wrap justify-center gap-4 mb-16">
                    @foreach($whiskerias as $place)
                        <a href="{{ route('establishments.show', $place->id) }}" class="bg-white dark:bg-[#1c1c1e] rounded-lg overflow-hidden group block cursor-pointer border border-gray-200 dark:border-[#2c2c2e] w-[calc(50%-8px)] md:w-[calc(25%-12px)] lg:w-[calc(20%-13px)] transition-all duration-300 hover:border-[#f06e28] hover:shadow-[0_0_15px_rgba(240,110,40,0.3)] hover:-translate-y-1">
                            <div class="h-[250px] md:h-[300px] w-full overflow-hidden bg-black">
                                @php
                                    $cardImg = $place->banner_image ? (Str::startsWith($place->banner_image, ['http', 'https']) ? $place->banner_image : asset('storage/'.$place->banner_image)) : ($place->cover_image ? (Str::startsWith($place->cover_image, ['http', 'https']) ? $place->cover_image : asset('storage/'.$place->cover_image)) : 'https://via.placeholder.com/600x400/111111/f06e28?text=Whiskeria');
                                @endphp
                                <img src="{{ $cardImg }}" alt="{{ $place->name }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            </div>
                            <div class="p-3 flex items-center justify-between">
                                <h3 class="text-gray-900 dark:text-white font-semibold text-sm truncate">{{ $place->name }}</h3>
                                <div class="text-yellow-500 dark:text-yellow-400 border border-gray-200 dark:border-white/20 bg-gray-50 dark:bg-black/50 rounded-full px-2 py-0.5 flex flex-shrink-0 items-center justify-center text-[10px] font-bold gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="currentColor" stroke="none">
                                        <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                                    </svg>
                                    {{ number_format($place->rating ?? 0, 1) }}
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </section>
            @endif

            <!-- Massage Section -->
            @if($massageHouses->count() > 0)
            <section id="massage">
                <div class="flex justify-center mb-8 mt-4">
                    <div class="bg-white dark:bg-black border border-gray-200 dark:border-white/10 rounded-full px-6 py-2 flex items-center gap-3 text-sm font-bold uppercase tracking-widest text-[#e11d48] shadow-md transition-colors duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2"><path d="M2 4v16"/><path d="M2 8h18a2 2 0 0 1 2 2v10"/><path d="M2 17h20"/><path d="M6 8v9"/></svg>
                        <span class="text-gray-900 dark:text-white">CASAS DE MASAJES</span>
                    </div>
                </div>
                <div class="flex flex-wrap justify-center gap-4 mb-16">
                    @foreach($massageHouses as $place)
                        <a href="{{ route('establishments.show', $place->id) }}" class="bg-white dark:bg-[#1c1c1e] rounded-lg overflow-hidden group block cursor-pointer border border-gray-200 dark:border-[#2c2c2e] w-[calc(50%-8px)] md:w-[calc(25%-12px)] lg:w-[calc(20%-13px)] transition-all duration-300 hover:border-[#e11d48] hover:shadow-[0_0_15px_rgba(225,29,72,0.3)] hover:-translate-y-1">
                            <div class="h-[250px] md:h-[300px] w-full overflow-hidden bg-black">
                                @php
                                    $cardImg = $place->banner_image ? (Str::startsWith($place->banner_image, ['http', 'https']) ? $place->banner_image : asset('storage/'.$place->banner_image)) : ($place->cover_image ? (Str::startsWith($place->cover_image, ['http', 'https']) ? $place->cover_image : asset('storage/'.$place->cover_image)) : 'https://via.placeholder.com/600x400/111111/e11d48?text=Spa');
                                @endphp
                                <img src="{{ $cardImg }}" alt="{{ $place->name }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            </div>
                            <div class="p-3 flex items-center justify-between">
                                <h3 class="text-gray-900 dark:text-white font-semibold text-sm truncate">{{ $place->name }}</h3>
                                <div class="text-yellow-500 dark:text-yellow-400 border border-gray-200 dark:border-white/20 bg-gray-50 dark:bg-black/50 rounded-full px-2 py-0.5 flex flex-shrink-0 items-center justify-center text-[10px] font-bold gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="currentColor" stroke="none">
                                        <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                                    </svg>
                                    {{ number_format($place->rating ?? 0, 1) }}
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </section>
            @endif

            <!-- Motels Section -->
            @if($motels->count() > 0)
            <section id="motels">
                <div class="flex justify-center mb-8 mt-4">
                    <div class="bg-white dark:bg-black border border-gray-200 dark:border-white/10 rounded-full px-6 py-2 flex items-center gap-3 text-sm font-bold uppercase tracking-widest text-gray-900 dark:text-white shadow-md transition-colors duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                        <span>MOTELES / HOTELES DE ALTA ROTATIVIDAD</span>
                    </div>
                </div>
                <div class="flex flex-wrap justify-center gap-4 mb-16">
                    @foreach($motels as $place)
                        <a href="{{ route('establishments.show', $place->id) }}" class="bg-white dark:bg-[#1c1c1e] rounded-lg overflow-hidden group block cursor-pointer border border-gray-200 dark:border-[#2c2c2e] w-[calc(50%-8px)] md:w-[calc(25%-12px)] lg:w-[calc(20%-13px)] transition-all duration-300 hover:border-gray-400 dark:hover:border-white hover:shadow-[0_0_15px_rgba(0,0,0,0.1)] dark:hover:shadow-[0_0_15px_rgba(255,255,255,0.3)] hover:-translate-y-1">
                            <div class="h-[250px] md:h-[300px] w-full overflow-hidden bg-black">
                                @php
                                    $cardImg = $place->banner_image ? (Str::startsWith($place->banner_image, ['http', 'https']) ? $place->banner_image : asset('storage/'.$place->banner_image)) : ($place->cover_image ? (Str::startsWith($place->cover_image, ['http', 'https']) ? $place->cover_image : asset('storage/'.$place->cover_image)) : 'https://via.placeholder.com/600x400/111111/ffffff?text=Motel');
                                @endphp
                                <img src="{{ $cardImg }}" alt="{{ $place->name }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            </div>
                            <div class="p-3 flex items-center justify-between">
                                <h3 class="text-gray-900 dark:text-white font-semibold text-sm truncate">{{ $place->name }}</h3>
                                <div class="text-yellow-500 dark:text-yellow-400 border border-gray-200 dark:border-white/20 bg-gray-50 dark:bg-black/50 rounded-full px-2 py-0.5 flex flex-shrink-0 items-center justify-center text-[10px] font-bold gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="currentColor" stroke="none">
                                        <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                                    </svg>
                                    {{ number_format($place->rating ?? 0, 1) }}
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </section>
            @endif

        </div>
    </div>

    <!-- Leaflet CSS & JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var map = L.map('map').setView([-9.189967, -75.015152], 5);
            
            L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
                attribution: '&copy; OpenStreetMap contributors &copy; CARTO',
                subdomains: 'abcd',
                maxZoom: 20
            }).addTo(map);

            var establishments = @json($allEstablishments);

            // Coordinates for Peruvian departments
            const departmentCoords = {
                'Amazonas': [-6.2316, -77.8690],
                'Ancash': [-9.5277, -77.5277],
                'Apurímac': [-14.1500, -72.8833],
                'Arequipa': [-16.4090, -71.5375],
                'Ayacucho': [-13.1587, -74.2238],
                'Cajamarca': [-7.1637, -78.5002],
                'Callao': [-12.0565, -77.1181],
                'Cusco': [-13.5319, -71.9675],
                'Huancavelica': [-12.7826, -74.9726],
                'Huánuco': [-9.9306, -76.2422],
                'Ica': [-14.0677, -75.7286],
                'Junín': [-11.1581, -75.9930],
                'La Libertad': [-8.1091, -79.0215],
                'Lambayeque': [-6.7713, -79.9080],
                'Lima': [-12.0464, -77.0428],
                'Loreto': [-3.7491, -73.2538],
                'Madre de Dios': [-12.5933, -69.1836],
                'Moquegua': [-17.1983, -70.9356],
                'Pasco': [-10.6674, -76.2566],
                'Piura': [-5.1945, -80.6328],
                'Puno': [-15.8402, -70.0218],
                'San Martín': [-6.4872, -76.3603],
                'Tacna': [-18.0065, -70.2529],
                'Tumbes': [-3.5669, -80.4515],
                'Ucayali': [-8.3791, -74.5538]
            };

            const select = document.getElementById('department-select');
            Object.keys(departmentCoords).sort().forEach(dep => {
                const option = document.createElement('option');
                option.value = dep;
                option.textContent = dep;
                select.appendChild(option);
            });

            select.addEventListener('change', function() {
                const dep = this.value;
                if (dep && departmentCoords[dep]) {
                    map.setView(departmentCoords[dep], 9);
                } else {
                    map.setView([-9.189967, -75.015152], 5);
                }
            });

            function createCustomIcon(color, svgPath, tx, ty) {
                return L.divIcon({
                    className: 'custom-div-icon',
                    html: `<div style="background-color: ${color}; width: 36px; height: 36px; border-radius: 5px 5px 5px 0; display: flex; align-items: center; justify-content: center; border: 2px solid white; box-shadow: 0 4px 6px rgba(0,0,0,0.3); clip-path: polygon(0 0, 100% 0, 100% 100%, 50% 100%, 0 70%);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="${color === '#ffffff' ? 'black' : 'white'}" stroke="${color === '#ffffff' ? 'black' : 'white'}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="transform: translate(${tx}px, ${ty}px);">
                            ${svgPath}
                        </svg>
                    </div>`,
                    iconSize: [36, 36],
                    iconAnchor: [18, 36],
                    popupAnchor: [0, -36]
                });
            }

            var whiskeriaIcon = createCustomIcon('#f06e28', '<path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/>', -2, -2);
            var massageIcon = createCustomIcon('#e11d48', '<path d="M2 4v16"/><path d="M2 8h18a2 2 0 0 1 2 2v10"/><path d="M2 17h20"/><path d="M6 8v9"/>', -2, -2);
            var motelIcon = createCustomIcon('#ffffff', '<path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/>', -2, -2);

            establishments.forEach(function(place) {
                let lat = parseFloat(place.latitude);
                let lng = parseFloat(place.longitude);
                
                // Si el establecimiento no tiene lat/lng válido (ej. 0.00000000), usar lat/lng de la ciudad
                if ((!lat || !lng || (lat === 0 && lng === 0)) && place.city && departmentCoords[place.city]) {
                    lat = departmentCoords[place.city][0] + (Math.random() - 0.5) * 0.05;
                    lng = departmentCoords[place.city][1] + (Math.random() - 0.5) * 0.05;
                }

                if (lat && lng) {
                    var icon;
                    if(place.type === 'whiskeria') icon = whiskeriaIcon;
                    else if(place.type === 'massage') icon = massageIcon;
                    else icon = motelIcon;

                    var marker = L.marker([place.latitude, place.longitude], {icon: icon})
                 .addTo(map)
                 .bindPopup(`
                    <div class="text-black font-sans">
                        <strong class="text-xs uppercase" style="color: #666;">${place.type === 'massage' ? 'Casas de Masajes' : place.type}</strong><br>
                        <h3 class="text-lg font-bold leading-tight">${place.name}</h3>
                        <p class="text-sm text-gray-600 mt-1">${place.address}</p>
                        ${place.phone ? `<p class="text-sm mt-1">📞 ${place.phone}</p>` : ''}
                    </div>
                 `);

                marker.on('mouseover', function (e) {
                    this.openPopup();
                });
                marker.on('mouseout', function (e) {
                    this.closePopup();
                });
            }
            });
        });

        window.scrollToSection = function(id) {
            const section = document.getElementById(id);
            if(section) {
                section.scrollIntoView({behavior: 'smooth', block: 'start'});
            }
        }
    </script>
</x-main-layout>