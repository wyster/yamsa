Требуется php версии >= 7.3

Пример использования с несколькими сценариями можно найти в `example.php`

Запуск: `php example.php`

Тесты: `./phpunit.phar ./test --bootstrap=autoload.php`

Бенчмарки различных вариантов регулярки: `./phpbench.phar run bench/ParserBench.php --report=aggregate`