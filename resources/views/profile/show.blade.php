<x-main-layout>

    <x-slot:title>
        {{ $escort->name }} - Escort en {{ $escort->city }}
        </x-slot>

        <!-- Profile Header / Hero -->
        <div class="relative bg-black text-white pt-20 pb-10">
            <div class="max-w-7xl mx-auto px-4 lg:px-8">
                <div class="flex flex-col md:flex-row gap-8 items-center md:items-start">

                    <!-- Profile Image -->
                    <div class="relative w-48 h-48 md:w-64 md:h-64 flex-shrink-0"
                        x-data="{ hasStories: {{ $escort->stories->count() > 0 ? 'true' : 'false' }} }">
                        <div @click="hasStories && $dispatch('open-story-viewer')"
                            :class="hasStories ? 'cursor-pointer border-4 border-transparent bg-gradient-to-tr from-red-500 via-red-600 to-red-800 p-1' : 'border-4 border-red-600'"
                            class="w-full h-full rounded-full overflow-hidden shadow-2xl transition-transform hover:scale-105">
                            <div class="relative w-full h-full rounded-full overflow-hidden bg-black">
                                @if($escort->profile_photo)
                                    @php
                                        $src = Str::startsWith($escort->profile_photo, ['http://', 'https://'])
                                            ? $escort->profile_photo
                                            : Storage::url($escort->profile_photo);
                                    @endphp
                                    <img src="{{ $src }}" alt="{{ $escort->name }}" class="w-full h-full object-cover">
                                @elseif($escort->photos && count($escort->photos) > 0)
                                    @php
                                        $photo = $escort->photos[0];
                                        $src = Str::startsWith($photo, ['http://', 'https://']) ? $photo : Storage::url($photo);
                                    @endphp
                                    <img src="{{ $src }}" alt="{{ $escort->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-zinc-800 flex items-center justify-center">
                                        <svg class="w-20 h-20 text-red-600" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                @endif

                                @if($escort->profile_photo || ($escort->photos && count($escort->photos) > 0))
                                    <!-- Watermark -->
                                    <div
                                        class="absolute inset-0 flex items-center justify-center pointer-events-none opacity-30 select-none">
                                        <span class="text-2xl md:text-3xl font-extrabold tracking-wider drop-shadow-lg uppercase"><span class="text-red-600">CITAS</span><span class="text-white">ESCORTS</span></span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Basic Info -->
                    <div class="flex-1 text-center md:text-left space-y-4">
                        <div class="flex items-center justify-center md:justify-start gap-3">
                            <h1 class="text-4xl font-bold">{{ $escort->name }}</h1>
                            @if(!auth()->check() || (auth()->check() && auth()->user()->role !== 'escort'))
                                @php
                                    $isLiked = Auth::check() ? Auth::user()->favorites->contains($escort->id) : false;
                                @endphp
                                <button x-data="{ 
                                                liked: {{ $isLiked ? 'true' : 'false' }},
                                                isLoading: false,
                                                async toggleLike() {
                                                    if (this.isLoading) return;
                                                    @guest
                                                        window.location.href = '{{ route('login') }}';
                                                        return;
                                                    @endguest

                                                    this.isLoading = true;
                                                    try {
                                                        const response = await fetch('{{ route('favorites.toggle', $escort->id) }}', {
                                                            method: 'POST',
                                                            headers: {
                                                                'Content-Type': 'application/json',
                                                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                                            }
                                                        });
                                                        if (response.ok) {
                                                            this.liked = !this.liked;
                                                        }
                                                    } catch (e) {
                                                        console.error(e);
                                                    } finally {
                                                        this.isLoading = false;
                                                    }
                                                }
                                            }" @click="toggleLike()"
                                    class="text-red-600 hover:scale-110 transition-transform focus:outline-none">
                                    <svg class="w-6 h-6" :class="liked ? 'fill-current' : 'fill-none'" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                </button>
                            @endif
                        </div>

                        <div class="text-xl text-gray-300">
                            {{ $escort->age }} años
                            @if($escort->gender)
                                • {{ $escort->gender }}
                            @endif
                            @if($escort->hair_color)
                                • pelo {{ $escort->hair_color }}
                            @endif
                        </div>

                        @if($escort->level === 'diamond')
                            <div
                                class="flex items-center justify-center md:justify-start gap-2 text-red-500 font-bold uppercase tracking-wider text-sm">
                                <svg class="w-4 h-4 text-red-500 fill-current" viewBox="0 0 24 24">
                                    <path d="M12 2L2 12l10 10 10-10L12 2z" />
                                </svg>
                                Diamante
                            </div>
                        @elseif($escort->level === 'silver')
                            <div
                                class="flex items-center justify-center md:justify-start gap-2 text-gray-400 font-bold uppercase tracking-wider text-sm">
                                Plata
                            </div>
                        @endif

                        @php
                            $reviewCount = $escort->reviews->count();
                            $averageRating = $reviewCount > 0 ? round($escort->reviews->avg('rating'), 1) : 0;
                        @endphp

                        <div class="flex items-center justify-center md:justify-start gap-1 text-red-500">
                            <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                </path>
                            </svg>
                            <span class="font-bold">{{ $averageRating }}</span>
                            <span class="text-gray-500 text-sm">({{ $reviewCount }})</span>
                        </div>

                        @if($escort->height)
                            <div class="text-gray-400 text-sm">Altura: {{ $escort->height }} m</div>
                        @endif

                        <!-- Description -->
                        <div class="text-gray-400 text-sm leading-relaxed max-w-2xl">
                            @php
                                $descriptionLength = strlen($escort->description ?? '');
                                $isLongDescription = $descriptionLength > 200;
                                $shortDescription = $isLongDescription ? substr($escort->description, 0, 200) . '...' : $escort->description;
                            @endphp

                            @if($isLongDescription)
                                <span id="short-description">{{ $shortDescription }}</span>
                                <span id="full-description" class="hidden">{{ $escort->description }}</span>
                                <button id="read-more-btn"
                                    class="text-red-500 hover:text-red-400 ml-1 hover:underline font-medium"
                                    onclick="toggleDescription()">
                                    Leer más
                                </button>
                            @else
                                {{ $escort->description }}
                            @endif
                        </div>

                        @if($isLongDescription)
                            <script>
                                function toggleDescription() {
                                    const shortDesc = document.getElementById('short-description');
                                    const fullDesc = document.getElementById('full-description');
                                    const btn = document.getElementById('read-more-btn');

                                    if (fullDesc.classList.contains('hidden')) {
                                        shortDesc.classList.add('hidden');
                                        fullDesc.classList.remove('hidden');
                                        btn.textContent = 'Leer menos';
                                    } else {
                                        shortDesc.classList.remove('hidden');
                                        fullDesc.classList.add('hidden');
                                        btn.textContent = 'Leer más';
                                    }
                                }
                            </script>
                        @endif

                        <!-- Contact Buttons (Main Area) -->
                        <div class="flex flex-wrap gap-4 pt-4">
                            <a href="tel:{{ $escort->phone }}"
                                class="border border-zinc-700 hover:border-gray-500 hover:bg-zinc-800 text-white py-2.5 px-6 rounded-lg font-bold flex items-center gap-2 transition-all min-w-[160px] justify-center">
                                <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                {{ $escort->phone ?? '099 123 456' }}
                            </a>

                            <a href="https://wa.me/{{ $escort->whatsapp }}" target="_blank"
                                class="bg-green-600 hover:bg-green-500 text-white py-2.5 px-6 rounded-lg font-bold flex items-center gap-2 transition-all min-w-[160px] justify-center shadow-lg shadow-green-900/20">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.232-.298.33-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z" />
                                </svg>
                                WhatsApp
                            </a>
                        </div>
                    </div>

                    <!-- Quick Actions (Desktop) -->
                    @if(auth()->check() && auth()->user()->role === 'user')
                    <div class="hidden md:flex flex-col gap-3 min-w-[200px] items-end">
                        <div class="flex gap-4">
                            <a href="#"
                                class="text-gray-400 hover:text-white flex items-center gap-2 text-sm transition-colors group">
                                <svg class="w-5 h-5 group-hover:text-red-500 transition-colors" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 21v-8a2 2 0 012-2h14a2 2 0 012 2v8M10 14h4M6 14v.01M18 14v.01M6 10a4 4 0 018 0 4 4 0 018 0" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                Reportar
                            </a>
                            <a href="#"
                                class="text-gray-400 hover:text-white flex items-center gap-2 text-sm transition-colors group">
                                <svg class="w-5 h-5 group-hover:text-red-600 transition-colors" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                                </svg>
                                Compartir
                            </a>
                        </div>
                    </div>
                    @endif
                </div>

