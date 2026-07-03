<section class="bg-white dark:bg-black py-20 px-4 lg:px-8 transition-colors duration-300">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-12">
            <h2 class="text-black dark:text-white text-lg font-bold mb-4">Preguntas Frecuentes sobre Escorts en Perú
            </h2>
            <p class="text-gray-500 dark:text-gray-400 text-sm font-semibold max-w-2xl mx-auto">
                La información aquí escrita aplica exclusivamente a escorts mujeres.
            </p>
        </div>

        <!-- FAQ Items -->
        <div class="space-y-4">
            @php
                $faqs = [
                    [
                        'q' => '¿Qué significa escort?',
                        'a' => 'El término "escort" se utiliza para describir a una persona que ofrece servicios de compañía. Aunque a menudo se asocia con servicios sexuales, una escort también puede acompañar a clientes a eventos sociales, cenas o viajes.'
                    ],
                    [
                        'q' => '¿Qué es una escort?',
                        'a' => 'Una escort es una profesional que brinda servicios de compañía y entretenimiento a cambio de una tarifa acordada. En Citasescort, encontrarás profesionales independientes que gestionan sus propios servicios.'
                    ],
                    [
                        'q' => '¿Qué es Citasescort?',
                        'a' => 'Citasescort es la plataforma líder en Perú para encontrar anuncios de escorts y servicios de masajes. Facilitamos la conexión entre profesionales y clientes de forma segura y discreta.'
                    ],
                    [
                        'q' => '¿Qué clases de escorts puedo encontrar en Citasescort?',
                        'a' => 'En nuestra plataforma puedes encontrar una gran diversidad de perfiles de escorts mujeres, con diferentes especialidades y servicios.'
                    ],
                    [
                        'q' => '¿Dónde puedo encontrarme con una escort?',
                        'a' => 'Los encuentros suelen darse en el apartamento privado de la escort (apto propio) o en el domicilio/hotel del cliente (salidas). Cada perfil especifica sus preferencias de ubicación.'
                    ],
                    [
                        'q' => '¿Cuánto cuesta una escort en Perú?',
                        'a' => 'Los precios varían según la profesional, el tiempo contratado y el tipo de servicio. En cada anuncio de Citasescort podrás ver las tarifas orientativas de cada escort.'
                    ],
                    [
                        'q' => '¿Puedo llevar a una escort a un evento?',
                        'a' => 'Sí, muchas escorts ofrecen servicios de acompañamiento para eventos sociales, bodas o cenas de negocios. Se recomienda consultar disponibilidad para estos servicios específicos.'
                    ],
                    [
                        'q' => '¿Qué errores debería evitar al tratar con escorts en Perú?',
                        'a' => 'Es fundamental ser siempre respetuoso, puntual y claro en los acuerdos. Evita el lenguaje soez y respeta siempre los límites establecidos por la profesional.'
                    ],
                    [
                        'q' => '¿Las escorts de Citasescort, son independientes?',
                        'a' => 'La gran mayoría de las profesionales que se anuncian en Citasescort trabajan de forma independiente, gestionando sus propios horarios, tarifas y condiciones de servicio.'
                    ],
                    [
                        'q' => '¿Por qué me conviene usar Citasescort?',
                        'a' => 'Ofrecemos el directorio más completo y verificado de Perú, con fotos reales, opiniones de otros usuarios y una interfaz fácil de usar tanto en móvil como en escritorio.'
                    ],
                ];
            @endphp

            @foreach ($faqs as $index => $faq)
                <div class="faq-item bg-white dark:bg-zinc-900/40 border border-gray-200 dark:border-zinc-800 rounded-2xl overflow-hidden cursor-pointer group hover:border-red-600/30 hover:shadow-md transition-all duration-300 shadow-sm"
                    onclick="toggleFaq({{ $index }})">
                    <div class="flex items-center justify-between p-5 px-6">
                        <span
                            class="text-gray-900 dark:text-white group-hover:text-red-600 font-bold text-sm tracking-tight select-none transition-colors">{{ $faq['q'] }}</span>
                        <svg id="arrow-{{ $index }}" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round"
                            stroke-linejoin="round" class="text-gray-400 group-hover:text-red-600 transition-colors transition-transform duration-300">
                            <path d="m6 9 6 6 6-6" />
                        </svg>
                    </div>
                    <div id="answer-{{ $index }}" class="max-h-0 overflow-hidden transition-all duration-300 ease-in-out">
                        <div
                            class="p-6 pt-0 text-gray-600 dark:text-gray-300 text-sm leading-relaxed border-t border-gray-100 dark:border-zinc-800/80 mt-2">
                            {{ $faq['a'] }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<script>
    function toggleFaq(index) {
        const answer = document.getElementById(`answer-${index}`);
        const arrow = document.getElementById(`arrow-${index}`);

        // Close all other faqs (optional, uncomment if you want only one open at a time)
        /*
        document.querySelectorAll('[id^="answer-"]').forEach((el, idx) => {
            if (idx !== index) {
                el.style.maxHeight = null;
                document.getElementById(`arrow-${idx}`).style.transform = 'rotate(0deg)';
            }
        });
        */

        if (answer.style.maxHeight) {
            answer.style.maxHeight = null;
            arrow.style.transform = 'rotate(0deg)';
        } else {
            answer.style.maxHeight = answer.scrollHeight + "px";
            arrow.style.transform = 'rotate(180deg)';
        }
    }
</script>