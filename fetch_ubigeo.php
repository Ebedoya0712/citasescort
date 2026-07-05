<?php

$depsUrl = 'https://raw.githubusercontent.com/joseluisq/ubigeos-peru/master/json/departamentos.json';
$provsUrl = 'https://raw.githubusercontent.com/joseluisq/ubigeos-peru/master/json/provincias.json';
$distsUrl = 'https://raw.githubusercontent.com/joseluisq/ubigeos-peru/master/json/distritos.json';

echo "Fetching departments...\n";
$deps = json_decode(file_get_contents($depsUrl), true);
echo "Fetching provinces...\n";
$provs = json_decode(file_get_contents($provsUrl), true);
echo "Fetching districts...\n";
$dists = json_decode(file_get_contents($distsUrl), true);

$cleanTree = [];

foreach ($deps as $dep) {
    $depId = $dep['id_ubigeo'];
    $depName = $dep['nombre_ubigeo'];
    
    $cleanTree[$depName] = [];
    
    if (isset($provs[$depId])) {
        foreach ($provs[$depId] as $prov) {
            $provId = $prov['id_ubigeo'];
            $provName = $prov['nombre_ubigeo'];
            
            $cleanTree[$depName][$provName] = [];
            
            if (isset($dists[$provId])) {
                foreach ($dists[$provId] as $dist) {
                    $distName = $dist['nombre_ubigeo'];
                    $cleanTree[$depName][$provName][] = $distName;
                }
            }
        }
    }
}

// Add Callao as its own department since it is missing from joseluisq/ubigeos-peru
$cleanTree['Callao'] = [
    'Callao' => [
        'Bellavista',
        'Callao',
        'Carmen de la Legua Reynoso',
        'La Perla',
        'La Punta',
        'Mi Perú',
        'Ventanilla'
    ]
];

// Sort departments alphabetically
ksort($cleanTree);

file_put_contents('storage/app/peru-locations.json', json_encode($cleanTree, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
echo "Done! Saved " . count($cleanTree) . " departments to storage/app/peru-locations.json\n";
