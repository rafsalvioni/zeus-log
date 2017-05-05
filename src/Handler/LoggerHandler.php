<?php

namespace Zeus\Log\Handler;

use Psr\Log\LoggerInterface;

/**
 * Adapter to a instance of \Psr\Log\LoggerInterface be a handler.
 *
 * @author Rafael M. Salvioni
 */
class LoggerHandler extends AbstractHandler
{
    /**
     * Adapted logger
     * 
     * @var LoggerInterface
     */
    private $logger;
    
    /**
     * 
     * @param LoggerInterface $logger
     * @param int|string $level
     */
    public function __construct(LoggerInterface $logger, $level = 0)
    {
        parent::__construct($level);
        $this->logger = $logger;
    }

    /**
     * 
     * @param array $log
     * @return LoggerHandler
     */
    public function handle(array $log): HandlerInterface
    {
        $level = \strtolower($log['name']);
        $this->logger->log($level, $log['message'], $log['context']);
        return $this;
    }
}
