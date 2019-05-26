<?php declare(strict_types=1);

namespace App\Parser;

use function count;
use function in_array;
use InvalidArgumentException;
use function is_string;

/**
 * @todo много копипаста между парсарми
 * Поиск всех совпадений одной регуляркой
 * @author Ilya Zelenin <wyster@make.im>
 */
class OnePartFinder implements ParserInterface
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
        $pattern = '/(?:(?<account>\b\d{11,})\b|(?<password>\d{4}\b)|(?<sum>\d+(\s?)(,?(\d+)?))\р\.)/ui';
        preg_match_all($pattern, $text, $matches, PREG_UNMATCHED_AS_NULL);
        foreach ($matches as $field => $match) {
            if (!is_string($field)) {
                continue;
            }
            $match = array_filter($match, 'is_string');
            // Что то не так, не нашли даже одного вхождения
            if (count($match) === 0) {
                throw new InvalidArgumentException("Not found matches for field `${field}`");
            }
            // Что то не так, по плану найти по одному вхождению
            if (count($match) > 1) {
                throw new InvalidArgumentException("Too many matches for field `${field}`");
            }
            $value = array_values($match)[0];
            $result[$field] = $value;
        }

        return $result;
    }
}