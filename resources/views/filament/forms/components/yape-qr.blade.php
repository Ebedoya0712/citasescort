<div x-data="{ showQr: false }" style="display: flex; flex-direction: column; align-items: center; margin-bottom: 1rem; gap: 1rem;">
    <button 
        type="button" 
        x-on:click="showQr = !showQr" 
        style="background-color: #3f3f46; color: white; padding: 0.5rem 1rem; border-radius: 0.5rem; border: none; cursor: pointer; font-weight: bold; font-size: 0.9rem; transition: background-color 0.2s;"
        onmouseover="this.style.backgroundColor='#52525b'"
        onmouseout="this.style.backgroundColor='#3f3f46'"
    >
        <span x-text="showQr ? 'Ocultar código QR' : 'Ver código QR'">Ver código QR</span>
    </button>

    <div x-show="showQr" x-collapse x-cloak>
        <img src="{{ asset('images/QR.png') }}" alt="QR Yape" style="max-width: 200px; border-radius: 0.5rem; border: 1px solid #3f3f46;">
    </div>
</div>
