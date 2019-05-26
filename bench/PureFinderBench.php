<?php declare(strict_types=1);

/**
 * @Groups({"pure"})
 * @Revs(10000)
 * @author Ilya Zelenin <wyster@make.im>
 */
class PureFinderBench
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
        $text = $text[0];
        $pattern = '/(?:(?<account>\d{14})|\b(?<password>\d{4}\b)|(?<sum>\d+(\s?)(,?\d+))\р\.)/ui';
        preg_match_all($pattern, $text, $matches, PREG_UNMATCHED_AS_NULL);
    }

    /**
     * @ParamProviders({"data"})
     * @param array $text
     */
    public function benchMultiplePartFinder(array $text): void
    {
        $text = $text[0];
        $pattern = '/\b(?<password>\d{4}\b)/ui';
        preg_match($pattern, $text, $matches, PREG_UNMATCHED_AS_NULL);

        $pattern = '/(?<account>\d{14})/ui';
        preg_match($pattern, $text, $matches2, PREG_UNMATCHED_AS_NULL);

        $pattern = '/(?<sum>\d+(\s?)(,?\d+))\р\./ui';
        preg_match($pattern, $text, $matches3, PREG_UNMATCHED_AS_NULL);
    }
}