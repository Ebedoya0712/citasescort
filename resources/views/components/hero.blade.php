<section class="relative h-[480px] sm:h-[550px] md:h-[650px] flex items-center justify-center overflow-hidden hero-video">
    <!-- Video Background -->
    <video 
        autoplay 
        muted 
        loop 
        playsinline 
        class="absolute z-0 min-w-full min-h-full object-cover"
    >
        <source src="{{ asset('images/banner-video.mp4') }}" type="video/mp4">
        Your browser does not support the video tag.
    </video>

    <!-- Dark Overlay with Gradient -->
    <div class="absolute inset-0 bg-gradient-to-b from-black/80 via-black/55 to-black/80 z-10 hero-overlay"></div>

    <!-- Content Overlay -->
    <div class="relative z-20 max-w-7xl mx-auto px-4 lg:px-8 text-white w-full hero-content flex flex-col justify-center h-full pt-10">
        <!-- Main Heading Area -->
        <div class="text-center mb-12">
            <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-red-600/10 border border-red-600/30 text-red-600 font-bold text-xs uppercase tracking-widest mb-6 backdrop-blur-md shadow-lg shadow-red-600/5 select-none animate-[pulse_2s_infinite]">
                <span class="w-2 h-2 rounded-full bg-red-600"></span>
                Escorts Perú
            </span>
            <h1 class="text-4xl md:text-6xl font-black tracking-tight drop-shadow-xl text-white">
                Perfiles <span class="bg-gradient-to-r from-red-600 via-red-400 to-red-600 bg-clip-text text-transparent">manualmente verificados</span>
            </h1>
            <p class="text-gray-300 text-sm md:text-base mt-4 max-w-xl mx-auto font-medium">
                La guía más confiable y discreta para tus encuentros.
            </p>
        </div>

    </div>
</section>
