<?php declare(strict_types=1);

namespace Yamsa\Parser;

use InvalidArgumentException;
use function is_string;

/**
 * Альтернативная реализация, поиск несколькими регулярками
 * @author Ilya Zelenin <wyster@make.im>
 */
class MultiplePartsFinder extends AbstractParser implements ParserInterface
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
            preg_match($pattern, $text, $matches[], PREG_UNMATCHED_AS_NULL);
        }
        $matches = array_merge(...$matches);

        foreach ($matches as $field => $match) {
            if (!is_string($field)) {
                continue;
            }
            $result[$field] = $match;
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
            '/' . self::PASSWORD_PART . '/u',
            '/' . self::ACCOUNT_PART . '/u',
            '/' . self::SUM_PART . '/ui'
        ];
    }
}
