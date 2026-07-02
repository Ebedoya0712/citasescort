@props(['title', 'escorts', 'id' => 'carousel-' . uniqid()])

<section class="py-12 px-4 lg:px-8 max-w-7xl mx-auto" x-data="{
    current: 0,
    total: {{ $escorts->count() }},
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
        <h2 class="text-brand-pink text-2xl font-bold italic flex items-center gap-2">
            {{ $title }}
            @if(str_contains(strtolower($title), 'diamante'))
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7" /></svg>
            @endif
        </h2>
        
        <div class="flex items-center gap-4">
            <span class="text-gray-500 text-xs hidden sm:block">{{ $escorts->count() }} escorts</span>
            <div class="flex gap-2">
                <button @click="prev()" class="p-2 rounded-full bg-gray-100 dark:bg-zinc-800 hover:bg-brand-pink hover:text-white transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </button>
                <button @click="next()" class="p-2 rounded-full bg-gray-100 dark:bg-zinc-800 hover:bg-brand-pink hover:text-white transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Carousel Track -->
    <div class="overflow-hidden relative">
        <div class="flex transition-transform duration-500 ease-out"
             :style="'transform: translateX(-' + (current * (100 / perView)) + '%)'">
            
            @foreach($escorts as $escort)
                <div class="flex-shrink-0 px-2" :style="'width: ' + (100 / perView) + '%'">
                    <x-escort-card :escort="$escort" />
                </div>
            @endforeach
            
            @if($escorts->isEmpty())
                <div class="w-full text-center py-10 text-gray-500">
                    No hay escorts disponibles en esta categoría por el momento.
                </div>
            @endif
        </div>
    </div>
</section>
