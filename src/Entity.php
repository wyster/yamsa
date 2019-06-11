<?php declare(strict_types=1);

namespace Yamsa;

/**
 * @author Ilya Zelenin <wyster@make.im>
 */
class Entity
{
    /**
     * @var string|null
     */
    private $sum = '';

    /**
     * @var int|null
     */
    private $password;

    /**
     * @var int|null
     */
    private $account;

    /**
     * @return string|null
     */
    public function getSum(): ?string
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
     * @return int|null
     */
    public function getPassword(): ?int
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
     * @return int|null
     */
    public function getAccount(): ?int
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
