<?php

namespace ZeusTest\Log;

use Zeus\Log\Handler\AbstractHandler,
    Zeus\Log\Handler\HandlerInterface;

/**
 *
 * @author Rafael M. Salvioni
 */
class NullHandler extends AbstractHandler
{
    /**
     * 
     * @param array $log
     */
    public function handle(array $log): HandlerInterface
    {
        return $this;
    }
}
