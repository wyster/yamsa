<?php declare(strict_types=1);

namespace App\Helper;

/**
 * @author Ilya Zelenin <wyster@make.im>
 */
class Preparer
{
    /**
     * @return self
     */
    public static function create(): self
    {
        return new self();
    }

    /**
     * @param array $result
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
