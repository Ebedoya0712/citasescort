<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure we have a user to assign posts to
        $user = User::first() ?? User::factory()->create();

        $posts = [
            [
                'title' => 'Gran Apertura de Citasescort: La Nueva Experiencia VIP',
                'image' => 'https://picsum.photos/800/600?random=11', // Luxury event
                'content' => 'Â¡Bienvenidos a Citasescort! Estamos emocionados de lanzar la plataforma mÃ¡s exclusiva de Uruguay. AquÃ­ encontrarÃ¡s perfiles verificados, contenido premium y una experiencia de usuario inigualable. Nuestro compromiso es la seguridad y la discreciÃ³n. ExplorÃ¡ nuestras categorÃ­as y descubrÃ­ lo mejor de la noche uruguaya.',
            ],
            [
                'title' => 'Top 5 Lugares para Citas en Montevideo',
                'image' => 'https://picsum.photos/800/600?random=12', // Cocktail bar
                'content' => 'Â¿BuscÃ¡s el lugar perfecto para impresionar? DescubrÃ­ nuestra selecciÃ³n de los bares y restaurantes mÃ¡s Ã­ntimos y elegantes de la capital. Desde rooftops en Pocitos hasta cavas exclusivas en la Ciudad Vieja, Montevideo tiene rincones mÃ¡gicos para compartir momentos inolvidables.',
            ],
            [
                'title' => 'Seguridad y Privacidad: Nuestra Prioridad',
                'image' => 'https://picsum.photos/800/600?random=13', // Abstract security/tech
                'content' => 'En Citasescort, nos tomamos tu seguridad muy en serio. Todas nuestras escorts pasan por un riguroso proceso de verificaciÃ³n. AdemÃ¡s, protegemos los datos de nuestros usuarios con los mÃ¡s altos estÃ¡ndares de encriptaciÃ³n. ConocÃ© mÃ¡s sobre nuestras polÃ­ticas de privacidad y cÃ³mo garantizamos una experiencia segura.',
            ],
            [
                'title' => 'Eventos Exclusivos en Punta del Este',
                'image' => 'https://picsum.photos/800/600?random=14', // Party/beach
                'content' => 'La temporada en Punta del Este se viene con todo. Fiestas privadas, desfiles de moda y los eventos mÃ¡s exclusivos del verano. Mantenete al tanto de la agenda VIP y no te pierdas nada. Â¡El verano se vive mejor con buena compaÃ±Ã­a!',
            ],
            [
                'title' => 'GuÃ­a para una Cita Perfecta',
                'image' => 'https://picsum.photos/800/600?random=15', // Restaurant dinner
                'content' => 'El arte de la seducciÃ³n empieza por los detalles. Te damos algunos consejos para que tu cita sea un Ã©xito total. Desde la elecciÃ³n del lugar hasta los temas de conversaciÃ³n, todo cuenta. Preparate para vivir una velada Ãºnica.',
            ],
             [
                'title' => 'Nuevas Incorporaciones: Talento Internacional',
                'image' => 'https://picsum.photos/800/600?random=16', // Portrait
                'content' => 'Estamos orgullosos de presentar nuevos perfiles en nuestra categorÃ­a Diamante. Modelos internacionales que llegan para elevar el nivel de exclusividad. DescubrÃ­ sus perfiles y reservÃ¡ una cita inolvidable.',
            ],
            [
                'title' => 'GuÃ­a De Sitios De Escorts En Uruguay',
                'image' => 'https://picsum.photos/800/600?random=17',
                'content' => '
<p>Navegar por el mundo de los acompaÃ±antes en Uruguay puede ser abrumador al principio. En esta guÃ­a detallada, te explicamos cÃ³mo utilizar nuestra plataforma para encontrar exactamente lo que buscas, las diferencias entre nuestras categorÃ­as y cÃ³mo contactar a las escorts de forma segura y discreta.</p>

<h3>1. Conoce nuestras CategorÃ­as VIP</h3>
<p>En Citasescort hemos clasificado los perfiles para que se ajusten a tus expectativas:</p>
<ul>
    <li><strong>CategorÃ­a Diamante:</strong> Modelos exclusivas, muchas de ellas internacionales, que ofrecen un trato de altÃ­simo nivel. Ideal para eventos sociales de gala, viajes corporativos o experiencias inolvidables.</li>
    <li><strong>CategorÃ­a Plata:</strong> Chicas hermosas y apasionadas, con perfiles 100% verificados. Ofrecen una excelente relaciÃ³n calidad-precio para encuentros casuales o escapadas romÃ¡nticas.</li>
    <li><strong>Casas de Masajes y WhiskerÃ­as:</strong> Si prefieres un ambiente mÃ¡s controlado, contamos con un mapa interactivo de los mejores locales fÃ­sicos de Montevideo y el interior.</li>
</ul>

<h3>2. CÃ³mo utilizar los filtros de bÃºsqueda</h3>
<p>Nuestra pÃ¡gina principal estÃ¡ diseÃ±ada para facilitarte la vida. Puedes utilizar la barra superior para buscar por <strong>nombre, ciudad o servicios especÃ­ficos</strong>. Si estÃ¡s en Montevideo y buscas alguien cerca de ti, simplemente selecciona la ciudad en los filtros y te mostraremos a las chicas disponibles.</p>

<h3>3. El proceso de contacto</h3>
<p>Contactar a una escort a travÃ©s de Citasescort es directo y sin intermediarios. Una vez que encuentres un perfil que te guste:</p>
<ol>
    <li>Lee detenidamente su descripciÃ³n y las tarifas de sus servicios.</li>
    <li>Utiliza el botÃ³n verde de <strong>WhatsApp</strong> para enviarle un mensaje directo, o el botÃ³n de <strong>Llamar</strong> si prefieres escuchar su voz.</li>
    <li>SÃ© respetuoso en tu primer mensaje. Un simple <em>"Hola, vi tu perfil en Citasescort, Â¿tienes disponibilidad para hoy?"</em> es la mejor forma de empezar.</li>
</ol>

<h3>4. Seguridad y VerificaciÃ³n</h3>
<p>Sabemos que la seguridad es primordial. Por eso, los perfiles con la marca de verificaciÃ³n han pasado por nuestro control estricto, asegurÃ¡ndonos de que la persona en las fotos sea exactamente a quien conocerÃ¡s. No confÃ­es en sitios sin filtros de seguridad; en Citasescort, tu tranquilidad es nuestra garantÃ­a.</p>
',
            ],
            [
                'title' => 'Advertencias Sobre Perfiles Falsos',
                'image' => 'https://picsum.photos/800/600?random=18', // Security
                'content' => 'La seguridad de nuestros usuarios es nuestra prioridad nÃºmero uno. En Citasescort realizamos un riguroso proceso de verificaciÃ³n manual para garantizar que las fotos correspondan a las acompaÃ±antes reales. AquÃ­ te explicamos cÃ³mo identificar posibles perfiles falsos en otros sitios y por quÃ© puedes confiar en nuestro sello de verificaciÃ³n.',
            ],
            [
                'title' => 'FotografÃ­a Para Escorts',
                'image' => 'https://picsum.photos/800/600?random=19', // Camera
                'content' => 'Una buena imagen vale mÃ¡s que mil palabras, y en esta industria es tu carta de presentaciÃ³n principal. Ofrecemos servicios de fotografÃ­a profesional diseÃ±ados especÃ­ficamente para escorts. Sesiones privadas, retoque sutil y entrega rÃ¡pida para que tu perfil en Citasescort destaque sobre el resto.',
            ],
        ];

        foreach ($posts as $postData) {
            Post::updateOrCreate(
                ['title' => $postData['title']],
                [
                    'user_id' => $user->id,
                    'slug' => Str::slug($postData['title']),
                    'content' => $postData['content'] . "\n\n" . "Para mÃ¡s informaciÃ³n, no dudes en contactar con nuestro equipo de soporte.",
                    'image' => $postData['image'],
                    'is_published' => true,
                    'published_at' => now()->subDays(rand(1, 30)),
                ]
            );
        }
    }
}

