<?php declare(strict_types=1);

namespace Yamsa\Helper;

/**
 * @author Ilya Zelenin <wyster@make.im>
 */
class Preparer
{
    /**
     * @codeCoverageIgnore
     * @return self
     */
    public static function create(): self
    {
        return new self();
    }

    /**
     * @param array<string> $result
     * @return array
     */
    public function prepareTypes(array $result): array
    {
        $sum = str_replace([',', ' ', 'р.'], ['.', '', ''], $result['sum']);
        $account = (int)$result['account'];
        $password = (int)$result['password'];

        return compact('sum', 'account', 'password');
    }
}
