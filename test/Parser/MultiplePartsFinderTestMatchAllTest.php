<?php declare(strict_types=1);

namespace Test\Parser;

use App\Parser\MultiplePartsFinderMatchAll;

/**
 * @author Ilya Zelenin <wyster@make.im>
 */
class MultiplePartsFinderTestMatchAllTest extends AbstractParser
{
    /**
     * @var MultiplePartsFinderMatchAll
     */
    private $parser;

    public function setUp(): void
    {
        parent::setUp();
        $this->parser = new MultiplePartsFinderMatchAll();
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
}
