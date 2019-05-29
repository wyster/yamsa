<?php declare(strict_types=1);

namespace App\Parser;

/**
 * @author Ilya Zelenin <wyster@make.im>
 */
interface ParserInterface
{
    /**
     * @param string $text
     * @return array
     */
    public function parse(string $text): array;
}
