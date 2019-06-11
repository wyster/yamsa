<?php declare(strict_types=1);

namespace Yamsa\Test\Parser;

use PHPUnit\Framework\TestCase;

/**
 * @author Ilya Zelenin <wyster@make.im>
 */
abstract class AbstractParser extends TestCase
{
    /**
     * @return array
     */
    public function parseDataProvider(): array
    {
        return [
            [
                [
                    'password' => '7740',
                    'sum' => '234,18р.',
                    'account' => '41001247739481'
                ],
                <<<TEXT
Пароль: 7740
Спишется 234,18р.
Перевод на счет 41001247739481
TEXT
            ],
            [
                [
                    'password' => '7740',
                    'sum' => '234р.',
                    'account' => '41001247739481'
                ],
                <<<TEXT
Без мелочи
Пароль: 7740
Спишется 234р.
Перевод на счет 41001247739481
TEXT
            ],
            [
                [
                    'password' => '7740',
                    'sum' => '234,18р.',
                    'account' => '41001247739481'
                ],
                <<<TEXT
Поменял местами поля
Перевод на счет 41001247739481
Спишется 234,18р.
Пароль: 7740
TEXT
            ],
            [
                [
                    'password' => '7740',
                    'sum' => '1000р.',
                    'account' => '41001247739481'
                ],
                <<<TEXT
Сумма списания имеет 4 знака, а вдруг посчитает её паролем?
Поменял местами поля
Перевод на счет 41001247739481
Спишется 1000р.
Пароль: 7740
TEXT
            ],
            [
                [
                    'password' => '7740',
                    'sum' => '234,18р.',
                    'account' => '41001247739481'
                ],
                <<<TEXT
Яндекс вдруг решил совсем не указывать текст :)
41001247739481
234,18р.
7740
TEXT
            ],
            [
                [
                    'password' => '7740',
                    'sum' => '10 000р.',
                    'account' => '41001247739481'
                ],
                <<<TEXT
Вдруг есть пробел, на эмуляторе проверить не удалсь, там ошибка "Недостаточно средств.", или это один из сценариев?
Пароль: 7740
Спишется 10 000р.
Перевод на счет 41001247739481
TEXT
            ],
            [
                [
                    'password' => '7740',
                    'sum' => '100р.',
                    'account' => '410012477394810000000'
                ],
                <<<TEXT
В документации сказано что длина 11-20 символов, а вдруг станет 21?
Пароль: 7740
Спишется 100р.
Перевод на счет 410012477394810000000
TEXT
            ],
            [
                [
                    'password' => '7740',
                    'sum' => '10000000000000000000р.',
                    'account' => '410012477394810000000'
                ],
                <<<TEXT
Но при этом сумма перевода длинной как номер аккаунта?
Пароль: 7740
Спишется 10000000000000000000р.
Перевод на счет 410012477394810000000
TEXT
            ],
            [
                [
                    'password' => '7740',
                    'sum' => '1р.',
                    'account' => '41001247739481'
                ],
                <<<TEXT
Но при этом сумма перевода длинной как номер аккаунта?
Пароль: 7740
Спишется 1р.
Перевод на счет 41001247739481
TEXT
            ],
            [
                [
                    'password' => '7740',
                    'sum' => '5000,95р.',
                    'account' => '41001247739481'
                ],
                <<<TEXT
Но при этом сумма перевода длинной как номер аккаунта?
Пароль: 7740
Спишется 5000,95р.
Перевод на счет 41001247739481
TEXT
            ],
            [
                [
                    'password' => '7740',
                    'sum' => '500 000 000,95р.',
                    'account' => '41001247739481'
                ],
                <<<TEXT
Большая сумма с несколькими пробелами
Пароль: 7740
Спишется 500 000 000,95р.
Перевод на счет 41001247739481
TEXT
            ],
            [
                [
                    'password' => '7740',
                    'sum' => '5 000р.',
                    'account' => '41001247739481'
                ],
                <<<TEXT
Сумма с пробелом
Пароль: 7740
Спишется 5 000р.
Перевод на счет 41001247739481
TEXT
            ],
            [
                [
                    'password' => '77401',
                    'sum' => '5 000р.',
                    'account' => '41001247739481'
                ],
                <<<TEXT
Пароль вдруг стал больше 4х символов, не страшно вроде? Главное чтобы не как длина кошелька)
Пароль: 77401
Спишется 5 000р.
Перевод на счет 41001247739481
TEXT
            ],
            [
                [
                    'password' => '0123456789',
                    'sum' => '5 000р.',
                    'account' => '41001247739481'
                ],
                <<<TEXT
Пароль вдруг стал больше 4х символов, не страшно вроде? Главное чтобы не как длина кошелька)
Пароль: 0123456789
Спишется 5 000р.
Перевод на счет 41001247739481
TEXT
            ]
        ];
    }
}
