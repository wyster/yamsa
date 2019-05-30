<?php declare(strict_types=1);

namespace Test;

use App\Helper\Preparer;
use PHPUnit\Framework\TestCase;

/**
 * @author Ilya Zelenin <wyster@make.im>
 */
class PreparerTest extends TestCase
{
    /**
     * @var Preparer
     */
    private $preparer;

    public function setUp(): void
    {
        parent::setUp();
        $this->preparer = new Preparer();
    }

    /**
     * @return array
     */
    public function prepareTypesDataProvider(): array
    {
        return [
            [
                [
                    'password' => 7740,
                    'sum' => '10000.50',
                    'account' => 41001247739481
                ],
                [
                    'password' => '7740',
                    'sum' => '10 000,50р.',
                    'account' => '41001247739481'
                ]
            ]
        ];
    }

    /**
     * @dataProvider prepareTypesDataProvider
     * @param array $expected
     * @param array $values
     */
    public function testPrepareTypes(array $expected, array $values): void
    {
        sort($expected);
        $result = $this->preparer->prepareTypes($values);
        sort($result);
        $this->assertSame($expected, $result);
    }
}
