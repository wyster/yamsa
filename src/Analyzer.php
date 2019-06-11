<?php declare(strict_types=1);

namespace Yamsa;

use Yamsa\Parser\ParserInterface;

/**
 * @author Ilya Zelenin <wyster@make.im>
 */
class Analyzer
{
    /**
     * @var ParserInterface
     */
    private $parser;

    /**
     * @param ParserInterface $parser
     */
    public function __construct(ParserInterface $parser)
    {
        $this->parser = $parser;
    }

    /**
     * @return ParserInterface
     */
    protected function getParser(): ParserInterface
    {
        return $this->parser;
    }

    /**
     * @param string $message
     * @return Entity
     */
    public function run(string $message): Entity
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
