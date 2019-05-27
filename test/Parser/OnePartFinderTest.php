<?php declare(strict_types=1);

namespace App\Parser;

use PHPUnit\Framework\TestCase;

/**
 * @todo много копипаста между тестами
 * @author Ilya Zelenin <wyster@make.im>
 */
class OnePartFinderTest extends TestCase
{
    /**
     * @var OnePartFinder
     */
    private $parser;

    public function setUp(): void
    {
        parent::setUp();
        $this->parser = new OnePartFinder();
    }

    /**
     * @return array
     */
    public function parseDataProvider(): array
    {
        return [
            [
                [
                    'password' => '7740',
                    'sum' => '234,18',
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
                    'sum' => '234',
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
                    'sum' => '234,18',
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
                    'sum' => '1000',
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
                    'sum' => '234,18',
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
                    'sum' => '10 000',
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
                    'sum' => '100',
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
                    'sum' => '10000000000000000000',
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
                    'sum' => '1',
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
                    'sum' => '5000,95',
                    'account' => '41001247739481'
                ],
                <<<TEXT
Но при этом сумма перевода длинной как номер аккаунта?
Пароль: 7740
Спишется 5000,95р.
Перевод на счет 41001247739481
TEXT
            ],
            // @todo такие сценарии нельзя исключать, подумать как их учесть
            /*[
                [
                    'password' => '7740',
                    'sum' => '50000000,95',
                    'account' => '41001247739481'
                ],
                <<<TEXT
Большая сумма с несколькими пробелами
Пароль: 7740
Спишется 500 00 000,95р.
Перевод на счет 41001247739481
TEXT
            ],
            [
                [
                    'password' => '7740',
                    'sum' => '5 000,95',
                    'account' => '41001247739481'
                ],
                <<<TEXT
Большая сумма с несколькими пробелами
Пароль: 7740
Спишется 5 000,95р.
Перевод на счет 41001247739481
TEXT
            ],*/
        ];
    }

    /**
     * @dataProvider parseDataProvider
     * @param array $expected
     * @param string $message
     */
    public function testParse(array $expected, string $message): void
    {
        $this->assertSame($expected, $this->parser->parse($message));
    }

    /**
     * @return array
     */
    public function parseDataProviderException(): array
    {
        return [
            [
                '/Not found matches for field/',
                <<<TEXT
Нехватает одного из полей
Пароль: 7740
Спишется 234,18р.
TEXT
            ],
            [
                '/Too many matches for field/',
                <<<TEXT
Ожидаем по одному варианту каждого типа
41001247739481
234,18р.
7740
41001247739481
234,18р.
7740
TEXT
            ]
        ];
    }

    /**
     * @dataProvider parseDataProviderException
     * @param string $exceptionMessage
     * @param string $message
     */
    public function testParseExceptions(string $exceptionMessage, string $message): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessageRegExp($exceptionMessage);
        $this->parser->parse($message);
    }

    /**
     * @return array
     */
    public function accountSizeDataProvider(): array
    {
        $randomNumber = static function (int $length) {
            $result = '';

            for($i = 0; $i < $length; $i++) {
                $result .= random_int(0, 9);
            }

            return $result;
        };

        $result = [];
        foreach (range(11, 20) as $i) {
            $result[] = [$randomNumber($i)];
        }

        return $result;
    }

    /**
     * @dataProvider accountSizeDataProvider
     * @param string $account
     */
    public function testAccountSize(string $account): void
    {
        $message = <<<TEXT
Пароль: 7740
Спишется 234,18р.
Перевод на счет {$account}
TEXT;
        $this->assertSame($account, $this->parser->parse($message)['account']);
    }
}
