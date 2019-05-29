<?php declare(strict_types=1);

spl_autoload_register(static function ($class) {
    $preparedPath = str_replace('\\', DIRECTORY_SEPARATOR, $class);
    $preparedPath = str_replace('App' . DIRECTORY_SEPARATOR, '', $preparedPath);
    $fullPath = __DIR__ . '/src/' . $preparedPath . '.php';
    if (file_exists($fullPath)) {
        include $fullPath;
        return;
    }

    $preparedPath = str_replace('Test' . DIRECTORY_SEPARATOR, '', $preparedPath);
    $testsPath = __DIR__ . '/test/' . $preparedPath . '.php';
    if (file_exists($testsPath)) {
        include $testsPath;
    }
});
