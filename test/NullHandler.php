<?php

namespace ZeusTest\Log;

use Zeus\Log\Handler\AbstractHandler;

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
    public function handle(array $log)
    {
        return $this;
    }
}
