<?php

namespace Zeus\Log\Handler;

use Zeus\Log\Level;

/**
 * Abstract handler.
 *
 * @author Rafael M. Salvioni
 */
abstract class AbstractHandler implements HandlerInterface
{
    use HandlerTrait;
    
    /**
     * 
     * @param int|string $level Handled level
     */
    public function __construct($level = 0)
    {
        $this->level = Level::toLevel($level);
    }
}
