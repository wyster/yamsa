<?php declare(strict_types=1);

namespace Yamsa\Parser;

/**
 * @author Ilya Zelenin <wyster@make.im>
 */
abstract class AbstractParser
{
    protected const PASSWORD_PART = '\b(?<password>\d{4,10})(?!\S)';
    protected const ACCOUNT_PART = '\b(?<account>\d{11,})(?!\S)';
    protected const SUM_PART = '(?<sum>\d+(?:[ |,](?R)|р\.))';

    /**
     * @return array
     */
    abstract protected function buildPatterns(): array;
}
