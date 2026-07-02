<?php
echo "<h1>Diagnostic Info</h1>";
echo "<strong>PHP Version:</strong> " . phpversion() . "<br>";
echo "<strong>Loaded INI:</strong> " . php_ini_loaded_file() . "<br>";
echo "<strong>INTL Loaded:</strong> " . (extension_loaded('intl') ? 'YES ✅' : 'NO ❌') . "<br>";

if (!extension_loaded('intl')) {
    echo "<h3>Extensions Directory</h3>";
    echo ini_get('extension_dir');
    echo "<h3>Loaded Extensions</h3>";
    echo implode(', ', get_loaded_extensions());
}

echo "<h3>PHP Info (Modules)</h3>";
phpinfo(INFO_MODULES);
