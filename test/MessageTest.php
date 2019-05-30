<?php declare(strict_types=1);

use App\Message;
use App\Parser\AbstractParser;
use App\Parser\OnePartFinder;
use PHPUnit\Framework\TestCase;

/**
 * @author Ilya Zelenin <wyster@make.im>
 */
class MessageTest extends TestCase
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|AbstractParser
     */
    private $parserMock;
    /**
     * @var Message
     */
    private $message;

    public function setUp(): void
    {
        parent::setUp();
        $this->parserMock = new OnePartFinder();
        $this->message = new Message($this->parserMock);
    }

    public function testAnalyze(): void
    {
        $message = <<<TEXT
Пароль: 7740
Спишется 234,18р.
Перевод на счет 41001247739481
TEXT;
        $entity = $this->message->analyze($message);

        $this->assertSame(41001247739481, $entity->getAccount());
        $this->assertSame('234.18', $entity->getSum());
        $this->assertSame(7740, $entity->getPassword());
    }
}
