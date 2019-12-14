[![Build Status](https://travis-ci.org/wyster/yamsa.svg?branch=master)](https://travis-ci.org/wyster/yamsa)
[![Coverage Status](https://coveralls.io/repos/github/wyster/yamsa/badge.svg)](https://coveralls.io/github/wyster/yamsa)

Требуется php версии >= 7.2

Установка через [Composer](https://getcomposer.org/):
```
$ composer require wyster/yamsa
```

Пример использования:

```
<?php

use Yamsa\Factory\Analyzer;

require __DIR__ . '/vendor/autoload.php';

$analyzer = Analyzer::create();
$message = <<<TEXT
Пароль: 7740
Спишется 234,18р.
Перевод на счет 41001247739481
TEXT;

print_r($analyzer->run($message)); //=> Yamsa\Entity Object
```

Результат:
```
Yamsa\Entity Object
(
    [sum:Yamsa\Entity:private] => 234.18 // string
    [password:Yamsa\Entity:private] => 7740 // integer
    [account:Yamsa\Entity:private] => 41001247739481 // integer
)
```

Запуск тестов:

`composer test`

Покрытие (нужен xdebug)

`composer coverage`
