<?php declare(strict_types=1);

namespace Yamsa\Factory;

use Yamsa;

/**
 * @author Ilya Zelenin <wyster@make.im>
 */
class Analyzer
{
    /**
     * @return Yamsa\Analyzer
     */
    public static function create(): Yamsa\Analyzer
    {
        return new Yamsa\Analyzer(new Yamsa\Parser\OnePartFinder());
    }
}
