@php
    $paths = $getRecord()->media_path;
    $path = is_array($paths) ? ($paths[0] ?? '') : $paths;
    $extension = pathinfo((string)$path, PATHINFO_EXTENSION);
    $isVideo = in_array(strtolower($extension), ['mp4', 'mov', 'avi', 'webm']);
    $url = $path ? \Illuminate\Support\Facades\Storage::url($path) : '';
@endphp

<div class="px-4 py-3" style="width: 80px;">
    @if($isVideo)
        <div class="relative rounded-lg overflow-hidden bg-gray-800 flex items-center justify-center shadow-sm border border-gray-700" style="width: 60px; height: 60px;">
            <svg class="text-pink-500" style="width: 30px; height: 30px;" fill="currentColor" viewBox="0 0 20 20">
                <path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z"></path>
            </svg>
            <span class="absolute bottom-0 right-0 bg-black bg-opacity-70 text-white px-1 rounded-tl" style="font-size: 10px;">VIDEO</span>
        </div>
    @else
        <img src="{{ $url }}" class="object-cover rounded-lg shadow-sm border border-gray-700" style="width: 60px; height: 60px;" alt="Vista previa">
    @endif
</div>
