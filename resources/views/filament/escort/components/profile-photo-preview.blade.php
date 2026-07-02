<div style="display: flex; align-items: center; gap: 1rem;">
    <div style="height: 4rem; width: 4rem; border-radius: 50%; overflow: hidden; border: 2px solid #ec4899;">
        @if($escort && $escort->profile_photo)
            <img src="{{ \Illuminate\Support\Facades\Storage::url($escort->profile_photo) }}" alt="{{ $escort->name }}"
                style="height: 100%; width: 100%; object-fit: cover;">
        @else
            <div
                style="height: 100%; width: 100%; display: flex; align-items: center; justify-content: center; background-color: #f3f4f6; color: #9ca3af;">
                <svg style="height: 2rem; width: 2rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
        @endif
    </div>
    <div>
        <h3 class="font-medium text-lg text-white" style="font-weight: 500; font-size: 1.125rem; color: white;">
            Publicando como <span style="color: #ec4899;">{{ $escort->name ?? 'Escort' }}</span></h3>
        <p class="text-sm text-gray-400" style="font-size: 0.875rem; color: #9ca3af;">
            Tipo de suscripcion: <span style="color: #10b981; font-weight: bold;">Gratis</span>
        </p>
    </div>
</div>