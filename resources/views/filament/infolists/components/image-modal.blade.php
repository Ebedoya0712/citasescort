@php
    $raw = $getState();
    $allMedia = is_array($raw) ? array_values($raw) : ($raw ? [$raw] : []);
    
    // Filter out videos, keeping only images
    $images = array_filter($allMedia, function ($file) {
        $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        return !in_array($ext, ['mp4', 'mov', 'avi', 'webm', 'm4v', '3gp', 'ogg']);
    });
    
    $urls = array_map(fn($img) => Str::startsWith($img, 'http') ? $img : asset('storage/' . ltrim($img, '/')), array_values($images));
@endphp

<div x-data="{ 
    open: false, 
    idx: 0, 
    zoomed: false,
    urls: @js($urls),
    get total() { return this.urls.length },
    prev() { this.idx = (this.idx - 1 + this.total) % this.total; this.zoomed = false; },
    next() { this.idx = (this.idx + 1) % this.total; this.zoomed = false; },
    show(i) { this.idx = i; this.open = true; this.zoomed = false; }
}" style="position: relative;">

    @if (count($urls))
        <div style="display: flex; flex-wrap: wrap; gap: 10px;">
            @foreach($urls as $i => $url)
                <img @click="show({{ $i }})" src="{{ $url }}" alt="Imagen"
                    style="height: 140px; width: 140px; object-fit: cover; border-radius: 10px; cursor: pointer; border: 2px solid rgba(255,255,255,0.1); transition: all 0.2s; flex-shrink: 0;"
                    onmouseover="this.style.opacity='0.8'; this.style.borderColor='#dc2626'"
                    onmouseout="this.style.opacity='1'; this.style.borderColor='rgba(255,255,255,0.1)'">
            @endforeach
        </div>

        <!-- Full Gallery Modal -->
        <div x-show="open" x-transition.opacity.duration.200ms @keydown.escape.window="open = false"
            @keydown.left.window="prev()" @keydown.right.window="next()"
            style="position: fixed; top: 0; left: 0; right: 0; bottom: 0; width: 100vw; height: 100vh; z-index: 99999; background: rgba(0,0,0,0.95);"
            :style="{ display: open ? 'block' : 'none' }">

            <!-- Top bar: counter + close -->
            <div
                style="position: fixed; top: 0; left: 0; right: 0; z-index: 100001; display: flex; justify-content: space-between; align-items: center; padding: 12px 20px;">
                <span style="color: rgba(255,255,255,0.7); font-size: 14px; font-weight: 600;"
                    x-text="(idx + 1) + ' / ' + total"></span>

                <div style="display: flex; gap: 8px;">
                    <!-- Zoom toggle -->
                    <button @click="zoomed = !zoomed" type="button"
                        style="background: rgba(255,255,255,0.15); color: white; border: none; border-radius: 50%; width: 40px; height: 40px; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: background 0.2s;"
                        onmouseover="this.style.background='rgba(255,255,255,0.3)'"
                        onmouseout="this.style.background='rgba(255,255,255,0.15)'"
                        :title="zoomed ? 'Zoom Out' : 'Zoom In'">
                        <svg x-show="!zoomed" style="width: 20px; height: 20px;" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" stroke-width="2">
                            <circle cx="11" cy="11" r="7" />
                            <path d="M21 21l-4.35-4.35M11 8v6M8 11h6" />
                        </svg>
                        <svg x-show="zoomed" style="width: 20px; height: 20px;" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" stroke-width="2">
                            <circle cx="11" cy="11" r="7" />
                            <path d="M21 21l-4.35-4.35M8 11h6" />
                        </svg>
                    </button>
                    <!-- Close -->
                    <button @click="open = false; zoomed = false" type="button"
                        style="background: rgba(255,255,255,0.15); color: white; border: none; border-radius: 50%; width: 40px; height: 40px; cursor: pointer; font-size: 18px; font-weight: bold; display: flex; align-items: center; justify-content: center; transition: background 0.2s;"
                        onmouseover="this.style.background='rgba(255,255,255,0.3)'"
                        onmouseout="this.style.background='rgba(255,255,255,0.15)'">
                        ✕
                    </button>
                </div>
            </div>

            <!-- Left arrow -->
            <button x-show="total > 1" @click.stop="prev()" type="button"
                style="position: fixed; left: 16px; top: 50%; transform: translateY(-50%); z-index: 100001; background: rgba(255,255,255,0.12); color: white; border: none; border-radius: 50%; width: 48px; height: 48px; cursor: pointer; font-size: 24px; display: flex; align-items: center; justify-content: center; transition: background 0.2s;"
                onmouseover="this.style.background='rgba(255,255,255,0.3)'"
                onmouseout="this.style.background='rgba(255,255,255,0.12)'">
                ‹
            </button>

            <!-- Right arrow -->
            <button x-show="total > 1" @click.stop="next()" type="button"
                style="position: fixed; right: 16px; top: 50%; transform: translateY(-50%); z-index: 100001; background: rgba(255,255,255,0.12); color: white; border: none; border-radius: 50%; width: 48px; height: 48px; cursor: pointer; font-size: 24px; display: flex; align-items: center; justify-content: center; transition: background 0.2s;"
                onmouseover="this.style.background='rgba(255,255,255,0.3)'"
                onmouseout="this.style.background='rgba(255,255,255,0.12)'">
                ›
            </button>

            <!-- Centered image -->
            <div @click="open = false; zoomed = false"
                style="width: 100%; height: 100%; display: flex; justify-content: center; align-items: center; padding: 60px 80px; overflow: auto;">
                <img @click.stop="zoomed = !zoomed" :src="urls[idx]"
                    :style="zoomed 
                            ? 'max-width: none; max-height: none; width: auto; height: auto; min-width: 120%; cursor: zoom-out; border-radius: 8px;' 
                            : 'max-height: 85vh; max-width: 85vw; object-fit: contain; border-radius: 12px; box-shadow: 0 25px 50px rgba(0,0,0,0.5); cursor: zoom-in;'">
            </div>
        </div>
    @else
        <p style="font-size: 0.875rem; color: #6b7280;">No hay imagen.</p>
    @endif
</div>