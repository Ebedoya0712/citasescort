@props(['place', 'color'])

<div
    class="bg-zinc-900 border border-white/10 rounded-lg overflow-hidden group hover:border-opacity-50 transition-all duration-300 hover:shadow-lg hover:-translate-y-1 block h-full">
    <div class="relative h-64 overflow-hidden">
        <img src="{{ $place->cover_image }}" alt="{{ $place->name }}"
            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
        <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent opacity-60"></div>

        <!-- Rating Badge -->
        @if($place->rating > 0)
            <div
                class="absolute bottom-3 right-3 bg-black/80 backdrop-blur-sm text-white text-xs font-bold px-2 py-1 rounded-full border border-white/10 flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="currentColor"
                    class="text-red-500">
                    <polygon
                        points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2">
                    </polygon>
                </svg>
                {{ $place->rating }}
            </div>
        @endif
    </div>

    <div class="p-4">
        <h3 class="text-xl font-bold text-white mb-1 group-hover:text-[{{ $color }}] transition-colors"
            style="color: white on hover: {{ $color }};">
            {{ $place->name }}
        </h3>
        <p class="text-sm text-gray-400 mb-3">{{ $place->address }}</p>

        <div class="flex items-center gap-2">
            @if($place->phone)
                <a href="tel:{{ $place->phone }}"
                    class="text-xs bg-white/5 hover:bg-white/10 text-white px-2 py-1 rounded transition-colors border border-white/5">
                    📞 Llamar
                </a>
            @endif
            <a href="#"
                class="text-xs border text-[{{ $color }}] border-[{{ $color }}] hover:bg-[{{ $color }}] hover:text-white px-2 py-1 rounded transition-colors uppercase font-bold tracking-wider ml-auto"
                style="border-color: {{ $color }}; color: {{ $color }};">
                Ver más
            </a>
        </div>
    </div>
</div>