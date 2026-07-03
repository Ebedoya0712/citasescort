<x-main-layout>

    @php
        $color = '#e11d48'; 
            
        $rawBanner = $establishment->banner_image ?: $establishment->cover_image;
        $rawBanner = str_replace('\\', '/', $rawBanner);
        $bgImage = $rawBanner 
            ? (Str::startsWith($rawBanner, ['http://', 'https://', 'http', 'https']) ? $rawBanner : asset('storage/' . $rawBanner)) 
            : 'https://images.unsplash.com/photo-1566737236500-c8ac43014a67?q=80&w=2000&auto=format&fit=crop';
    @endphp

    <div class="min-h-screen relative pb-20 font-sans transition-colors duration-300 bg-black">

        <!-- Full Screen Background Image (Cinematic) -->
        <img src="{{ $bgImage }}" alt="Background" class="fixed inset-0 w-full h-full object-cover z-0 opacity-60 pointer-events-none">

        <!-- Header section (Avatar & Title) -->
        <div class="relative z-10 w-full pt-20 pb-12">

            <div class="flex flex-col items-center">
                <div class="relative flex flex-col items-center">
                    <!-- Circular Avatar -->
                    <div
                        class="w-40 h-40 md:w-56 md:h-56 rounded-full overflow-hidden border-2 border-[#e11d48]/50 dark:border-white/10 mb-[-24px] relative z-10 bg-black shadow-2xl">
                        <img src="{{ $establishment->cover_image ? (Str::startsWith($establishment->cover_image, ['http://', 'https://']) ? $establishment->cover_image : asset('storage/' . $establishment->cover_image)) : 'https://via.placeholder.com/400x400/111111/f76c95?text=Logo' }}" alt="{{ $establishment->name }}"
                            class="w-full h-full object-cover bg-white dark:bg-[#18181b]">
                    </div>

                    <!-- Pill title -->
                    <div class="px-8 py-2 md:py-3 rounded-[30px] text-lg md:text-2xl font-black uppercase tracking-wider text-white z-20 shadow-[0_0_25px_rgba(225,29,72,0.5)] border border-white/20 backdrop-blur-md transition-all duration-300 hover:scale-105"
                        style="background: linear-gradient(135deg, rgba(225,29,72,0.9), rgba(159,18,57,0.9)); letter-spacing: 0.1em;">
                        {{ $establishment->name }}
                    </div>

                    <!-- Subtitle (Address) -->
                    <div class="mt-4 text-center">
                        <p class="text-gray-700 dark:text-white/80 text-sm md:text-base uppercase font-bold tracking-widest">
                            {{ $establishment->address }}
                        </p>
                    </div>
                </div>

                <!-- Divider line -->
                <div class="w-full max-w-4xl mx-auto h-px bg-gray-300 dark:bg-white/5 mt-10"></div>
            </div>

        </div>

        <div class="relative z-10 max-w-5xl mx-auto px-4">

            <!-- Main Content Split Layout -->
            <div class="flex flex-col lg:flex-row gap-8 mb-12">

                <!-- Left Column: Gallery -->
                <div class="w-full lg:w-2/3">
                    @if(is_array($establishment->gallery) && count($establishment->gallery) > 0)
                    <div x-data="{ 
                        images: [
                            @if(is_array($establishment->gallery) && count($establishment->gallery) > 0)
                                @foreach($establishment->gallery as $image)
                                    '{{ asset("storage/" . $image) }}',
                                @endforeach
                            @endif
                        ],
                        active: 0,
                        lightboxOpen: false,
                        openLightbox(index) {
                            this.active = index;
                            this.lightboxOpen = true;
                            document.body.style.overflow = 'hidden';
                        },
                        closeLightbox() {
                            this.lightboxOpen = false;
                            document.body.style.overflow = '';
                        },
                        init() {
                            setInterval(() => {
                                if (!this.lightboxOpen && this.images.length > 1) {
                                    this.active = (this.active + 1) % this.images.length;
                                }
                            }, 3500);
                        }
                    }" class="bg-white dark:bg-[#111] p-0.5 rounded shadow-xl">
                        <!-- Gallery Carousel -->
                        <div class="relative w-full h-[250px] md:h-[450px] overflow-hidden bg-black group rounded">
                            <template x-for="(image, index) in images" :key="index">
                                <img :src="image" 
                                     @click="openLightbox(index)"
                                     x-show="active === index"
                                     x-transition:enter="transition-opacity ease-linear duration-500"
                                     x-transition:enter-start="opacity-0"
                                     x-transition:enter-end="opacity-100"
                                     x-transition:leave="transition-opacity ease-linear duration-500"
                                     x-transition:leave-start="opacity-100"
                                     x-transition:leave-end="opacity-0"
                                     class="absolute inset-0 w-full h-full object-cover cursor-pointer hover:scale-105 transition-transform duration-500">
                            </template>
                        </div>

                        <!-- Lightbox Modal -->
                        <template x-teleport="body">
                            <div x-show="lightboxOpen" 
                                 class="fixed inset-0 z-[100] flex items-center justify-center bg-black/95 backdrop-blur-md"
                                 x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0"
                                 x-transition:enter-end="opacity-100"
                                 x-transition:leave="transition ease-in duration-200"
                                 x-transition:leave-start="opacity-100"
                                 x-transition:leave-end="opacity-0"
                                 style="display: none;">
                                
                                <!-- Close button -->
                                <button @click="closeLightbox()" class="absolute top-4 right-4 text-white/70 hover:text-white z-[110] transition-colors p-2 focus:outline-none">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>

                                <!-- Navigation buttons -->
                                <button x-show="images.length > 1" @click.stop="active = (active === 0) ? images.length - 1 : active - 1" class="absolute left-4 top-1/2 transform -translate-y-1/2 text-white/50 hover:text-white z-[110] transition-colors p-2 focus:outline-none">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                                </button>
                                
                                <button x-show="images.length > 1" @click.stop="active = (active + 1) % images.length" class="absolute right-4 top-1/2 transform -translate-y-1/2 text-white/50 hover:text-white z-[110] transition-colors p-2 focus:outline-none">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </button>

                                <!-- Image -->
                                <div class="relative max-w-[90vw] max-h-[90vh]">
                                    <img :src="images[active]" @click.stop class="max-w-full max-h-[90vh] object-contain shadow-2xl rounded">
                                </div>
                            </div>
                        </template>

                        <!-- Dots -->
                        <div class="flex justify-center gap-3 py-6">
                            <template x-for="(image, index) in images" :key="index">
                                <button @click="active = index" 
                                        :class="{'bg-[#e11d48] shadow-[0_0_10px_#e11d48] scale-125': active === index, 'bg-[#e11d48]/30 hover:bg-[#e11d48]/60': active !== index}"
                                        class="w-3 h-3 rounded-full transition-all duration-300 focus:outline-none"></button>
                            </template>
                        </div>
                    </div>
                    @endif

                    <!-- Description Text -->
                    <div class="mt-8 mb-12">
                        <div class="prose prose-invert max-w-none">
                            <p class="text-gray-600 dark:text-white/60 leading-relaxed text-[15px] md:text-base">
                                {!! nl2br(e($establishment->description ?? 'Este establecimiento no cuenta con una descripción detallada en este momento. Sin embargo, te invitamos a visitarnos para conocer nuestras excelentes instalaciones.')) !!}
                            </p>
                        </div>
                    </div>

                </div>

                <!-- Right Column: Info Card -->
                <div class="w-full lg:w-1/3">
                    <div class="bg-white dark:bg-[#131313] p-6 rounded shadow-xl border border-gray-200 dark:border-white/5">
                        <h4 class="text-gray-900 dark:text-white text-xl font-bold mb-4 uppercase tracking-wider">DATOS</h4>
                        <div class="w-full h-px bg-gray-200 dark:bg-white/10 mb-6"></div>

                        <div class="space-y-6">
                            <!-- Field: Address -->
                            <div class="flex justify-between items-start text-sm md:text-[15px]">
                                <span class="text-gray-500 dark:text-white/60">Dirección</span>
                                <span class="text-right text-gray-900 dark:text-white max-w-[150px]">{{ $establishment->address }}</span>
                            </div>

                            <!-- Field: Phone -->
                            <div class="flex justify-between items-start text-sm md:text-[15px]">
                                <span class="text-gray-500 dark:text-white/60">Teléfono</span>
                                @if($establishment->phone)
                                    <span class="text-right text-gray-900 dark:text-white font-medium">{{ $establishment->phone }}</span>
                                @else
                                    <span class="text-right text-gray-400 dark:text-white/40 italic">No disponible</span>
                                @endif
                            </div>
                        </div>

                        @if($establishment->phone || $establishment->whatsapp || $establishment->website)
                            <div class="mt-8 flex flex-col gap-3">
                                @if($establishment->phone)
                                    <a href="tel:{{ $establishment->phone }}"
                                        class="w-full py-3 px-4 rounded font-bold text-center text-white transition-transform hover:scale-105 active:scale-95 shadow-[0_0_15px_rgba(247,108,149,0.3)]"
                                        style="background-color: {{ $color }};">
                                        LLAMAR AHORA
                                    </a>
                                @endif
                                @if($establishment->whatsapp)
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $establishment->whatsapp) }}"
                                        target="_blank"
                                        class="bg-[#25D366] w-full py-3 px-4 rounded font-bold text-center text-white transition-transform hover:scale-105 active:scale-95 flex items-center justify-center gap-2 shadow-[0_0_15px_rgba(37,211,102,0.3)]">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                            fill="currentColor">
                                            <path
                                                d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.89-4.443 9.893-9.892.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.738-.974zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.347-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z" />
                                        </svg>
                                        WHATSAPP
                                    </a>
                                @endif
                            </div>
                        @endif
                    </div>

                    @if(is_array($establishment->schedule) && count($establishment->schedule) > 0)
                        <div class="bg-white dark:bg-[#131313] p-6 rounded shadow-xl border border-gray-200 dark:border-white/5 mt-8">
                            <h4 class="text-gray-900 dark:text-white text-xl font-bold mb-4 uppercase tracking-wider">HORARIOS</h4>
                            <div class="w-full h-px bg-gray-200 dark:bg-white/10 mb-6"></div>
                            <div class="space-y-4">
                                @foreach($establishment->schedule as $sch)
                                    <div class="flex justify-between items-center text-sm md:text-[15px]">
                                        <span class="text-gray-500 dark:text-white/60">{{ $sch['day'] ?? '' }}</span>
                                        <span class="text-gray-900 dark:text-white font-medium">
                                            {{ \Carbon\Carbon::parse($sch['open'])->format('H:i') }} a {{ \Carbon\Carbon::parse($sch['close'])->format('H:i') }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div> <!-- Closes Right Column -->

            </div> <!-- Closes Flex Row -->

            <!-- REVIEWS SECTION (Full Width) -->
            <div class="mt-8">
                <div class="bg-white dark:bg-[#131313] p-6 md:p-10 rounded shadow-xl border border-gray-200 dark:border-white/5">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white uppercase tracking-wider mb-8 text-center md:text-left">
                        <span style="color: {{ $color }}">★</span> Reseñas y Comentarios
                    </h3>
                    
                    <!-- Display existing reviews -->
                    <div class="space-y-6 mb-12">
                        @forelse($establishment->reviews->where('is_public', true) as $review)
                            <div class="border-b border-gray-200 dark:border-white/10 pb-6 last:border-0 last:pb-0">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="font-bold text-gray-900 dark:text-white">{{ $review->user ? $review->user->name : ($review->name ?: 'Anónimo') }}</span>
                                    <span class="text-[#FFD700] tracking-widest text-lg">
                                        {{ str_repeat('★', $review->rating) }}{{ str_repeat('☆', 5 - $review->rating) }}
                                    </span>
                                </div>
                                <p class="text-gray-700 dark:text-white/70 text-sm md:text-base leading-relaxed">{{ $review->content }}</p>
                                <span class="text-xs text-gray-400 dark:text-white/40 mt-2 block">{{ $review->created_at->diffForHumans() }}</span>
                            </div>
                        @empty
                            <div class="text-center py-8 text-gray-400 dark:text-white/40 italic">
                                Aún no hay reseñas para este establecimiento. ¡Sé el primero en opinar!
                            </div>
                        @endforelse
                    </div>

                    <!-- Review form -->
                    @auth
                        @if (session('success'))
                            <div class="mb-6 bg-green-500/20 border border-green-500/50 text-green-300 p-4 rounded-lg flex items-center gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                <span>{{ session('success') }}</span>
                                <button onclick="this.parentElement.remove()" class="ml-auto text-green-400 hover:text-green-200">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </div>
                        @endif
                        @if ($errors->any())
                            <div class="mb-6 bg-red-500/20 border border-red-500/50 text-red-300 p-4 rounded-lg">
                                <ul class="list-disc list-inside">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="bg-gray-50 dark:bg-black/40 p-6 rounded border border-gray-200 dark:border-white/5 mt-8">
                            <h4 class="text-gray-900 dark:text-white font-bold mb-4">Deja tu reseña</h4>
                            <form action="{{ route('establishment.reviews.store', $establishment->id) }}" method="POST">
                                @csrf
                                <div x-data="{ rating: 5, hoverRating: 0 }" class="mb-6">
                                    <label class="block text-gray-600 dark:text-white/60 text-sm mb-3">Calificación (Estrellas)</label>
                                    <div class="flex gap-2">
                                        <template x-for="i in 5">
                                            <button type="button" 
                                                    @click="rating = i"
                                                    @mouseenter="hoverRating = i"
                                                    @mouseleave="hoverRating = 0"
                                                    class="focus:outline-none transition-transform hover:scale-110">
                                                <svg :class="{'text-[#e11d48] scale-110 drop-shadow-[0_0_8px_rgba(225,29,72,0.5)]': i <= (hoverRating || rating), 'text-white/20': i > (hoverRating || rating)}"
                                                     class="w-6 h-6 md:w-8 md:h-8 transition-all duration-200"
                                                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                                    <path d="M12 17.27l5.18 3.73-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                                                </svg>
                                            </button>
                                        </template>
                                    </div>
                                    <input type="hidden" name="rating" :value="rating" required>
                                </div>
                                <div class="mb-6">
                                    <label class="block text-gray-600 dark:text-white/60 text-sm mb-2">Tu Comentario</label>
                                    <textarea name="content" required rows="4" class="w-full bg-white dark:bg-[#111] border border-gray-300 dark:border-white/10 text-gray-900 dark:text-white rounded p-3 focus:outline-none focus:border-[#e11d48]" placeholder="Cuéntanos tu experiencia..."></textarea>
                                </div>
                                <button type="submit" class="w-full py-3 px-4 rounded font-bold text-center text-white transition-transform hover:scale-105 shadow-[0_0_15px_rgba(225,29,72,0.3)]" style="background-color: {{ $color }};">
                                    ENVIAR RESEÑA
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="bg-red-600/5 dark:bg-[#e11d48]/10 border border-[#e11d48]/20 p-6 rounded text-center mt-8">
                            <p class="text-gray-700 dark:text-white/80 mb-4">Para dejar una reseña debes iniciar sesión o registrarte.</p>
                            <a href="{{ route('login') }}" class="inline-block py-2 px-6 rounded font-bold text-white transition-transform hover:scale-105 shadow-[0_0_15px_rgba(225,29,72,0.3)]" style="background-color: {{ $color }};">
                                Iniciar Sesión
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
        </div> <!-- Closes max-w-5xl -->
    </div> <!-- Closes main page bg wrapper -->
</x-main-layout>