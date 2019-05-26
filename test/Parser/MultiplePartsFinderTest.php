<?php declare(strict_types=1);

namespace App\Parser;

use PHPUnit\Framework\TestCase;

/**
 * @author Ilya Zelenin <wyster@make.im>
 */
class MultiplePartsFinderTest extends TestCase
{
    /**
     * @var MultiplePartsFinder
     */
    private $parser;

    public function setUp(): void
    {
        parent::setUp();
        $this->parser = new MultiplePartsFinder();
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
            ]
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
            /*[
                // Невозможно узнать в этом случае, ищет одиночное совпадение
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
            ]*/
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
}
