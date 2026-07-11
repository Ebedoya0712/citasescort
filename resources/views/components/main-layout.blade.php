<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @php
        $siteName = config('settings.site_name') ?? config('app.name', 'Laravel');
        $seoTitle = $title ?? config('settings.seo_title') ?? 'Citas Escort Perú | Kines VIP, Escorts y Kinesiologas 24/7';
        $seoDescription = config('settings.seo_description') ?? 'El mejor portal de escorts en Perú. Encuentra kines VIP, kinesiologas y acompañantes de lujo en Lima y provincias. Fotos reales, contacto directo y discreción garantizada.';
        $seoKeywords = config('settings.seo_keywords') ?? 'Escorts en Perú, Escorts en Lima, Kines VIP, Putas de lujo, Kinesiologas, Masajes eróticos, Putas en Perú, Citas Escorts';
        $currentUrl = request()->url();
    @endphp
    
    <title>{{ $seoTitle }}</title>
    <meta name="description" content="{{ $seoDescription }}">
    <meta name="keywords" content="{{ $seoKeywords }}">
    <meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large">
    <link rel="canonical" href="{{ $currentUrl }}" />
    <meta name="google-site-verification" content="833GlyCFJwaHCw9VGlijfo3BY3iVEr54kbYk9yetOK4" />
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ $currentUrl }}">
    <meta property="og:title" content="{{ $seoTitle }}">
    <meta property="og:description" content="{{ $seoDescription }}">
    <meta property="og:site_name" content="{{ $siteName }}">
    @if(config('settings.site_logo'))
    <meta property="og:image" content="{{ asset('storage/' . config('settings.site_logo')) }}">
    @endif
    
    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ $currentUrl }}">
    <meta name="twitter:title" content="{{ $seoTitle }}">
    <meta name="twitter:description" content="{{ $seoDescription }}">
    @if(config('settings.site_logo'))
    <meta name="twitter:image" content="{{ asset('storage/' . config('settings.site_logo')) }}">
    @endif

    <!-- Schema.org JSON-LD -->
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@@type": "WebSite",
      "name": "{{ $siteName }}",
      "url": "{{ url('/') }}",
      "description": "{{ $seoDescription }}",
      "potentialAction": {
        "@@type": "SearchAction",
        "target": "{{ url('/search') }}?q={search_term_string}",
        "query-input": "required name=search_term_string"
      }
    }
    </script>
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@@type": "Organization",
      "name": "{{ $siteName }}",
      "url": "{{ url('/') }}",
      @if(config('settings.site_logo'))
      "logo": "{{ asset('storage/' . config('settings.site_logo')) }}",
      @endif
      "contactPoint": {
        "@@type": "ContactPoint",
        "contactType": "customer support"
      }
    }
    </script>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/intersect@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        window.applyTheme = function (theme) {
            const isDark = theme === 'dark';
            const html = document.documentElement;

            if (isDark) {
                html.classList.add('dark');
            } else {
                html.classList.remove('dark');
            }

            localStorage.setItem('theme', theme);
        };

        (function () {
            const theme = localStorage.getItem('theme') || 'dark';
            window.applyTheme(theme);
            window.addEventListener('DOMContentLoaded', () => window.applyTheme(localStorage.getItem('theme') || 'dark'));
        })();
    </script>
</head>

