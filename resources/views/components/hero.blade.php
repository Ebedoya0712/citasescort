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
            <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-brand-pink/10 border border-brand-pink/30 text-brand-pink font-bold text-xs uppercase tracking-widest mb-6 backdrop-blur-md shadow-lg shadow-brand-pink/5 select-none animate-[pulse_2s_infinite]">
                <span class="w-2 h-2 rounded-full bg-brand-pink"></span>
                Escorts Perú
            </span>
            <h1 class="text-4xl md:text-6xl font-black tracking-tight drop-shadow-xl text-white">
                Perfiles <span class="bg-gradient-to-r from-brand-pink via-red-400 to-rose-500 bg-clip-text text-transparent">manualmente verificados</span>
            </h1>
            <p class="text-gray-300 text-sm md:text-base mt-4 max-w-xl mx-auto font-medium">
                La guía más confiable y discreta para tus encuentros.
            </p>
        </div>

        <!-- 3-Column Features (Glassmorphic Cards) -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8 max-w-6xl mx-auto w-full">
            <!-- Feature 1 -->
            <div class="flex flex-col items-center md:items-start p-6 bg-black/45 backdrop-blur-md rounded-2xl border border-white/5 hover:border-brand-pink/30 hover:bg-black/60 transition-all duration-300 group hover:-translate-y-1 hover:shadow-xl hover:shadow-brand-pink/5">
                <div class="mb-4 p-3 bg-brand-pink/10 rounded-2xl border border-brand-pink/20 text-brand-pink group-hover:scale-110 transition-transform duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/><path d="m16 19 2 2 4-4"/></svg>
                </div>
                <h4 class="text-lg font-bold mb-2 text-white">Perfiles auténticos</h4>
                <p class="text-gray-400 text-xs md:text-sm leading-relaxed text-center md:text-left">
                    No permitimos fotos falsas. En el raro caso de que pase, cuando lo notamos, rápidamente damos de baja el perfil.
                </p>
            </div>

            <!-- Feature 2 -->
            <div class="flex flex-col items-center md:items-start p-6 bg-black/45 backdrop-blur-md rounded-2xl border border-white/5 hover:border-brand-pink/30 hover:bg-black/60 transition-all duration-300 group hover:-translate-y-1 hover:shadow-xl hover:shadow-brand-pink/5">
                <div class="mb-4 p-3 bg-brand-pink/10 rounded-2xl border border-brand-pink/20 text-brand-pink group-hover:scale-110 transition-transform duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/><path d="M8 9h8"/><path d="M8 13h6"/></svg>
                </div>
                <h4 class="text-lg font-bold mb-2 text-white">Experiencias y comunidad</h4>
                <p class="text-gray-400 text-xs md:text-sm leading-relaxed text-center md:text-left">
                    Leé de otros y dejá tus comentarios. Te escuchamos y si hubo un problema serio, suspendemos el perfil.
                </p>
            </div>

            <!-- Feature 3 -->
            <div class="flex flex-col items-center md:items-start p-6 bg-black/45 backdrop-blur-md rounded-2xl border border-white/5 hover:border-brand-pink/30 hover:bg-black/60 transition-all duration-300 group hover:-translate-y-1 hover:shadow-xl hover:shadow-brand-pink/5">
                <div class="mb-4 p-3 bg-brand-pink/10 rounded-2xl border border-brand-pink/20 text-brand-pink group-hover:scale-110 transition-transform duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09z"/><path d="m12 15-3-3a22 22 0 0 1 2-3.95A12.88 12.88 0 0 1 22 2c0 2.72-.78 7.5-6 11a22.35 22.35 0 0 1-4 2z"/><path d="M9 12H4s.55-3.03 2-4c1.62-1.08 5 0 5 0"/><path d="M12 15v5s3.03-.55 4-2c1.08-1.62 0-5 0-5"/></svg>
                </div>
                <h4 class="text-lg font-bold mb-2 text-white">Mejoramos continuamente</h4>
                <p class="text-gray-400 text-xs md:text-sm leading-relaxed text-center md:text-left">
                    Cada día, Citasescort mejora. Mantenemos el sitio limpio y lo mejoramos todas las semanas.
                </p>
            </div>
        </div>
    </div>
</section>