ro -->
        <div class="relative bg-black text-white pt-20 pb-10">
            <div class="max-w-7xl mx-auto px-4 lg:px-8">
                <div class="flex flex-col md:flex-row gap-8 items-center md:items-start">

                    <!-- Profile Image -->
                    <div class="relative w-48 h-48 md:w-64 md:h-64 flex-shrink-0"
                        x-data="{ hasStories: {{ $escort->stories->count() > 0 ? 'true' : 'false' }} }">
                        <div @click="hasStories && $dispatch('open-story-viewer')"
                            :class="hasStories ? 'cursor-pointer border-4 border-transparent bg-gradient-to-tr from-red-500 via-red-600 to-red-800 p-1' : 'border-4 border-red-600'"
                            class="w-full h-full rounded-full overflow-hidden shadow-2xl transition-transform hover:scale-105">
                            <div class="relative w-full h-full rounded-full overflow-hidden bg-black">
                                @if($escort->profile_photo)
                                    @php
                                        $src = Str::startsWith($escort->profile_photo, ['http://', 'https://'])
                                            ? $escort->profile_photo
                                            : Storage::url($escort->profile_photo);
                                    @endphp
                                    <img src="{{ $src }}" alt="{{ $escort->name }}" class="w-full h-full object-cover">
                                @elseif($escort->photos && count($escort->photos) > 0)
                                    @php
                                        $photo = $escort->photos[0];
                                        $src = Str::startsWith($photo, ['http://', 'https://']) ? $photo : Storage::url($photo);
                                    @endphp
                                    <img src="{{ $src }}" alt="{{ $escort->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-zinc-800 flex items-center justify-center">
                                        <svg class="w-20 h-20 text-red-600" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                @endif

                                @if($escort->profile_photo || ($escort->photos && count($escort->photos) > 0))
                                    <!-- Watermark -->
                                    <div
                                        class="absolute inset-0 flex items-center justify-center pointer-events-none opacity-30 select-none">
                                        <span class="text-2xl md:text-3xl font-extrabold tracking-wider drop-shadow-lg uppercase"><span class="text-red-600">CITAS</span><span class="text-white">ESCORTS</span></span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Basic Info -->
                    <div class="flex-1 text-center md:text-left space-y-4">
                        <div class="flex items-center justify-center md:justify-start gap-3">
                            <h1 class="text-4xl font-bold">{{ $escort->name }}</h1>
                            @if(!auth()->check() || (auth()->check() && auth()->user()->role !== 'escort'))
                                @php
                                    $isLiked = Auth::check() ? Auth::user()->favorites->contains($escort->id) : false;
                                @endphp
                                <button x-data="{ 
                                                liked: {{ $isLiked ? 'true' : 'false' }},
                                                isLoading: false,
                                                async toggleLike() {
                                                    if (this.isLoading) return;
                                                    @guest
                                                        window.location.href = '{{ route('login') }}';
                                                        return;
                                                    @endguest

                                                    this.isLoading = true;
                                                    try {
                                                        const response = await fetch('{{ route('favorites.toggle', $escort->id) }}', {
                                                            method: 'POST',
                                                            headers: {
                                                                'Content-Type': 'application/json',
                                                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                                            }
                                                        });
                                                        if (response.ok) {
                                                            this.liked = !this.liked;
                                                        }
                                                    } catch (e) {
                                                        console.error(e);
                                                    } finally {
                                                        this.isLoading = false;
                                                    }
                                                }
                                            }" @click="toggleLike()"
                                    class="text-red-600 hover:scale-110 transition-transform focus:outline-none">
                                    <svg class="w-6 h-6" :class="liked ? 'fill-current' : 'fill-none'" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                </button>
                            @endif
                        </div>

                        <div class="text-xl text-gray-300">
                            {{ $escort->age }} años
                            @if($escort->gender)
                                • {{ $escort->gender }}
                            @endif
                            @if($escort->hair_color)
                                • pelo {{ $escort->hair_color }}
                            @endif
                        </div>

                        @if($escort->level === 'diamond')
                            <div
                                class="flex items-center justify-center md:justify-start gap-2 text-red-500 font-bold uppercase tracking-wider text-sm">
                                <svg class="w-4 h-4 text-red-500 fill-current" viewBox="0 0 24 24">
                                    <path d="M12 2L2 12l10 10 10-10L12 2z" />
                                </svg>
                                Diamante
                            </div>
                        @elseif($escort->level === 'silver')
                            <div
                                class="flex items-center justify-center md:justify-start gap-2 text-gray-400 font-bold uppercase tracking-wider text-sm">
                                Plata
                            </div>
                        @endif

                        @php
                            $reviewCount = $escort->reviews->count();
                            $averageRating = $reviewCount > 0 ? round($escort->reviews->avg('rating'), 1) : 0;
                        @endphp

                        <div class="flex items-center justify-center md:justify-start gap-1 text-red-500">
                            <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                </path>
                            </svg>
                            <span class="font-bold">{{ $averageRating }}</span>
                            <span class="text-gray-500 text-sm">({{ $reviewCount }})</span>
                        </div>

                        @if($escort->height)
                            <div class="text-gray-400 text-sm">Altura: {{ $escort->height }} m</div>
                        @endif

                        <!-- Description -->
                        <div class="text-gray-400 text-sm leading-relaxed max-w-2xl">
                            @php
                                $descriptionLength = strlen($escort->description ?? '');
                                $isLongDescription = $descriptionLength > 200;
                                $shortDescription = $isLongDescription ? substr($escort->description, 0, 200) . '...' : $escort->description;
                            @endphp

                            @if($isLongDescription)
                                <span id="short-description">{{ $shortDescription }}</span>
                                <span id="full-description" class="hidden">{{ $escort->description }}</span>
                                <button id="read-more-btn"
                                    class="text-red-500 hover:text-red-400 ml-1 hover:underline font-medium"
                                    onclick="toggleDescription()">
                                    Leer más
                                </button>
                            @else
                                {{ $escort->description }}
                            @endif
                        </div>

                        @if($isLongDescription)
                            <script>
                                function toggleDescription() {
                                    const shortDesc = document.getElementById('short-description');
                                    const fullDesc = document.getElementById('full-description');
                                    const btn = document.getElementById('read-more-btn');

                                    if (fullDesc.classList.contains('hidden')) {
                                        shortDesc.classList.add('hidden');
                                        fullDesc.classList.remove('hidden');
                                        btn.textContent = 'Leer menos';
                                    } else {
                                        shortDesc.classList.remove('hidden');
                                        fullDesc.classList.add('hidden');
                                        btn.textContent = 'Leer más';
                                    }
                                }
                            </script>
                        @endif

                        <!-- Contact Buttons (Main Area) -->
                        <div class="flex flex-wrap gap-4 pt-4">
                            <a href="tel:{{ $escort->phone }}"
                                class="border border-zinc-700 hover:border-gray-500 hover:bg-zinc-800 text-white py-2.5 px-6 rounded-lg font-bold flex items-center gap-2 transition-all min-w-[160px] justify-center">
                                <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                {{ $escort->phone ?? '099 123 456' }}
                            </a>

                            <a href="https://wa.me/{{ $escort->whatsapp }}" target="_blank"
                                class="bg-green-600 hover:bg-green-500 text-white py-2.5 px-6 rounded-lg font-bold flex items-center gap-2 transition-all min-w-[160px] justify-center shadow-lg shadow-green-900/20">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.232-.298.33-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z" />
                                </svg>
                                WhatsApp
                            </a>
                        </div>
                    </div>

                    <!-- Quick Actions (Desktop) -->
                    @if(auth()->check() && auth()->user()->role === 'user')
                    <div class="hidden md:flex flex-col gap-3 min-w-[200px] items-end">
                        <div class="flex gap-4">
                            <a href="#"
                                class="text-gray-400 hover:text-white flex items-center gap-2 text-sm transition-colors group">
                                <svg class="w-5 h-5 group-hover:text-red-500 transition-colors" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 21v-8a2 2 0 012-2h14a2 2 0 012 2v8M10 14h4M6 14v.01M18 14v.01M6 10a4 4 0 018 0 4 4 0 018 0" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                Reportar
                            </a>
                            <a href="#"
                                class="text-gray-400 hover:text-white flex items-center gap-2 text-sm transition-colors group">
                                <svg class="w-5 h-5 group-hover:text-red-600 transition-colors" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                                </svg>
                                Compartir
                            </a>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Quick Stats Bar (Reference Match) -->
                <div class="mt-12 border-y border-zinc-700 bg-black">
                    <div class="grid grid-cols-1 md:grid-cols-5 divide-y md:divide-y-0 md:divide-x divide-zinc-700">
                        <!-- Ubicación -->
                        <div class="p-6">
                            <div class="text-white font-bold text-sm mb-2 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                Ubicación
                            </div>
                            <div class="text-gray-300 text-sm">{{ $escort->city }}</div>
                        </div>

                        <!-- Tarifa -->
                        <div class="p-6">
                            <div class="text-white font-bold text-sm mb-2 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Tarifa
                            </div>
                            <div class="text-gray-300 text-sm space-y-1">
                                @if($escort->price)
                                <div>1 hora - S/{{ number_format($escort->price, 0) }}</div> @endif
                                @if($escort->cost_30m)
                                <div>30 minutos - S/{{ number_format($escort->cost_30m, 0) }}</div> @endif
                            </div>
                        </div>

                        <!-- Atiende en -->
                        <div class="p-6">
                            <div class="text-white font-bold text-sm mb-2 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                                Atiende en
                            </div>
                            <div class="text-gray-300 text-sm">
                                @if(!empty($escort->attends_in))
                                    {{ implode(', ', $escort->attends_in) }}
                                @else
                                    Consultar
                                @endif
                            </div>
                        </div>

                        <!-- Atiende a -->
                        <div class="p-6">
                            <div class="text-white font-bold text-sm mb-2 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                Atiende a
                            </div>
                            <div class="text-gray-300 text-sm">
                                @if(!empty($escort->attends_to))
                                    {{ implode(', ', $escort->attends_to) }}
                                @else
                                    Todos
                                @endif
                            </div>
                        </div>

                        <!-- Horarios -->
                        <div class="p-6">
                            <div class="text-white font-bold text-sm mb-2 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Horarios
                            </div>
                            <div class="text-gray-300 text-sm">
                                @if($escort->schedule)
                                    {{ $escort->schedule }}
                                @else
                                    Consultar disponibilidad
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="bg-black min-h-screen">


            <!-- Tab Content -->
            <div class="max-w-7xl mx-auto px-4 lg:px-8 py-8">

                <!-- Principal Tab: Gallery -->
                @php
                    $lightboxMedia = [];
                    if (!empty($escort->photos)) {
                        $lightboxMedia = collect($escort->photos)->map(function ($photo) {
                            $src = Str::startsWith($photo, ['http://', 'https://']) ? $photo : Storage::url($photo);
                            $extension = pathinfo($photo, PATHINFO_EXTENSION);
                            $isVideo = in_array(strtolower($extension), ['mp4', 'mov', 'avi', 'webm']);
                            return [
                                'src' => $src,
                                'type' => $isVideo ? 'video' : 'image',
                                'extension' => $extension,
                                'mime' => $isVideo ? ($extension === 'mov' ? 'quicktime' : $extension) : null
                            ];
                        })->values()->toArray();
                    }
                @endphp

                <div x-data='{
                        showLightbox: false,
                        currentIndex: 0,
                        zoomLevel: 1,
                        media: @json($lightboxMedia),
                        
                        openLightbox(index) {
                            this.currentIndex = index;
                            this.showLightbox = true;
                            this.zoomLevel = 1;
                            document.body.style.overflow = "hidden";
                        },
                        
                        closeLightbox() {
                            this.showLightbox = false;
                            this.zoomLevel = 1;
                            document.body.style.overflow = "";
                            // Pause all videos
                            document.querySelectorAll(".lightbox-video").forEach(vid => vid.pause());
                        },
                        
                        next() {
                            if (this.currentIndex < this.media.length - 1) {
                                this.currentIndex++;
                                this.zoomLevel = 1;
                            } else {
                                this.currentIndex = 0; // Loop to start
                                this.zoomLevel = 1;
                            }
                        },
                        
                        prev() {
                            if (this.currentIndex > 0) {
                                this.currentIndex--;
                                this.zoomLevel = 1;
                            } else {
                                this.currentIndex = this.media.length - 1; // Loop to end
                                this.zoomLevel = 1;
                            }
                        },

                        zoomIn() {
                            if (this.zoomLevel < 3) this.zoomLevel += 0.5;
                        },

                        zoomOut() {
                            if (this.zoomLevel > 1) this.zoomLevel -= 0.5;
                        },

                        get currentMedia() {
                            return this.media[this.currentIndex];
                        }
                    }' @keydown.escape.window="closeLightbox()" @keydown.arrow-right.window="next()"
                    @keydown.arrow-left.window="prev()">

                    <!-- Gallery Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @if(!empty($escort->photos))
                            @foreach($escort->photos as $index => $photo)
                                @php
                                    $src = Str::startsWith($photo, ['http://', 'https://']) ? $photo : Storage::url($photo);
                                    $extension = pathinfo($photo, PATHINFO_EXTENSION);
                                    $isVideo = in_array(strtolower($extension), ['mp4', 'mov', 'avi', 'webm']);
                                @endphp
                                <div @click="openLightbox({{ $index }})"
                                    class="aspect-[3/4] bg-zinc-900 rounded-lg overflow-hidden group relative cursor-pointer">

                                    @if($isVideo)
                                        <video autoplay loop muted playsinline
                                            class="w-full h-full object-cover pointer-events-none">
                                            <source src="{{ $src }}"
                                                type="video/{{ $extension === 'mov' ? 'quicktime' : $extension }}">
                                        </video>

                                    @else
                                        <img src="{{ $src }}" alt="Foto de {{ $escort->name }}"
                                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">

                                        <!-- Watermark -->
                                        <div
                                            class="absolute inset-0 flex items-center justify-center pointer-events-none opacity-30 select-none">
                                            <span class="text-xl md:text-2xl font-extrabold tracking-wider drop-shadow-lg uppercase"><span class="text-red-600">CITAS</span><span class="text-white">ESCORTS</span></span>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        @else
                            <div class="col-span-3 text-center py-10 text-gray-500">No hay fotos disponibles.</div>
                        @endif
                    </div>

                    <!-- Lightbox Modal -->
                    <div x-show="showLightbox" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                        x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0"
                        class="fixed inset-0 z-[100] bg-black flex items-center justify-center p-4">

                        <!-- Close Button -->
                        <button @click="closeLightbox()"
                            class="absolute top-4 right-4 text-white hover:text-gray-300 z-50 p-2">
                            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>

                        <!-- Navigation - Prev -->
                        <button @click.stop="prev()"
                            class="absolute left-4 top-1/2 -translate-y-1/2 text-white hover:text-gray-300 z-50 p-2 hidden md:block">
                            <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>

                        <!-- Navigation - Next -->
                        <button @click.stop="next()"
                            class="absolute right-4 top-1/2 -translate-y-1/2 text-white hover:text-gray-300 z-50 p-2 hidden md:block">
                            <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </button>

                        <!-- Main Content Area -->
                        <div class="relative w-full h-full flex items-center justify-center"
                            @click.outside="closeLightbox()">

                            <!-- Image Display -->
                            <template x-if="currentMedia.type === 'image'">
                                <div class="relative overflow-hidden w-full h-full flex items-center justify-center">
                                    <img :src="currentMedia.src"
                                        class="max-w-full max-h-full object-contain transition-transform duration-200"
                                        :style="`transform: scale(${zoomLevel})`">

                                    <!-- Zoom Controls -->
                                    <div
                                        class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-4 bg-black/50 rounded-full px-4 py-2 backdrop-blur-sm">
                                        <button @click.stop="zoomOut()"
                                            class="text-white hover:text-gray-300 disabled:opacity-50"
                                            :disabled="zoomLevel <= 1">
                                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M20 12H4" />
                                            </svg>
                                        </button>
                                        <span class="text-white font-mono min-w-[3ch] text-center"
                                            x-text="Math.round(zoomLevel * 100) + '%'"></span>
                                        <button @click.stop="zoomIn()"
                                            class="text-white hover:text-gray-300 disabled:opacity-50"
                                            :disabled="zoomLevel >= 3">
                                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 4v16m8-8H4" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </template>

                            <!-- Video Display -->
                            <template x-if="currentMedia.type === 'video'">
                                <div class="w-full h-full flex items-center justify-center">
                                    <video :src="currentMedia.src" controls autoplay loop
                                        class="lightbox-video max-w-full max-h-full max-w-[90vw] max-h-[90vh]">
                                        Tu navegador no soporta video.
                                    </video>
                                </div>
                            </template>

                        </div>
                    </div>
                </div>

