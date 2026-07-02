<?php
require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    echo "Loading Story model...\n";
    require_once __DIR__ . '/app/Models/Story.php';
    echo "Story model loaded.\n";

    echo "Loading StoryResource...\n";
    require_once __DIR__ . '/app/Filament/Escort/Resources/StoryResource.php';
    echo "StoryResource loaded.\n";

    echo "Loading ListStories...\n";
    require_once __DIR__ . '/app/Filament/Escort/Resources/StoryResource/Pages/ListStories.php';
    echo "ListStories loaded.\n";

    $class = \App\Filament\Escort\Resources\StoryResource\Pages\ListStories::class;
    echo "Class exists: " . (class_exists($class) ? 'YES' : 'NO') . "\n";
    
    // access static property via reflection to check initialization
    $reflection = new ReflectionClass($class);
    $props = $reflection->getStaticProperties();
    echo "Resource property: " . ($props['resource'] ?? 'NOT SET') . "\n";
    
} catch (\Throwable $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}
