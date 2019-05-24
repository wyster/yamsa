<?php declare(strict_types=1);

namespace App;
/**
 * @author Ilya Zelenin <wyster@make.im>
 */
class Entity
{
    /**
     * @var string
     */
    private $sum;

    /**
     * @var int
     */
    private $password;

    /**
     * @var int
     */
    private $account;

    /**
     * @return string
     */
    public function getSum(): string
    {
        return $this->sum;
    }

    /**
     * @param string $sum
     */
    public function setSum(string $sum): void
    {
        $this->sum = $sum;
    }

    /**
     * @return int
     */
    public function getPassword(): int
    {
        return $this->password;
    }

    /**
     * @param int $password
     */
    public function setPassword(int $password): void
    {
        $this->password = $password;
    }

    /**
     * @return int
     */
    public function getAccount(): int
    {
        return $this->account;
    }

    /**
     * @param int $account
     */
    public function setAccount(int $account): void
    {
        $this->account = $account;
    }
}