<div style="display: flex; justify-content: center; margin-bottom: 1rem;">
    @php
        $qrImage = config('settings.yape_qr_image');
    @endphp
    @if($qrImage)
        <img src="{{ Storage::url($qrImage) }}" alt="QR Yape" style="max-width: 200px; border-radius: 0.5rem; border: 1px solid #3f3f46;">
    @else
        <div style="width: 200px; height: 200px; background-color: #27272a; border-radius: 0.5rem; display: flex; align-items: center; justify-content: center; color: #a1a1aa; border: 1px dashed #52525b;">
            Sin QR configurado
        </div>
    @endif
</div>
