<?php declare(strict_types=1);

namespace App;
use App\Helper\Preparer;

/**
 * @author Ilya Zelenin <wyster@make.im>
 */
class Message
{
    /**
     * @var Parser
     */
    private $parser;

    /**
     * @param Parser $parser
     */
    public function __construct(Parser $parser)
    {
        $this->parser = $parser;
    }

    /**
     * @return Parser
     */
    public function getParser(): Parser
    {
        return $this->parser;
    }

    /**
     * @param string $message
     * @return Entity
     */
    public function analyze(string $message): Entity
    {
        $parsed = $this->getParser()->parse($message);

        $results = Helper\Preparer::create()->prepareTypes($parsed);
        $entity = new Entity();
        $entity->setAccount($results['account']);
        $entity->setPassword($results['password']);
        $entity->setSum($results['sum']);

        return $entity;
    }
}