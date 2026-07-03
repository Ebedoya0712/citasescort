@props(['escort'])

@php
    $hasVideo = !empty($escort->video);
    $photoCount = 0;
    if (!empty($escort->photos)) {
        foreach ($escort->photos as $file) {
            $ext = pathinfo($file, PATHINFO_EXTENSION);
            if (in_array(strtolower($ext), ['mp4', 'mov', 'avi', 'webm'])) {
                $hasVideo = true;
            } else {
                $photoCount++;
            }
        }
    }
@endphp

<a href="{{ route('profile.show', $escort->id) }}"
    class="bg-white dark:bg-zinc-900 rounded-2xl overflow-hidden shadow-lg group cursor-pointer transition-all duration-300 hover:-translate-y-1 block hover:ring-2 hover:ring-red-600">
    <!-- Image Area -->
    <div class="relative aspect-[4/5] overflow-hidden bg-gray-200 dark:bg-zinc-800">
        @if(!empty($escort->photos) && isset($escort->photos[0]))
            @php
                $photo = $escort->photos[0];
                $src = Str::startsWith($photo, ['http://', 'https://']) ? $photo : Storage::url($photo);
            @endphp
            <img src="{{ $src }}" alt="{{ $escort->name }}"
                class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">

            <!-- Watermark -->
            <div class="absolute inset-0 flex items-center justify-center pointer-events-none opacity-30 z-0 select-none">
                <span class="text-xl font-extrabold tracking-wider drop-shadow-lg uppercase"><span class="text-red-600">CITAS</span><span class="text-white">ESCORTS</span></span>
            </div>
        @else
            <div class="w-full h-full flex items-center justify-center text-gray-400">
                <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                    </path>
                </svg>
            </div>
        @endif

        <!-- Badges Overlay -->
        <div class="absolute top-3 left-3 flex flex-col gap-2">
            @if($escort->level === 'diamond')
                <span
                    class="bg-red-600 text-white text-xs font-bold px-2.5 py-1 rounded uppercase tracking-wider shadow-sm">Diamante</span>
            @elseif($escort->level === 'silver')
                <span
                    class="bg-gray-400 text-white text-xs font-bold px-2.5 py-1 rounded uppercase tracking-wider shadow-sm">Plata</span>
            @endif

            @if($escort->verified)
                <div class="relative w-8 h-8 flex items-center justify-center filter drop-shadow-md select-none mt-1">
                    <svg class="w-full h-full text-red-600 fill-current" viewBox="0 0 24 24">
                        <path d="M12 2l2.4 1.8 2.9-.6.8 2.9 2.7.9-.9 2.8 1.8 2.4-1.8 2.4.9 2.8-2.7.9-.8 2.9-2.9-.6L12 22l-2.4-1.8-2.9.6-.8-2.9-2.7-.9.9-2.8-1.8-2.4 1.8-2.4-.9-2.8 2.7-.9.8-2.9 2.9.6L12 2z"/>
                    </svg>
                    <svg class="absolute w-3.5 h-3.5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="stroke-width: 4;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
            @endif
        </div>

        <div class="absolute top-3 right-3 flex flex-col items-end gap-2 z-10">
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
                }" @click.prevent.stop="toggleLike()"
                class="w-8 h-8 rounded-full bg-black/40 backdrop-blur-md flex items-center justify-center hover:bg-black/60 transition-colors border border-white/10 shadow-sm group/btn">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 transition-all duration-300"
                    :class="liked ? 'text-brand-pink fill-current scale-110' : 'text-white group-hover/btn:text-brand-pink'"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                </svg>
            </button>

            <span
                class="bg-black/60 backdrop-blur-md text-white text-xs font-bold px-2.5 py-1 rounded tracking-tighter border border-white/10 shadow-sm">{{ number_format($escort->price, 0) }}
                {{ $escort->currency ?? 'UYU' }}</span>

            @if($photoCount > 0)
                <span class="bg-black/60 backdrop-blur-md text-white text-[11px] font-bold px-2 py-1 rounded border border-white/10 shadow-sm flex items-center gap-1 select-none">
                    <svg class="w-3.5 h-3.5 text-white fill-current" viewBox="0 0 24 24">
                        <path d="M4 4h3l2-2h6l2 2h3a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2zm8 3a5 5 0 1 0 0 10 5 5 0 0 0 0-10zm0 2a3 3 0 1 1 0 6 3 3 0 0 1 0-6z"/>
                    </svg>
                    {{ $photoCount }}
                </span>
            @endif
        </div>

        <!-- Availability Bar Overlay -->
        <div
            class="absolute bottom-3 left-3 right-3 bg-black/60 backdrop-blur-sm rounded-full py-2 px-3 flex items-center gap-2 border border-white/5 shadow-sm">
            <div class="w-2.5 h-2.5 rounded-full bg-green-500 animate-pulse"></div>
            <span class="text-emerald-400 text-xs font-semibold truncate">Disponible</span>
            @if(!empty($escort->attends_in))
                <span class="text-gray-400 text-xs mx-1">|</span>
                <span class="text-white text-xs font-semibold truncate">{{ implode(', ', $escort->attends_in) }}</span>
            @endif
        </div>

        @if($hasVideo)
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 flex items-center justify-center pointer-events-none z-10">
                <div class="relative w-12 h-12 flex items-center justify-center rounded-full bg-red-600 shadow-lg shadow-red-600/50">
                    <div class="absolute inset-0 rounded-full bg-red-600 animate-ping opacity-75"></div>
                    <svg class="relative w-5 h-5 text-white fill-current ml-0.5" viewBox="0 0 24 24">
                        <path d="M8 5v14l11-7z"/>
                    </svg>
                </div>
            </div>
        @endif
    </div>

    <!-- Info Area -->
    <div
        class="p-4 bg-white dark:bg-zinc-900 border-t border-gray-100 dark:border-zinc-800 flex justify-between items-start transition-colors duration-300">
        <div class="space-y-0.5 max-w-[70%]">
            <h4 class="text-brand-pink font-bold text-sm truncate">{{ $escort->name }}</h4>
            <div class="flex items-center gap-1.5 text-black dark:text-gray-100 font-bold text-xs">
                <!-- Gender Icon -->
                @if($escort->gender === 'Mujer' || $escort->gender === 'female')
                    <span class="text-pink-500" title="Mujer">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 15a6 6 0 1 0 0-12 6 6 0 0 0 0 12Z" />
                            <path d="M12 15v7" />
                            <path d="M9 19h6" />
                        </svg>
                    </span>
                @elseif($escort->gender === 'Hombre' || $escort->gender === 'male')
                    <span class="text-blue-500" title="Hombre">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M16 3h5v5" />
                            <path d="M21 3 13.5 10.5" />
                            <path d="M19 16a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                        </svg>
                    </span>
                @elseif($escort->gender === 'Trans' || $escort->gender === 'trans')
                    <span class="text-purple-500" title="Trans">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 16v6" />
                            <path d="M14 20h-4" />
                            <path d="M18.364 5.636a9 9 0 1 1-12.728 0" />
                            <path d="M12 2v6" />
                            <path d="M9.5 5h5" />
                            <path d="M5 8.5 8.5 5" />
                            <path d="M15.5 5 19 8.5" />
                        </svg>
                    </span>
                @endif

                <span>{{ $escort->age ?? '' }} años</span>
                <span class="w-1 h-1 rounded-full bg-gray-300 dark:bg-gray-600"></span>
                <span class="truncate">{{ $escort->city ?? '' }}</span>
            </div>
        </div>
        @php
            $reviewCount = $escort->reviews->count();
            $averageRating = $reviewCount > 0 ? round($escort->reviews->avg('rating'), 1) : 0;
        @endphp
        <div class="flex items-center gap-1 text-brand-pink shrink-0">
            <span class="text-xs font-bold">{{ $averageRating }}</span>
            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="currentColor"
                stroke="none">
                <polygon
                    points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
            </svg>
            <span class="text-xs text-gray-500 dark:text-gray-400">({{ $reviewCount }})</span>
        </div>
    </div>
</a>