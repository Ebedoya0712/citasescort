<?php
$content = file_get_contents('resources/views/publications/show.blade.php');
echo 'auth: ' . (substr_count($content, '@auth') - substr_count($content, '@endauth')) . "\n";
echo 'guest: ' . (substr_count($content, '@guest') - substr_count($content, '@endguest')) . "\n";
echo 'foreach: ' . (substr_count($content, '@foreach') - substr_count($content, '@endforeach')) . "\n";
echo 'if: ' . (substr_count($content, '@if') - substr_count($content, '@endif')) . "\n";
