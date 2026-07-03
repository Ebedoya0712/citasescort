<x-main-layout>
    <x-slot:title>
        Citasescort - Escorts en Perú
        </x-slot>

        <x-hero />
        <x-stories />

        <!-- Filters moved to sidebar -->

        <div class="space-y-4">
            <x-publication-carousel title="Escorts Diamante 💎" :publications="$diamondPublications" />
            <x-publication-carousel title="Escorts Plata 🥈" :publications="$silverPublications" />

            <!-- Standard Escorts Grid -->
            <section class="max-w-7xl mx-auto px-4 lg:px-8 py-12">
                <h2 class="text-red-600 text-2xl font-bold italic mb-8 flex items-center gap-2">
                    Escorts Generales 🌹
                </h2>
                <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 md:gap-8">
                    @foreach($generalPublications as $publication)
                        <x-publication-card :publication="$publication" />
                    @endforeach
                </div>
                @if($generalPublications->isEmpty())
                    <div class="w-full text-center py-10 text-gray-500">
                        No hay escorts disponibles en esta categoría.
                    </div>
                @endif
            </section>
        </div>

        <x-features />
        <x-faq />
        <x-pre-footer />
        <x-payment-logos />

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
         }" @scroll.window="updateScroll()" class="fixed bottom-4 right-4 md:bottom-8 md:right-8 z-50 transform transition-all duration-300"
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
</x-main-layout>