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


                <!-- Currency Dropdown -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" @click.away="open = false"
                        class="px-4 py-2 rounded-xl flex items-center gap-2 {{ request('currency') ? 'bg-brand-pink text-white shadow-lg shadow-brand-pink/20' : 'bg-gray-100 dark:bg-zinc-800 text-gray-600 dark:text-gray-300 hover:bg-white dark:hover:bg-zinc-700 hover:text-brand-pink' }} text-sm font-semibold whitespace-nowrap transition-all border border-transparent hover:border-gray-200 dark:hover:border-zinc-700">
                        <span>
                            @if(request('currency')) {{ strtoupper(request('currency')) }}
                            @else Moneda 💵
                            @endif
                        </span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 transition-transform duration-200"
                            :class="open ? 'rotate-180' : ''" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>

                    <div x-show="open" x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="transform opacity-0 scale-95"
                        x-transition:enter-end="transform opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="transform opacity-100 scale-100"
                        x-transition:leave-end="transform opacity-0 scale-95"
                        class="absolute top-full right-0 mt-2 w-40 bg-white dark:bg-zinc-900 rounded-xl shadow-xl border border-gray-100 dark:border-zinc-700 overflow-hidden z-50">

                        <a href="{{ route('escorts.index', array_merge(request()->except('currency'), ['currency' => 'PEN'])) }}"
                            class="flex items-center justify-between px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-zinc-50 dark:hover:bg-zinc-800 hover:text-brand-pink transition-colors {{ request('currency') === 'PEN' ? 'bg-zinc-50 dark:bg-zinc-800 text-brand-pink font-bold' : '' }}">
                            <span>PEN (S/)</span>
                        </a>
                        <a href="{{ route('escorts.index', array_merge(request()->except('currency'), ['currency' => 'USD'])) }}"
                            class="flex items-center justify-between px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-zinc-50 dark:hover:bg-zinc-800 hover:text-brand-pink transition-colors {{ request('currency') === 'USD' ? 'bg-zinc-50 dark:bg-zinc-800 text-brand-pink font-bold' : '' }}">
                            <span>USD ($)</span>
                        </a>

                        @if(request('currency'))
                            <div class="border-t border-gray-100 dark:border-zinc-800 my-1"></div>
                            <a href="{{ route('escorts.index', request()->except('currency')) }}"
                                class="flex items-center justify-center gap-2 px-4 py-2 text-xs font-semibold text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                                Limpiar
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </a>
                        @endif
                    </div>
                </div>
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