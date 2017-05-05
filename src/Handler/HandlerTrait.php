<?php

namespace Zeus\Log\Handler;

use Zeus\Core\BitMask;

/**
 * Implements methods of HandlerInterface interface.
 *
 * @author Rafael M. Salvioni
 */
trait HandlerTrait
{
    /**
     * Handled level
     * 
     * @var int
     */
    protected $level = 0;
    
    /**
     * 
     * @return int
     */
    public function getHandledLevel(): int
    {
        return $this->level;
    }

    /**
     * 
     * @param int $level
     * @return bool
     */
    public function isHandled(int $level): bool
    {
        return BitMask::hasFlag($this->level, $level);
    }
}
