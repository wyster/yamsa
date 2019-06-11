<?php declare(strict_types=1);

ini_set('display_errors', 'On');
error_reporting(-1);

require __DIR__ . '/autoload.php';

$message = new \Yamsa\Analyzer(new \Yamsa\Parser\OnePartFinder());

$messages = [
    1 => <<<TEXT
Пароль: 7740
Спишется 234,18р.
Перевод на счет 41001247739481
TEXT
    ,
    <<<TEXT
Без мелочи
Пароль: 7740
Спишется 234р.
Перевод на счет 41001247739481
TEXT
    ,
    <<<TEXT
Поменял местами поля
Перевод на счет 41001247739481
Спишется 234,18р.
Пароль: 7740
TEXT
    ,
    <<<TEXT
Сумма списания имеет 4 знака, а вдруг посчитает её паролем?
Поменял местами поля
Перевод на счет 41001247739481
Спишется 1000р.
Пароль: 7740
TEXT
    ,
    <<<TEXT
Яндекс вдруг решил совсем не указывать текст :)
41001247739481
234,18р.
7740
TEXT
    ,
    // Должно падать с ошибкой
    <<<TEXT
Нехватает одного из полей
Пароль: 7740
Спишется 234,18р.
TEXT
    ,
    // Должно падать с ошибкой
    <<<TEXT
Ожидаем по одному варианту каждого поля
41001247739481
234,18р.
7740
41001247739481
234,18р.
7740'
TEXT
];

foreach ($messages as $i => $text) {
    try {
        echo "output {$i}\n";
        echo "\ntext:\n";
        print_r($text);
        echo PHP_EOL;
        echo 'result:';
        echo PHP_EOL;
        $result = $message->run($text);
        print_r($result);
    } catch (Exception $e) {
        echo "error {$e->getMessage()}";
    }
    echo PHP_EOL;
    echo PHP_EOL;
}