<body class="font-sans antialiased transition-colors duration-300">
    <!-- Top Pink Bar -->
    <!-- Top Pink Bar -->
    <div class="relative z-50 shadow-md">
        <a href="#"
            class="force-dark-overlay block w-full bg-red-600 text-white text-center py-4 font-bold text-base hover:bg-opacity-90 transition-all flex items-center justify-center gap-2">
            Publicate como Escort 💫
        </a>
    </div>

    <!-- Header Component -->
    @unless($attributes->has('no-header'))
        <x-header />
    @endunless

    <!-- Page Content -->
    <main>
        {{ $slot }}
    </main>

    <!-- Sidebar Filters -->
    <x-filter-sidebar />

    <!-- Footer Component -->
    @unless($attributes->has('no-footer'))
        <x-footer />
    @endunless

    <!-- Age Verification Modal -->
    <x-age-verification />

    <!-- Visitor Tracking CRM Script -->
    <script>
        (function() {
            // Generar UUID v4
            function generateUUID() {
                return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
                    var r = Math.random() * 16 | 0, v = c == 'x' ? r : (r & 0x3 | 0x8);
                    return v.toString(16);
                });
            }

            // Gestión de Cookies
            function setCookie(name, value, days) {
                var expires = "";
                if (days) {
                    var date = new Date();
                    date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                    expires = "; expires=" + date.toUTCString();
                }
                document.cookie = name + "=" + (value || "") + expires + "; path=/; SameSite=Lax";
            }

            function getCookie(name) {
                var nameEQ = name + "=";
                var ca = document.cookie.split(';');
                for (var i = 0; i < ca.length; i++) {
                    var c = ca[i];
                    while (c.charAt(0) == ' ') c = c.substring(1, c.length);
                    if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
                }
                return null;
            }

            // Sincronizar localStorage y Cookies para ID único persistente
            let visitorUuid = localStorage.getItem('visitor_uuid');
            let cookieUuid = getCookie('visitor_uuid');

            if (!visitorUuid && !cookieUuid) {
                visitorUuid = generateUUID();
                localStorage.setItem('visitor_uuid', visitorUuid);
                setCookie('visitor_uuid', visitorUuid, 365 * 5); // 5 años
            } else if (visitorUuid && !cookieUuid) {
                setCookie('visitor_uuid', visitorUuid, 365 * 5);
            } else if (!visitorUuid && cookieUuid) {
                visitorUuid = cookieUuid;
                localStorage.setItem('visitor_uuid', visitorUuid);
            } else if (visitorUuid !== cookieUuid) {
                visitorUuid = cookieUuid;
                localStorage.setItem('visitor_uuid', visitorUuid);
            }

            // Obtener parámetros UTM / campañas
            const urlParams = new URLSearchParams(window.location.search);
            const utmParams = {
                utm_source: urlParams.get('utm_source'),
                utm_medium: urlParams.get('utm_medium'),
                utm_campaign: urlParams.get('utm_campaign'),
                utm_content: urlParams.get('utm_content'),
                utm_term: urlParams.get('utm_term'),
                gclid: urlParams.get('gclid'),
                fbclid: urlParams.get('fbclid')
            };

            let visitLogId = null;
            let visitorInfo = { has_whatsapp: false, name: '', whatsapp: '' };

            // Registrar la visita al cargar la página
            window.addEventListener('DOMContentLoaded', () => {
                const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
                if (!csrfTokenMeta) return;

                fetch('/visitor/track', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfTokenMeta.getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        visitor_uuid: visitorUuid,
                        url: window.location.href,
                        referrer: document.referrer,
                        ...utmParams
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        visitLogId = data.visit_log_id;
                        visitorInfo = data.visitor;
                        
                        // Iniciar heartbeat de duración cada 10 segundos
                        setInterval(() => {
                            if (!visitLogId) return;
                            fetch('/visitor/heartbeat', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': csrfTokenMeta.getAttribute('content'),
                                    'Accept': 'application/json'
                                },
                                body: JSON.stringify({ visit_log_id: visitLogId })
                            }).catch(err => console.error('Heartbeat error:', err));
                        }, 10000);
                    }
                })
                .catch(err => console.error('Tracking error:', err));
            });

            // Interceptar clics en enlaces de WhatsApp
            document.addEventListener('click', function(e) {
                const waLink = e.target.closest('a[href^="https://wa.me/"]');
                if (!waLink) return;

                const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
                const token = csrfTokenMeta ? csrfTokenMeta.getAttribute('content') : '';

                // Registrar clic de WhatsApp en base de datos
                fetch('/visitor/track-click', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ visitor_uuid: visitorUuid })
                }).catch(err => console.error('Click tracking error:', err));

                // Si no tiene número registrado, solicitar autorización
                if (!visitorInfo.has_whatsapp) {
                    e.preventDefault();
                    showWhatsAppModal(waLink.href, token);
                }
            });

            // Función para mostrar el modal de WhatsApp
            function showWhatsAppModal(destinationUrl, csrfToken) {
                if (document.getElementById('crm-whatsapp-modal')) return;

                const modalHtml = `
                <style>
                    .dark #crm-whatsapp-modal h3 { color: #ffffff !important; }
                    .dark #crm-whatsapp-modal p, .dark #crm-whatsapp-modal label { color: #9ca3af !important; }
                </style>
                <div id="crm-whatsapp-modal" class="fixed inset-0 z-[9999] flex items-center justify-center p-4 bg-black/70 backdrop-blur-sm transition-opacity duration-300 opacity-0 font-sans">
                    <div class="bg-white dark:bg-[#1c1c1e] w-full max-w-md p-6 sm:p-8 rounded-2xl border border-gray-200 dark:border-[#2c2c2e] shadow-2xl transition-all duration-300 transform scale-95 text-gray-800 dark:text-gray-100">
                        <!-- Header -->
                        <div class="text-center mb-6">
                            <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 text-green-500 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.232-.298.33-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white" style="color: inherit;">¿Deseas agendar tu contacto?</h3>
                            <p class="text-gray-500 dark:text-gray-400 text-sm mt-2">
                                Si guardas tu WhatsApp, podremos recordar tus accesos y asistirte de forma personalizada en futuras visitas.
                            </p>
                        </div>

                        <!-- Form -->
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Tu número de WhatsApp</label>
                                <input type="tel" id="crm-wa-input" placeholder="Ej: 099 123 456" class="w-full px-4 py-3 bg-gray-50 dark:bg-[#111] border border-gray-300 dark:border-[#333] rounded-xl text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                            </div>
                            <div class="flex items-start gap-2.5">
                                <input type="checkbox" id="crm-wa-consent" class="mt-1 accent-green-600 rounded">
                                <label for="crm-wa-consent" class="text-xs text-gray-500 dark:text-gray-400 select-none leading-relaxed">
                                    Autorizo guardar mi número de WhatsApp de forma segura para agilizar mis consultas comerciales en este sitio.
                                </label>
                            </div>
                            <div id="crm-wa-error" class="hidden text-red-500 text-xs font-medium">Por favor, ingresa tu número y marca la casilla de autorización.</div>
                        </div>

                        <!-- Footer Actions -->
                        <div class="flex flex-col gap-2.5 mt-6">
                            <button id="crm-wa-submit" class="w-full py-3.5 bg-green-600 hover:bg-green-500 text-white rounded-xl font-bold transition-all transform hover:-translate-y-0.5 shadow-lg shadow-green-900/20">
                                Guardar y Continuar
                            </button>
                            <button id="crm-wa-skip" style="display: none !important;" class="w-full py-3 bg-transparent border border-gray-300 dark:border-[#333] text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-zinc-800 rounded-xl font-semibold transition-all">
                                Continuar sin Guardar
                            </button>
                        </div>
                    </div>
                </div>
                `;

                document.body.insertAdjacentHTML('beforeend', modalHtml);
                const modal = document.getElementById('crm-whatsapp-modal');
                
                // Animar entrada
                setTimeout(() => {
                    modal.classList.remove('opacity-0');
                    modal.querySelector('.transform').classList.remove('scale-95');
                }, 50);

                const input = document.getElementById('crm-wa-input');
                const consent = document.getElementById('crm-wa-consent');
                const submitBtn = document.getElementById('crm-wa-submit');
                const skipBtn = document.getElementById('crm-wa-skip');
                const errorDiv = document.getElementById('crm-wa-error');

                function closeModalAndRedirect() {
                    modal.classList.add('opacity-0');
                    modal.querySelector('.transform').classList.add('scale-95');
                    setTimeout(() => {
                        modal.remove();
                        window.open(destinationUrl, '_blank');
                    }, 300);
                }

                submitBtn.addEventListener('click', () => {
                    const number = input.value.trim();
                    if (!number || !consent.checked) {
                        errorDiv.classList.remove('hidden');
                        return;
                    }
                    errorDiv.classList.add('hidden');
                    submitBtn.disabled = true;
                    submitBtn.textContent = 'Guardando...';

                    fetch('/visitor/save-whatsapp', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            visitor_uuid: visitorUuid,
                            whatsapp_number: number,
                            consent: true
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            visitorInfo.has_whatsapp = true;
                            visitorInfo.whatsapp = number;
                        }
                        closeModalAndRedirect();
                    })
                    .catch(err => {
                        console.error('Error saving WhatsApp:', err);
                        closeModalAndRedirect();
                    });
                });

                skipBtn.addEventListener('click', () => {
                    closeModalAndRedirect();
                });
            }
        })();
    </script>
</body>

</html>