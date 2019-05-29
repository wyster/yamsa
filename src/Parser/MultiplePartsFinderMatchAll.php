<?php declare(strict_types=1);

namespace App\Parser;

use function count;
use function in_array;
use InvalidArgumentException;
use function is_string;

/**
 * Альтернативная реализация, поиск несколькими регулярками с preg_match_all
 * @author Ilya Zelenin <wyster@make.im>
 */
class MultiplePartsFinderMatchAll extends AbstractParser implements ParserInterface
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
        /**
         * @var array<array> $matches
         */
        $matches = [];
        foreach ($this->buildPatterns() as $pattern) {
            preg_match_all($pattern, $text, $matches[], PREG_UNMATCHED_AS_NULL);
        }
        $matches = array_merge(...$matches);
        foreach ($matches as $field => $match) {
            if (!is_string($field)) {
                continue;
            }
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

        array_walk($result, static function (?string $value, string $field) {
            if ($value === null) {
                throw new InvalidArgumentException("Not found matches for field `${field}`");
            }
        });

        return $result;
    }

    /**
     * @return array
     */
    protected function buildPatterns(): array
    {
        return [
            '/'. self::PASSWORD_PART .'/u',
            '/'. self::ACCOUNT_PART .'/u',
            '/'. self::SUM_PART .'/ui'
        ];
    }
}
