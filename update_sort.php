<?php
$files = [
    'app/Filament/Resources/Users/Tables/UsersTable.php',
    'app/Filament/Resources/Escorts/Tables/EscortsTable.php',
    'app/Filament/Resources/ReportResource.php',
    'app/Filament/Resources/PublicationResource.php',
    'app/Filament/Resources/PostResource.php',
    'app/Filament/Resources/PlanResource.php',
    'app/Filament/Resources/PaymentResource.php',
    'app/Filament/Resources/Escorts/RelationManagers/PublicationsRelationManager.php',
    'app/Filament/Resources/SettingResource.php',
    'app/Filament/Resources/DepartmentResource.php',
    'app/Filament/Resources/EscortResource/RelationManagers/StoriesRelationManager.php',
    'app/Filament/Resources/ContactMessageResource.php',
    'app/Filament/Resources/CityResource.php',
    'app/Filament/Resources/ActivityLogResource.php'
];

foreach ($files as $f) {
    if (file_exists($f)) {
        $c = file_get_contents($f);
        if (strpos($c, 'defaultSort') === false) {
            $c = preg_replace('/(->filters\(\[.*?\]\))/s', "$1\n            ->defaultSort('created_at', 'desc')", $c);
            file_put_contents($f, $c);
            echo "Updated $f\n";
        }
    }
}
