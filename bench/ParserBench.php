<?php declare(strict_types=1);

use App\Parser;

/**
 * @Groups({"parser"})
 * @Revs(10000)
 * @author Ilya Zelenin <wyster@make.im>
 */
class ParserBench
{
    /**
     * @return array
     */
    public function data(): array
    {
        return [
            [<<<TEXT
Пароль: 7740
Спишется 234,18р.
Перевод на счет 41001247739481
TEXT
            ]
        ];
    }

    /**
     * @ParamProviders({"data"})
     * @param array $text
     */
    public function benchOnePartFinder(array $text): void
    {
        (new Parser\OnePartFinder())->parse($text[0]);
    }

    /**
     * @ParamProviders({"data"})
     * @param array $text
     */
    public function benchMultiplePartsFinder(array $text): void
    {
        (new Parser\MultiplePartsFinder())->parse($text[0]);
    }

    /**
     * @ParamProviders({"data"})
     * @param array $text
     */
    public function benchMultiplePartsFinderMatchAll(array $text): void
    {
        (new Parser\MultiplePartsFinderMatchAll())->parse($text[0]);
    }
}