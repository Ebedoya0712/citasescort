<?php

$replacements = [
    'aÃ±os' => 'años',
    'mÃ¡s' => 'más',
    'UbicaciÃ³n' => 'Ubicación',
    'FantasÃ­as' => 'Fantasías',
    'AÃºn' => 'Aún',
    'pÃºblicamente' => 'públicamente',
    'tenÃ©s' => 'tenés',
    'CuÃ©ntanos' => 'Cuéntanos',
    'SÃ©' => 'Sé',
    'sÃ³lo' => 'sólo',
    'PodÃ©s' => 'Podés',
    'Ãºltimas' => 'últimas',
    'SuscripciÃ³n' => 'Suscripción',
    'Â¡Tu' => '¡Tu',
    'MÃ©todo' => 'Método',
    'TransacciÃ³n' => 'Transacción',
    'VÃ¡lido' => 'Válido',
    'pÃ¡gina' => 'página',
    'AtenciÃ³n' => 'Atención',
    'automÃ¡ticamente' => 'automáticamente',
    'electrÃ³nico' => 'electrónico',
    'â€¢' => '•',
    'â€' => '•'
];

$dir = new RecursiveDirectoryIterator(__DIR__ . '/resources/views');
$ite = new RecursiveIteratorIterator($dir);
$files = new RegexIterator($ite, '/.*\.blade\.php$/', RegexIterator::GET_MATCH);

$count = 0;
foreach ($files as $file) {
    $path = $file[0];
    $content = file_get_contents($path);
    $original = $content;
    
    foreach ($replacements as $bad => $good) {
        $content = str_replace($bad, $good, $content);
    }
    
    if ($original !== $content) {
        file_put_contents($path, $content);
        echo "Fixed: $path\n";
        $count++;
    }
}

echo "Total files fixed: $count\n";
