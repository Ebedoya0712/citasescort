$env:Path = "C:\xampp\php;C:\xampp\apache\bin;" + $env:Path
Write-Host "Iniciando servidor (Normal mode)..."
Write-Host "Verificando extension Intl en CLI:"
& "C:\xampp\php\php.exe" -r "echo 'CLI Intl Status: ' . (extension_loaded('intl') ? 'OK' : 'FAIL') . PHP_EOL;"

& "C:\xampp\php\php.exe" -d upload_max_filesize=100M -d post_max_size=100M -d memory_limit=512M -S 127.0.0.1:8080 -t public
