@props(['title', 'publications', 'id' => 'carousel-' . uniqid()])

<section class="py-4 px-4 lg:px-8 max-w-7xl mx-auto" x-data="{
    current: 0,
    total: {{ $publications->count() }},
    perView: 4,
    autoPlayInterval: null,
    
    init() {
        this.updatePerView();
        window.addEventListener('resize', () => this.updatePerView());
        this.startAutoPlay();
        
        // Pause on hover
        $el.addEventListener('mouseenter', () => this.stopAutoPlay());
        $el.addEventListener('mouseleave', () => this.startAutoPlay());
    },
    
    updatePerView() {
        if (window.innerWidth < 640) this.perView = 1;
        else if (window.innerWidth < 1024) this.perView = 2;
        else this.perView = 4;
    },
    
    next() {
        if (this.current >= this.total - this.perView) {
            this.current = 0;
        } else {
            this.current++;
        }
    },
    
    prev() {
        if (this.current <= 0) {
            this.current = this.total - this.perView;
            if (this.current < 0) this.current = 0;
        } else {
            this.current--;
        }
    },
    
    startAutoPlay() {
        this.autoPlayInterval = setInterval(() => {
            this.next();
        }, 3000);
    },
    
    stopAutoPlay() {
        if (this.autoPlayInterval) {
            clearInterval(this.autoPlayInterval);
            this.autoPlayInterval = null;
        }
    }
}">
    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <h2 class="text-red-600 text-2xl font-bold italic flex items-center gap-2">
            {{ $title }}
            @if(str_contains(strtolower($title), 'diamante'))
                <svg class="w-6 h-6 text-red-600" fill="currentColor" viewBox="0 0 24 24"><path d="M19 3H5L2 9l10 12L22 9l-3-6zM9.62 8L12 4.76 14.38 8H9.62z"/></svg>
            @elseif(str_contains(strtolower($title), 'plata'))
                <svg class="w-6 h-6 text-red-600" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-1-13h2v6h-2zm0 8h2v2h-2z"/></svg>
            @endif
        </h2>
        
        <div class="flex items-center gap-4">
            <span class="text-gray-500 text-xs hidden sm:block font-medium">{{ $publications->count() }} publicaciones</span>
            @php
                if (str_contains(strtolower($title), 'diamante')) {
                    $btnStyle = 'background-color: #FFD700; border-color: #FFD700; color: black;';
                } elseif (str_contains(strtolower($title), 'plata')) {
                    $btnStyle = 'background-color: #C0C0C0; border-color: #C0C0C0; color: black;';
                } else {
                    $btnStyle = 'background-color: #f3f4f6; color: #1f2937;'; // fallback
                }
            @endphp
            <div class="flex gap-2">
                <button @click="prev()" style="{{ $btnStyle }}" class="w-10 h-10 flex items-center justify-center rounded-full transition-all shadow-sm hover:opacity-80 hover:-translate-x-0.5 active:scale-95 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"></path></svg>
                </button>
                <button @click="next()" style="{{ $btnStyle }}" class="w-10 h-10 flex items-center justify-center rounded-full transition-all shadow-sm hover:opacity-80 hover:translate-x-0.5 active:scale-95 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path></svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Carousel Track -->
    <div class="overflow-hidden relative">
        <div class="flex transition-transform duration-500 ease-out"
             :style="'transform: translateX(-' + (current * (100 / perView)) + '%)'">
            
            @foreach($publications as $publication)
                <div class="flex-shrink-0 px-2" :style="'width: ' + (100 / perView) + '%'">
                    <x-publication-card :publication="$publication" />
                </div>
            @endforeach
            
            @if($publications->isEmpty())
                <div class="w-full text-center py-10 text-gray-500">
                    No hay publicaciones disponibles en esta categoría por el momento.
                </div>
            @endif
        </div>
    </div>
</section>
