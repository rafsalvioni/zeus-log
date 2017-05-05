<?php

namespace ZeusTest\Log;

use Zeus\Log\Handler\AbstractHandler,
    Zeus\Log\Handler\HandlerInterface;

/**
 *
 * @author Rafael M. Salvioni
 */
class GenericHandler extends AbstractHandler
{
    /**
     * Last log record handled by this handler
     * 
     * @var array
     */
    public $lastLog;
    
    /**
     * 
     * @param array $log
     */
    public function handle(array $log): HandlerInterface
    {
        $this->lastLog = $log;
        echo \sprintf('[%s]: %s', $log['name'], $log['message']) . \PHP_EOL;
        return $this;
    }
}
