<section class="bg-white dark:bg-black py-16 px-4 lg:px-8 transition-colors duration-300">
    <div class="max-w-7xl mx-auto">
        <!-- Section Header -->
        <div class="flex items-center justify-between mb-10">
            <div class="flex items-center gap-3">
                <h2 class="text-brand-pink text-2xl font-bold italic">Escorts Diamante</h2>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="text-brand-pink" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 3h12l4 6-10 13L2 9Z"/><path d="M11 3 8 9l4 13 4-13-3-6"/><path d="M2 9h20"/></svg>
            </div>
            
            <div class="flex items-center gap-4">
                <span class="text-gray-600 dark:text-gray-400 text-xs">710 escorts</span>
                <button class="bg-brand-pink p-2 rounded text-white hover:opacity-90">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                </button>
            </div>
        </div>

        <!-- Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            @for ($i = 0; $i < 8; $i++)
                <x-escort-card />
            @endfor
        </div>
    </div>
</section>