ro -->
        <div class="relative bg-black text-white pt-20 pb-10">
            <div class="max-w-7xl mx-auto px-4 lg:px-8">
                <div class="flex flex-col md:flex-row gap-8 items-center md:items-start">

                    <!-- Profile Image -->
                    <div class="relative w-48 h-48 md:w-64 md:h-64 flex-shrink-0"
                        x-data="{ hasStories: {{ $escort->stories->count() > 0 ? 'true' : 'false' }} }">
                        <div @click="hasStories && $dispatch('open-story-viewer')"
                            :class="hasStories ? 'cursor-pointer border-4 border-transparent bg-gradient-to-tr from-red-500 via-red-600 to-red-800 p-1' : 'border-4 border-red-600'"
                            class="w-full h-full rounded-full overflow-hidden shadow-2xl transition-transform hover:scale-105">
                            <div class="relative w-full h-full rounded-full overflow-hidden bg-black">
                                @if($escort->profile_photo)
                                    @php
                                        $src = Str::startsWith($escort->profile_photo, ['http://', 'https://'])
                                            ? $escort->profile_photo
                                            : Storage::url($escort->profile_photo);
                                    @endphp
                                    <img src="{{ $src }}" alt="{{ $escort->name }}" class="w-full h-full object-cover">
                                @elseif($escort->photos && count($escort->photos) > 0)
                                    @php
                                        $photo = $escort->photos[0];
                                        $src = Str::startsWith($photo, ['http://', 'https://']) ? $photo : Storage::url($photo);
                                    @endphp
                                    <img src="{{ $src }}" alt="{{ $escort->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-zinc-800 flex items-center justify-center">
                                        <svg class="w-20 h-20 text-red-600" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                @endif

                                @if($escort->profile_photo || ($escort->photos && count($escort->photos) > 0))
                                    <!-- Watermark -->
                                    <div
                                        class="absolute inset-0 flex items-center justify-center pointer-events-none opacity-30 select-none">
                                        <span class="text-2xl md:text-3xl font-extrabold tracking-wider drop-shadow-lg uppercase"><span class="text-red-600">CITAS</span><span class="text-white">ESCORTS</span></span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Basic Info -->
                    <div class="flex-1 text-center md:text-left space-y-4">
                        <div class="flex items-center justify-center md:justify-start gap-3">
                            <h1 class="text-4xl font-bold">{{ $escort->name }}</h1>
                            @if(!auth()->check() || (auth()->check() && auth()->user()->role !== 'escort'))
                                @php
                                    $isLiked = Auth::check() ? Auth::user()->favorites->contains($escort->id) : false;
                                @endphp
                                <button x-data="{ 
                                                liked: {{ $isLiked ? 'true' : 'false' }},
                                                isLoading: false,
                                                async toggleLike() {
                                                    if (this.isLoading) return;
                                                    @guest
                                                        window.location.href = '{{ route('login') }}';
                                                        return;
                                                    @endguest

                                                    this.isLoading = true;
                                                    try {
                                                        const response = await fetch('{{ route('favorites.toggle', $escort->id) }}', {
                                                            method: 'POST',
                                                            headers: {
                                                                'Content-Type': 'application/json',
                                                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                                            }
                                                        });
                                                        if (response.ok) {
                                                            this.liked = !this.liked;
                                                        }
                                                    } catch (e) {
                                                        console.error(e);
                                                    } finally {
                                                        this.isLoading = false;
                                                    }
                                                }
                                            }" @click="toggleLike()"
                                    class="text-red-600 hover:scale-110 transition-transform focus:outline-none">
                                    <svg class="w-6 h-6" :class="liked ? 'fill-current' : 'fill-none'" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                </button>
                            @endif
                        </div>

                        <div class="text-xl text-gray-300">
                            {{ $escort->age }} años
                            @if($escort->gender)
                                • {{ $escort->gender }}
                            @endif
                            @if($escort->hair_color)
                                • pelo {{ $escort->hair_color }}
                            @endif
                        </div>

                        @if($escort->level === 'diamond')
                            <div
                                class="flex items-center justify-center md:justify-start gap-2 text-red-500 font-bold uppercase tracking-wider text-sm">
                                <svg class="w-4 h-4 text-red-500 fill-current" viewBox="0 0 24 24">
                                    <path d="M12 2L2 12l10 10 10-10L12 2z" />
                                </svg>
                                Diamante
                            </div>
                        @elseif($escort->level === 'silver')
                            <div
                                class="flex items-center justify-center md:justify-start gap-2 text-gray-400 font-bold uppercase tracking-wider text-sm">
                                Plata
                            </div>
                        @endif

                        @php
                            $reviewCount = $escort->reviews->count();
                            $averageRating = $reviewCount > 0 ? round($escort->reviews->avg('rating'), 1) : 0;
                        @endphp

                        <div class="flex items-center justify-center md:justify-start gap-1 text-red-500">
                            <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                </path>
                            </svg>
                            <span class="font-bold">{{ $averageRating }}</span>
                            <span class="text-gray-500 text-sm">({{ $reviewCount }})</span>
                        </div>

                        @if($escort->height)
                            <div class="text-gray-400 text-sm">Altura: {{ $escort->height }} m</div>
                        @endif

                        <!-- Description -->
                        <div class="text-gray-400 text-sm leading-relaxed max-w-2xl">
                            @php
                                $descriptionLength = strlen($escort->description ?? '');
                                $isLongDescription = $descriptionLength > 200;
                                $shortDescription = $isLongDescription ? substr($escort->description, 0, 200) . '...' : $escort->description;
                            @endphp

                            @if($isLongDescription)
                                <span id="short-description">{{ $shortDescription }}</span>
                                <span id="full-description" class="hidden">{{ $escort->description }}</span>
                                <button id="read-more-btn"
                                    class="text-red-500 hover:text-red-400 ml-1 hover:underline font-medium"
                                    onclick="toggleDescription()">
                                    Leer más
                                </button>
                            @else
                                {{ $escort->description }}
                            @endif
                        </div>

                        @if($isLongDescription)
                            <script>
                                function toggleDescription() {
                                    const shortDesc = document.getElementById('short-description');
                                    const fullDesc = document.getElementById('full-description');
                                    const btn = document.getElementById('read-more-btn');

                                    if (fullDesc.classList.contains('hidden')) {
                                        shortDesc.classList.add('hidden');
                                        fullDesc.classList.remove('hidden');
                                        btn.textContent = 'Leer menos';
                                    } else {
                                        shortDesc.classList.remove('hidden');
                                        fullDesc.classList.add('hidden');
                                        btn.textContent = 'Leer más';
                                    }
                                }
                            </script>
                        @endif

                        <!-- Contact Buttons (Main Area) -->
                        <div class="flex flex-wrap gap-4 pt-4">
                            <a href="tel:{{ $escort->phone }}"
                                class="border border-zinc-700 hover:border-gray-500 hover:bg-zinc-800 text-white py-2.5 px-6 rounded-lg font-bold flex items-center gap-2 transition-all min-w-[160px] justify-center">
                                <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                {{ $escort->phone ?? '099 123 456' }}
                            </a>

                            <a href="https://wa.me/{{ $escort->whatsapp }}" target="_blank"
                                class="bg-green-600 hover:bg-green-500 text-white py-2.5 px-6 rounded-lg font-bold flex items-center gap-2 transition-all min-w-[160px] justify-center shadow-lg shadow-green-900/20">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.232-.298.33-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z" />
                                </svg>
                                WhatsApp
                            </a>
                        </div>
                    </div>

                    <!-- Quick Actions (Desktop) -->
                    @if(auth()->check() && auth()->user()->role === 'user')
                    <div class="hidden md:flex flex-col gap-3 min-w-[200px] items-end">
                        <div class="flex gap-4">
                            <a href="#"
                                class="text-gray-400 hover:text-white flex items-center gap-2 text-sm transition-colors group">
                                <svg class="w-5 h-5 group-hover:text-red-500 transition-colors" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 21v-8a2 2 0 012-2h14a2 2 0 012 2v8M10 14h4M6 14v.01M18 14v.01M6 10a4 4 0 018 0 4 4 0 018 0" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                Reportar
                            </a>
                            <a href="#"
                                class="text-gray-400 hover:text-white flex items-center gap-2 text-sm transition-colors group">
                                <svg class="w-5 h-5 group-hover:text-red-600 transition-colors" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                                </svg>
                                Compartir
                            </a>
                        </div>
                    </div>
                    @endif
                </div>



                <!-- Sobre Section (New Request) -->
                <div class="mt-16 mb-8">
                    <div class="text-center mb-12">
                        <h2 class="text-3xl font-bold text-white mb-2">Sobre {{ $escort->name }}</h2>
                        <div class="text-red-600 text-sm font-medium">
                            <a href="/" class="hover:underline">Inicio</a> | <a
                                href="/?city={{ urlencode($escort->city) }}"
                                class="hover:underline">{{ $escort->city }}</a> | <span
                                class="text-gray-400">{{ $escort->name }}</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                        <!-- Left Column: Services & Details -->
                        <div class="lg:col-span-2 space-y-8">

                            <!-- Servicios -->
                            <div>
                                <h3 class="text-xl font-bold text-white mb-4 flex items-center gap-2">
                                    <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                    Servicios
                                </h3>
                                <div class="flex flex-wrap gap-3">
                                    @foreach($escort->services ?? [] as $service)
                                        <span
                                            class="px-5 py-2 bg-[#FCE7D4] text-black rounded-full text-sm font-bold shadow-sm">
                                            {{ $service }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Sexo Oral (Placeholder based on reference) -->
                            <div>
                                <h3 class="text-xl font-bold text-white mb-4 flex items-center gap-2">
                                    <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9.879 16.121A3 3 0 1012.015 11L11 14H9c0 .768.293 1.536.879 2.121z" />
                                    </svg>
                                    Sexo Oral
                                </h3>
                                <div class="flex flex-wrap gap-3">
                                    @if(!empty($escort->oral_sex))
                                        <span class="px-5 py-2 bg-[#FCE7D4] text-black rounded-full text-sm font-bold shadow-sm">{{ $escort->oral_sex }}</span>
                                    @endif
                                </div>
                            </div>

                            <!-- Fantasías -->
                            <div>
                                <h3 class="text-xl font-bold text-white mb-4 flex items-center gap-2">
                                    <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                    Fantasías
                                </h3>
                                <div class="flex flex-wrap gap-3">
                                    @foreach($escort->fantasies ?? [] as $fantasy)
                                        <span class="px-5 py-2 bg-[#FCE7D4] text-black rounded-full text-sm font-bold shadow-sm">{{ $fantasy }}</span>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Servicios Virtuales -->
                            <div>
                                <h3 class="text-xl font-bold text-white mb-4 flex items-center gap-2">
                                    <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                    </svg>
                                    Servicios Virtuales
                                </h3>
                                <div class="flex flex-wrap gap-3">
                                    @foreach($escort->virtual_services ?? [] as $service)
                                        <span
                                            class="px-5 py-2 bg-[#FCE7D4] text-black rounded-full text-sm font-bold shadow-sm">
                                            {{ $service }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>

                        </div>

                        <!-- Right Column: Social Media -->
                        <div>
                            <h3 class="text-xl font-bold text-white mb-6">Mis redes sociales</h3>
                            <div class="space-y-3">
                                @if($escort->instagram)
                                    @php
                                        // If it's a full URL, use it as is. Otherwise, build Instagram URL
                                        if (str_starts_with($escort->instagram, 'http')) {
                                            $instagramUrl = $escort->instagram;
                                        } else {
                                            // Remove @ if present and any instagram.com/ prefix
                                            $username = str_replace(['@', 'instagram.com/', 'www.instagram.com/'], '', $escort->instagram);
                                            $instagramUrl = 'https://instagram.com/' . trim($username, '/');
                                        }
                                    @endphp
                                    <a href="{{ $instagramUrl }}" target="_blank" rel="noopener noreferrer"
                                        class="text-red-600 hover:text-white transition-colors flex items-center gap-2 text-lg">
                                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                                        </svg>
                                        Instagram
                                    </a>
                                @endif

                                @if($escort->twitter)
                                    @php
                                        // If it's a full URL, use it as is. Otherwise, build Twitter/X URL
                                        if (str_starts_with($escort->twitter, 'http')) {
                                            $twitterUrl = $escort->twitter;
                                        } else {
                                            // Remove @ if present and any x.com/ or twitter.com/ prefix
                                            $username = str_replace(['@', 'x.com/', 'twitter.com/', 'www.x.com/', 'www.twitter.com/'], '', $escort->twitter);
                                            $twitterUrl = 'https://x.com/' . trim($username, '/');
                                        }
                                    @endphp
                                    <a href="{{ $twitterUrl }}" target="_blank" rel="noopener noreferrer"
                                        class="text-red-600 hover:text-white transition-colors flex items-center gap-2 text-lg">
                                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
                                        </svg>
                                        Twitter / X
                                    </a>
                                @endif

                                @if($escort->onlyfans)
                                    @php
                                        // If it's a full URL, use it as is. Otherwise, build OnlyFans URL
                                        if (str_starts_with($escort->onlyfans, 'http')) {
                                            $onlyfansUrl = $escort->onlyfans;
                                        } else {
                                            // Remove @ if present and any onlyfans.com/ prefix
                                            $username = str_replace(['@', 'onlyfans.com/', 'www.onlyfans.com/'], '', $escort->onlyfans);
                                            $onlyfansUrl = 'https://onlyfans.com/' . trim($username, '/');
                                        }
                                    @endphp
                                    <a href="{{ $onlyfansUrl }}" target="_blank" rel="noopener noreferrer"
                                        class="text-red-600 hover:text-white transition-colors flex items-center gap-2 text-lg">
                                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                d="M9.5,18.5 L9.25935025,18.495941 C5.50478338,18.3690987 2.5,15.2854517 2.5,11.5 C2.5,7.63400675 5.63400675,4.5 9.5,4.5 C11.3012014,4.5 12.9435096,5.18030286 14.183995,6.2979791 M22.5,4.5 C22.080741,6.80592468 20.5109608,8.65586968 18.4478484,9.50136057 L21,9.5 C20.4396226,11.7415095 18.4932197,13.3451035 16.212802,13.4893966 C15.3786612,16.3121954 12.810235,18.3922397 9.74064975,18.495941 L9.5,18.5 L13.3148864,7.81831802 C14.0255881,5.82835319 15.9105278,4.5 18.023596,4.5 L22.5,4.5 Z M9.5,13.5 C10.6045695,13.5 11.5,12.6045695 11.5,11.5 C11.5,10.3954305 10.6045695,9.5 9.5,9.5 C8.3954305,9.5 7.5,10.3954305 7.5,11.5 C7.5,12.6045695 8.3954305,13.5 9.5,13.5 Z" />
                                        </svg>
                                        OnlyFans
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Reviews Section (Visible on Principal) -->
                <div class="mt-16 mb-8 border-t border-zinc-900 pt-16">
                    <div x-data="{ showForm: false }">
                        <div class="flex justify-between items-center mb-8">
                            <h3 class="text-xl font-bold text-white">Comentarios sobre {{ $escort->name }}</h3>
                            @if(!auth()->check() || (auth()->check() && auth()->user()->role !== 'escort'))
                                <button @click="showForm = !showForm"
                                    class="bg-red-600 hover:opacity-90 text-white px-6 py-2 rounded text-sm font-bold flex items-center gap-2 transition-colors">
                                    Comentar <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                </button>
                            @endif
                        </div>

                        @if(!auth()->check() || (auth()->check() && auth()->user()->role !== 'escort'))
                            <div class="text-center text-gray-400 text-sm mb-8 italic">
                                Algunas opiniones pueden no mostrarse públicamente.
                            </div>

                            <!-- Review Form -->
                            @if(session('success'))
                                <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show"
                                    x-transition
                                    class="mb-8 bg-green-900/50 border border-green-500 text-green-200 px-6 py-4 rounded-lg">
                                    {{ session('success') }}
                                </div>
                            @endif

                            <div x-show="showForm" x-transition
                                class="mb-12 bg-zinc-900 text-white p-8 rounded-lg max-w-2xl mx-auto shadow-xl border border-zinc-800">
                                <form action="{{ route('reviews.store', $escort->id) }}" method="POST" class="space-y-6">
                                    @csrf
                                    <div>
                                        <label class="block text-red-600 font-bold mb-2">Nombre *</label>
                                        <input type="text" name="name"
                                            class="w-full bg-black border border-zinc-700 rounded px-4 py-3 text-white focus:outline-none focus:border-red-600"
                                            placeholder=""
                                            value="{{ auth()->check() ? auth()->user()->name : old('name') }}" required>
                                        <p class="text-gray-500 text-sm mt-1">No tenés que usar tu nombre real</p>
                                        @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>
                                    <div x-data="{ rating: {{ old('rating', 0) }}, hoverRating: 0 }">
                                        <label class="block text-red-600 font-bold mb-2">Puntaje de la experiencia
                                            *</label>
                                        <input type="hidden" name="rating" :value="rating">
                                        <div class="flex gap-1 text-2xl cursor-pointer">
                                            <template x-for="i in 5">
                                                <button type="button" @click="rating = i" @mouseenter="hoverRating = i"
                                                    @mouseleave="hoverRating = 0"
                                                    :class="(hoverRating >= i || (hoverRating === 0 && rating >= i)) ? 'text-red-500' : 'text-gray-600'"
                                                    class="focus:outline-none transition-colors">â˜…</button>
                                            </template>
                                        </div>
                                        @error('rating') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-red-600 font-bold mb-2">Tu experiencia con
                                            {{ $escort->name }} *</label>
                                        <textarea name="content" rows="4"
                                            class="w-full bg-black border border-zinc-700 rounded px-4 py-3 text-white focus:outline-none focus:border-red-600"
                                            placeholder="Cuéntanos tu experiencia con {{ $escort->name }}. Sé amable."
                                            required>{{ old('content') }}</textarea>
                                        @error('content') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-red-600 font-bold mb-2">Comentarios PRIVADOS (sólo los
                                            lee el staff de Citasescort)</label>
                                        <textarea name="private_content" rows="3"
                                            class="w-full bg-black border border-zinc-700 rounded px-4 py-3 text-white focus:outline-none focus:border-red-600"
                                            placeholder="Podés expresarte libremente.">{{ old('private_content') }}</textarea>
                                    </div>
                                    <button type="submit"
                                        class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-4 rounded transition-colors uppercase tracking-wider">
                                        Enviar Comentario
                                    </button>
                                </form>
                            </div>
                        @endif

                        <!-- Reviews List -->
                        <div class="space-y-4">
                            @forelse($escort->reviews->where('is_public', true) as $review)
                                <div class="bg-[#111111] p-6 rounded-lg border border-zinc-800/50">
                                    <div class="flex justify-between items-start mb-2">
                                        <div>
                                            <h4 class="text-white font-bold">{{ $review->name }}</h4>
                                            <div class="flex text-red-500 text-sm my-1">
                                                @for($i = 0; $i < $review->rating; $i++)
                                                    â˜…
                                                @endfor
                                            </div>
                                        </div>
                                        <span
                                            class="text-gray-400 text-sm">{{ $review->created_at->format('d/m/Y') }}</span>
                                    </div>
                                    <p class="text-gray-300">{{ $review->content }}</p>
                                </div>
                            @empty
                                <div class="text-center py-10 bg-[#111111] rounded-lg border border-dashed border-zinc-800">
                                    <p class="text-gray-400">Aún no hay comentarios.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Similar Profiles Section -->
                @if(isset($similarEscorts) && $similarEscorts->count() > 0)
                            <div class="mt-20 mb-12">
                                <h3 class="text-center text-white text-xl font-bold mb-10">Perfiles similares</h3>
                                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                                    @foreach($similarEscorts as $similar)
                                        <x-escort-card :escort="$similar" />
                                    @endforeach
                                </div>
                            </div>

                        </div>
                    </div>
                @endif

        <!-- Scroll to Top Button -->
        <div x-data="{ 
            scrollProgress: 0,
            showButton: false,
            updateScroll() {
                const scrollTop = window.scrollY;
                const docHeight = document.documentElement.scrollHeight - window.innerHeight;
                this.scrollProgress = docHeight > 0 ? (scrollTop / docHeight) * 100 : 0;
                this.showButton = scrollTop > 300;
            },
            scrollToTop() {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
         }" @scroll.window="updateScroll()" class="fixed bottom-8 right-8 z-50 transform transition-all duration-300"
            :class="{ 'translate-y-0 opacity-100': showButton, 'translate-y-10 opacity-0 pointer-events-none': !showButton }">

            <button @click="scrollToTop()"
                class="group relative flex items-center justify-center w-12 h-12 bg-black rounded-full shadow-lg hover:shadow-red-600/20 transition-shadow border border-zinc-800">
                <!-- Progress Ring -->
                <svg class="absolute inset-0 w-full h-full -rotate-90 pointer-events-none" viewBox="0 0 36 36">
                    <!-- Background Ring (Dark) -->
                    <path class="text-zinc-800"
                        d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none"
                        stroke="currentColor" stroke-width="3" />
                    <!-- Progress Ring (Pink) -->
                    <path class="text-red-600 transition-all duration-100 ease-out"
                        :stroke-dasharray="scrollProgress + ', 100'"
                        d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none"
                        stroke="currentColor" stroke-width="3" />
                </svg>

                <!-- Arrow Icon -->
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="w-5 h-5 text-gray-300 group-hover:text-white group-hover:-translate-y-1 transition-all"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5 10l7-7m0 0l7 7m-7-7v18" />
                </svg>
            </button>
        </div>

        <!-- Story Viewer Modal -->
        @if($escort->stories->count() > 0)
            <div x-data="{
                                        showStories: false,
                                        currentIndex: 0,
                                        stories: {{ $escort->stories->toJson() }},
                                        progress: 0,
                                        interval: null,

                                        openStories() {
                                            this.showStories = true;
                                            this.currentIndex = 0;
                                            this.startProgress();
                                            document.body.style.overflow = 'hidden';
                                        },

                                        closeStories() {
                                            this.showStories = false;
                                            this.stopProgress();
                                            document.body.style.overflow = '';
                                        },

                                        getTimeAgo(dateString) {
                                            if (!dateString) return '';
                                            
                                            const date = new Date(dateString);
                                            const now = new Date();
                                            const diffInSeconds = Math.floor((now - date) / 1000);
                                            
                                            if (diffInSeconds < 60) return 'HACE UNOS SEGUNDOS';
                                            
                                            const diffInMinutes = Math.floor(diffInSeconds / 60);
                                            if (diffInMinutes < 60) return `HACE ${diffInMinutes} MINUTOS`;
                                            
                                            const diffInHours = Math.floor(diffInMinutes / 60);
                                            if (diffInHours < 24) return `HACE ${diffInHours} HORAS`;
                                            
                                            return 'HACE 24 HORAS';
                                        },

                                        nextStory() {
                                            if (this.currentIndex < this.stories.length - 1) {
                                                this.currentIndex++;
                                                this.resetProgress();
                                            } else {
                                                this.closeStories();
                                            }
                                        },

                                        prevStory() {
                                            if (this.currentIndex > 0) {
                                                this.currentIndex--;
                                                this.resetProgress();
                                            }
                                        },

                                        startProgress() {
                                            this.progress = 0;
                                            this.interval = setInterval(() => {
                                                this.progress += 2;
                                                if (this.progress >= 100) {
                                                    this.nextStory();
                                                }
                                            }, 100);
                                        },

                                        stopProgress() {
                                            if (this.interval) {
                                                clearInterval(this.interval);
                                                this.interval = null;
                                            }
                                        },

                                        resetProgress() {
                                            this.stopProgress();
                                            this.startProgress();
                                        },

                                        getMediaUrl(path) {
                                            if (path.startsWith('http')) return path;
                                            return '{{ Storage::url('') }}' + path;
                                        }
                                    }" @open-story-viewer.window="openStories()" @keydown.escape.window="closeStories()"
                x-show="showStories" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0" class="fixed inset-0 z-50 flex items-center justify-center bg-black"
                style="display: none;">

                <!-- Navigation Arrows -->
                <button @click.stop="prevStory()"
                    class="hidden md:block absolute left-8 top-1/2 -translate-y-1/2 z-[130] text-red-600 hover:text-red-500 transition-all hover:scale-110 p-4 rounded-full bg-black/20 backdrop-blur-sm">
                    <svg class="w-12 h-12 drop-shadow-lg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <button @click.stop="nextStory()"
                    class="hidden md:block absolute right-8 top-1/2 -translate-y-1/2 z-[130] text-red-600 hover:text-red-500 transition-all hover:scale-110 p-4 rounded-full bg-black/20 backdrop-blur-sm">
                    <svg class="w-12 h-12 drop-shadow-lg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>

                <!-- Close Button -->
                <button @click="closeStories()"
                    class="absolute top-4 right-4 z-[120] text-white hover:text-red-600 transition-colors p-2 bg-black/20 rounded-full backdrop-blur-sm">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <!-- Mobile-style Story Card -->
                <div
                    class="relative w-full h-full max-w-[450px] max-h-[90vh] mx-auto flex flex-col items-center justify-center p-0 md:p-4">

                    <div
                        class="relative w-full h-full bg-zinc-900 md:rounded-2xl overflow-hidden shadow-2xl border border-gray-800 flex flex-col justify-center">

                        <!-- Progress Bars -->
                        <div class="absolute top-0 left-0 right-0 z-[110] px-2 pt-2 pointer-events-none">
                            <div class="flex gap-1.5 h-1.5 w-full">
                                <template x-for="(story, index) in stories" :key="index">
                                    <div class="h-full flex-1 rounded-full overflow-hidden shadow-sm"
                                        style="background-color: rgba(255, 255, 255, 0.35); backdrop-filter: blur(4px);">
                                        <div class="h-full transition-all duration-100 ease-linear shadow-[0_0_10px_rgba(236,72,153,1)]"
                                            :style="`width: ${index < currentIndex ? 100 : (index === currentIndex ? progress : 0)}%; background-color: #ec4899 !important;`">
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <!-- Header Info -->
                        <div
                            class="absolute top-4 left-0 right-0 z-[100] p-4 pt-6 bg-gradient-to-b from-black/60 to-transparent pointer-events-none">
                            <div class="flex items-center gap-3 pointer-events-auto">
                                <div
                                    class="w-10 h-10 rounded-full p-0.5 border-2 border-red-600 overflow-hidden bg-black shadow-md">
                                    <img src="{{ $escort->profile_photo ? Storage::url($escort->profile_photo) : 'https://ui-avatars.com/api/?name=' . $escort->name . '&color=ec4899&background=fdf2f8' }}"
                                        class="w-full h-full object-cover rounded-full">
                                </div>
                                <div class="flex flex-col text-left">
                                    <h3 class="text-white text-sm font-bold shadow-black drop-shadow-md">{{ $escort->name }}
                                    </h3>
                                    <div class="flex items-center gap-2">
                                        <span
                                            class="text-white/90 text-xs shadow-black drop-shadow-md font-medium">{{ $escort->city }}</span>
                                        <span class="text-[10px] text-white/60">•</span>
                                        <span
                                            class="text-red-500 text-xs font-bold shadow-black drop-shadow-md uppercase" x-text="getTimeAgo(stories[currentIndex]?.created_at)"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Media Content -->
                        <div class="relative w-full h-full flex items-center justify-center bg-black">
                            <template x-for="(story, index) in stories" :key="index">
                                <div x-show="currentIndex === index"
                                    class="absolute inset-0 flex items-center justify-center w-full h-full">

                                    <!-- Image -->
                                    <template x-if="story.media_type === 'image'">
                                        <img :src="getMediaUrl(story.media_path[0])" class="w-full h-full object-cover"
                                            :alt="story.caption || 'Story'">
                                    </template>

                                    <!-- Video -->
                                    <template x-if="story.media_type === 'video'">
                                        <video :src="getMediaUrl(story.media_path[0])" class="w-full h-full object-cover"
                                            autoplay @ended="nextStory()">
                                        </video>
                                    </template>

                                    <!-- Watermark -->
                                     <div
                                         class="absolute inset-0 flex items-center justify-center pointer-events-none opacity-30 z-10 select-none">
                                         <span class="text-2xl md:text-3xl font-extrabold tracking-wider drop-shadow-lg uppercase"><span class="text-red-600">CITAS</span><span class="text-white">ESCORTS</span></span>
                                     </div>

                                    <!-- Caption Badge -->
                                    <div x-show="story.caption"
                                        class="absolute bottom-8 left-0 right-0 p-4 flex justify-center z-40">
                                        <div class="backdrop-blur-md px-6 py-3 rounded-xl shadow-lg border border-white/20 hover:scale-105 transition-transform max-w-[90%]"
                                            style="background-color: #ec4899 !important;">
                                            <span
                                                class="text-white font-bold text-xs uppercase tracking-wide text-center block whitespace-normal break-words leading-tight"
                                                x-text="story.caption"></span>
                                        </div>
                                    </div>

                                </div>
                            </template>
                        </div>

                    </div>
                </div>

                <!-- Navigation Areas -->
                <div class="absolute inset-0 flex">
                    <!-- Left half - Previous -->
                    <div @click="prevStory()" class="flex-1 cursor-pointer"></div>
                    <!-- Right half - Next -->
                    <div @click="nextStory()" class="flex-1 cursor-pointer"></div>
                </div>
        @endif
</x-main-layout>
