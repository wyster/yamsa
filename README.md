[![Build Status](https://travis-ci.org/wyster/yandex-money-sms-parser.svg?branch=master)](https://travis-ci.org/wyster/yandex-money-sms-parser)
[![Coverage Status](https://coveralls.io/repos/github/wyster/yandex-money-sms-parser/badge.svg)](https://coveralls.io/github/wyster/yandex-money-sms-parser)

Требуется php версии >= 7.2

Установка через [Composer](https://getcomposer.org/):
```
composer require wyster/yamsa
```

Пример использования:

```
<?php 
require __DIR__ . '/vendor/autoload.php';
 
$analyzer = \Yamsa\Factory\Analyzer::create();
$message = <<<TEXT
Пароль: 7740
Спишется 234,18р.
Перевод на счет 41001247739481
TEXT;

print_r($analyzer->run($message)); //=> Yamsa\Entity Object
```

Вывод:
```
Yamsa\Entity Object
(
    [sum:Yamsa\Entity:private] => 234.18
    [password:Yamsa\Entity:private] => 7740
    [account:Yamsa\Entity:private] => 41001247739481
)
```
