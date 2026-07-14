@php
    $raw = $getState();
    $allMedia = is_array($raw) ? array_values($raw) : ($raw ? [$raw] : []);
    
    // Filter to keep only video files
    $videos = array_filter($allMedia, function ($file) {
        $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        return in_array($ext, ['mp4', 'mov', 'avi', 'webm', 'm4v', '3gp', 'ogg']);
    });
    
    $urls = array_map(fn($vid) => Str::startsWith($vid, 'http') ? $vid : asset('storage/' . ltrim($vid, '/')), array_values($videos));
@endphp

<div x-data="{ 
    open: false, 
    activeUrl: '',
    showVideo(url) {
        this.activeUrl = url;
        this.open = true;
    }
}" style="position: relative;">

    @if (count($urls))
        <div style="display: flex; flex-wrap: wrap; gap: 10px;">
            @foreach($urls as $url)
                <div @click="showVideo('{{ $url }}')"
                    style="position: relative; height: 140px; width: 200px; border-radius: 10px; cursor: pointer; border: 2px solid rgba(255,255,255,0.1); overflow: hidden; background: #000; display: flex; align-items: center; justify-content: center; flex-shrink: 0; transition: all 0.2s;"
                    onmouseover="this.style.borderColor='#dc2626'" onmouseout="this.style.borderColor='rgba(255,255,255,0.1)'">
                    <video style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; opacity: 0.6;">
                        <source src="{{ $url }}" type="video/mp4">
                    </video>
                    <div
                        style="z-index: 10; background: rgba(255,255,255,0.2); width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; border-radius: 50%; backdrop-filter: blur(4px);">
                        <svg style="width: 24px; height: 24px; color: white; margin-left: 3px;" fill="currentColor"
                            viewBox="0 0 20 20">
                            <path d="M4 4l12 6-12 6z"></path>
                        </svg>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Modal Video Player -->
        <div x-show="open" x-transition.opacity.duration.200ms @keydown.escape.window="open = false"
            style="position: fixed; top: 0; left: 0; right: 0; bottom: 0; width: 100vw; height: 100vh; z-index: 99999; background: rgba(0,0,0,0.95);"
            :style="{ display: open ? 'block' : 'none' }">

            <!-- Close button -->
            <button @click="open = false" type="button"
                style="position: fixed; top: 16px; right: 16px; z-index: 100000; background: rgba(255,255,255,0.9); color: #111; border: none; border-radius: 50%; width: 44px; height: 44px; cursor: pointer; font-size: 22px; font-weight: bold; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 10px rgba(0,0,0,0.3);">
                ✕
            </button>

            <!-- Centered video container -->
            <div @click="open = false"
                style="width: 100%; height: 100%; display: flex; justify-content: center; align-items: center; padding: 40px;">
                <!-- Opción 1 (La más usada y eficiente): Le colocamos la marca de agua visualmente encima del reproductor web y bloqueamos el clic derecho / descarga nativa. Así, el usuario no puede descargarlo fácilmente, y si intentan grabar la pantalla con su celular, la marca de agua saldrá -->
                <template x-if="open">
                    <div style="position: relative; max-height: 90vh; max-width: 90vw; display: flex; align-items: center; justify-content: center;">
                        <video @click.stop controls autoplay :src="activeUrl" controlsList="nodownload" oncontextmenu="return false;"
                            style="max-height: 90vh; max-width: 90vw; border-radius: 12px; box-shadow: 0 25px 50px rgba(0,0,0,0.5);">
                        </video>
                        <!-- Watermark -->
                        <div style="position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; pointer-events: none; z-index: 10; opacity: 0.6;">
                            <div style="font-size: 1.5rem; font-weight: 900; text-transform: uppercase; letter-spacing: 0.1em; text-shadow: 0 4px 4px rgba(0,0,0,0.8); user-select: none; display: flex;">
                                <span style="color: #ef4444;">CITAS</span>
                                <span style="color: #ffffff;">ESCORT</span>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    @else
        <p style="font-size: 0.875rem; color: #6b7280;">No hay video subido.</p>
    @endif
</div>