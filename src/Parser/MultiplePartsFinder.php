<?php declare(strict_types=1);

namespace App\Parser;

use function count;
use function in_array;
use InvalidArgumentException;
use function is_string;

/**
 * @todo эта реализация остаёт от OnePartFinder, нужно актуализировать
 * Альтернативная реализация, поиск несколькими регулярками
 * @author Ilya Zelenin <wyster@make.im>
 */
class MultiplePartsFinder implements ParserInterface
{
    /**
     * @param string $text
     * @return array
     */
    public function parse(string $text): array
    {
        $result = [
            'password' => null,
            'sum' => null,
            'account' => null
        ];
        $matches = [];
        $pattern = '/\b(?<password>\d{4}\b)/ui';
        preg_match($pattern, $text, $matches, PREG_UNMATCHED_AS_NULL);

        $pattern = '/(?<account>\d{14})/ui';
        preg_match($pattern, $text, $matches2, PREG_UNMATCHED_AS_NULL);

        $pattern = '/(?<sum>\d+(\s?)(,?\d+))\р\./ui';
        preg_match($pattern, $text, $matches3, PREG_UNMATCHED_AS_NULL);

        $matches = array_merge($matches, $matches2, $matches3);
        foreach ($matches as $field => $match) {
            if (!is_string($field)) {
                continue;
            }
            $result[$field] = $match;
        }

        array_walk($result, static function(?string $value, string $field) {
            if ($value === null) {
                throw new InvalidArgumentException("Not found matches for field `${field}`");
            }
        });

        return $result;
    }
}