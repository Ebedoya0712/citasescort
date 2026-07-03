<x-main-layout>
    <!-- Header/Filter Section -->
    <div
        class="bg-white dark:bg-zinc-900 border-b border-gray-200 dark:border-zinc-800 sticky top-0 z-40 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 lg:px-8 py-4 flex flex-col md:flex-row items-center justify-between gap-4">

            <!-- Title & Count -->
            <div class="flex items-center gap-3">
                <h1 class="text-2xl font-bold text-black dark:text-white">Escorts</h1>
                <span
                    class="bg-gray-100 dark:bg-zinc-800 text-gray-600 dark:text-gray-400 px-3 py-1 rounded-full text-xs font-semibold">
                    {{ $escorts->total() }} Disponibles
                </span>
            </div>

            <!-- Filters (Simplified for now) -->
            <div
                class="flex items-center gap-2 overflow-x-auto md:overflow-visible pb-2 md:pb-0 w-full md:w-auto no-scrollbar">
                <a href="{{ route('escorts.index') }}"
                    class="px-4 py-2 rounded-xl {{ !request('filter') && !request('gender') ? 'bg-brand-pink text-white shadow-lg shadow-brand-pink/20' : 'bg-gray-100 dark:bg-zinc-800 text-gray-600 dark:text-gray-300 hover:bg-white dark:hover:bg-zinc-700 hover:text-brand-pink' }} text-sm font-semibold whitespace-nowrap transition-all border border-transparent hover:border-gray-200 dark:hover:border-zinc-700">
                    Todas
                </a>
                <a href="{{ route('escorts.index', ['filter' => 'diamond']) }}"
                    class="px-4 py-2 rounded-xl {{ request('filter') === 'diamond' ? 'bg-brand-pink text-white shadow-lg shadow-brand-pink/20' : 'bg-gray-100 dark:bg-zinc-800 text-gray-600 dark:text-gray-300 hover:bg-white dark:hover:bg-zinc-700 hover:text-brand-pink' }} text-sm font-semibold whitespace-nowrap transition-all border border-transparent hover:border-gray-200 dark:hover:border-zinc-700">
                    Diamante 💎
                </a>
                <a href="{{ route('escorts.index', ['filter' => 'new']) }}"
                    class="px-4 py-2 rounded-xl {{ request('filter') === 'new' ? 'bg-brand-pink text-white shadow-lg shadow-brand-pink/20' : 'bg-gray-100 dark:bg-zinc-800 text-gray-600 dark:text-gray-300 hover:bg-white dark:hover:bg-zinc-700 hover:text-brand-pink' }} text-sm font-semibold whitespace-nowrap transition-all border border-transparent hover:border-gray-200 dark:hover:border-zinc-700">
                    Nuevas ✨
                </a>
                <a href="{{ route('escorts.index', ['filter' => 'silver']) }}"
                    class="px-4 py-2 rounded-xl {{ request('filter') === 'silver' ? 'bg-brand-pink text-white shadow-lg shadow-brand-pink/20' : 'bg-gray-100 dark:bg-zinc-800 text-gray-600 dark:text-gray-300 hover:bg-white dark:hover:bg-zinc-700 hover:text-brand-pink' }} text-sm font-semibold whitespace-nowrap transition-all border border-transparent hover:border-gray-200 dark:hover:border-zinc-700">
                    Plata 🥈
                </a>



            </div>
        </div>
    </div>

    <!-- Main Grid -->
    <div class="bg-zinc-50 dark:bg-zinc-950 min-h-screen py-8 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 lg:px-8">

            <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-3 sm:gap-6 lg:gap-8">
                @foreach($escorts as $escort)
                    <x-escort-card :escort="$escort" />
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-12 flex justify-center">
                {{ $escorts->links() }}
            </div>

        </div>
    </div>
</x-main-layout>