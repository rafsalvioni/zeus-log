<?php

namespace ZeusTest\Log;

/**
 * Generic Psr Logger.
 *
 * @author Rafael M. Salvioni
 */
class PsrLogger implements \Psr\Log\LoggerInterface
{
    use \Psr\Log\LoggerTrait;
    
    /**
     * 
     * @param type $level
     * @param type $message
     * @param array $context
     */
    public function log($level, $message, array $context = array())
    {
        echo "[$level]:$message";
    }
}
