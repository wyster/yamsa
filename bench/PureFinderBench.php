<?php declare(strict_types=1);

use Yamsa\Parser;

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

        $instance = new Parser\OnePartFinder();
        $method = new ReflectionMethod($instance, 'buildPatterns');
        $method->setAccessible(true);
        foreach ($method->invoke($instance) as $pattern) {
            preg_match_all($pattern, $text, $matches, PREG_UNMATCHED_AS_NULL);
        }
    }

    /**
     * @ParamProviders({"data"})
     * @param array $text
     */
    public function benchMultiplePartFinder(array $text): void
    {
        $text = $text[0];

        $instance = new Parser\MultiplePartsFinder();
        $method = new ReflectionMethod($instance, 'buildPatterns');
        $method->setAccessible(true);
        foreach ($method->invoke($instance) as $pattern) {
            preg_match($pattern, $text, $matches, PREG_UNMATCHED_AS_NULL);
        }
    }

    /**
     * @ParamProviders({"data"})
     * @param array $text
     */
    public function benchMultiplePartFinderMatchAll(array $text): void
    {
        $text = $text[0];

        $instance = new Parser\MultiplePartsFinderMatchAll();
        $method = new ReflectionMethod($instance, 'buildPatterns');
        $method->setAccessible(true);
        foreach ($method->invoke($instance) as $pattern) {
            preg_match_all($pattern, $text, $matches, PREG_UNMATCHED_AS_NULL);
        }
    }
}
