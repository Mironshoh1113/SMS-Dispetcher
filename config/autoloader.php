<?php

if (!isset($_SESSION)) {
    session_start();
}

// Autoloader funksiyasi
spl_autoload_register(function ($class) {
    $paths = ['models', 'controllers', 'config'];
    foreach ($paths as $path) {
        $file = __DIR__ . "/../$path/$class.php";
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

