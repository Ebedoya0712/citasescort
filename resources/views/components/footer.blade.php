<footer class="bg-white dark:bg-brand-dark text-black dark:text-white pt-16 pb-8 px-4 lg:px-8 border-t border-gray-200 dark:border-gray-800 transition-colors duration-300">
    <div class="max-w-7xl mx-auto">


        <!-- Bottom Bar -->
        <div class="border-t border-gray-200 dark:border-gray-800 pt-8 flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="text-sm font-semibold tracking-wide text-black dark:text-white flex flex-col gap-2">
                <div>
                    {{ config('settings.footer_text') ?? (config('settings.site_name', 'Citasescort') . ' © ' . date('Y')) }}
                </div>
                @if(config('settings.facebook_url') || config('settings.instagram_url'))
                    <div class="flex items-center gap-4 mt-2">
                        @if(config('settings.facebook_url'))
                            <a href="{{ config('settings.facebook_url') }}" target="_blank" class="text-gray-500 hover:text-brand-pink transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12c0-5.52-4.48-10-10-10S2 6.48 2 12c0 4.84 3.44 8.87 8 9.8V15H8v-3h2V9.5C10 7.57 11.57 6 13.5 6H16v3h-2c-.55 0-1 .45-1 1v2h3v3h-3v6.95c4.56-.93 8-4.96 8-9.75z"/></svg>
                            </a>
                        @endif
                        @if(config('settings.instagram_url'))
                            <a href="{{ config('settings.instagram_url') }}" target="_blank" class="text-gray-500 hover:text-brand-pink transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.051.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                            </a>
                        @endif
                    </div>
                @endif
            </div>
            <div class="flex items-center gap-6 text-sm font-semibold tracking-tight">
                <a href="{{ route('legal.terms') }}" class="hover:text-brand-pink transition-colors">Términos y Condiciones</a>
                <a href="{{ route('legal.privacy') }}" class="hover:text-brand-pink transition-colors">Política de Privacidad</a>
                <a href="{{ route('contact.index') }}" class="hover:text-brand-pink transition-colors">Reportar Contenido</a>
            </div>
        </div>
    </div>
</footer>
