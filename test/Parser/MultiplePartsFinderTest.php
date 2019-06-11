<?php declare(strict_types=1);

namespace Yamsa\Test\Parser;

use Yamsa\Parser\MultiplePartsFinder;

/**
 * @author Ilya Zelenin <wyster@make.im>
 */
class MultiplePartsFinderTest extends AbstractParser
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
