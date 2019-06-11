<?php declare(strict_types=1);

spl_autoload_register(static function ($class) {
    $preparedPath = str_replace('\\', DIRECTORY_SEPARATOR, $class);
    $preparedPath = str_replace('Yamsa' . DIRECTORY_SEPARATOR, '', $preparedPath);
    $fullPath = __DIR__ . '/src/' . $preparedPath . '.php';
    if (file_exists($fullPath)) {
        include $fullPath;
        return;
    }
});
