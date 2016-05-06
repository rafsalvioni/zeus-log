<?php

namespace Zeus\Log\Handler;

/**
 * Identifies a Log handler.
 * 
 * @author Rafael M. Salvioni
 */
interface HandlerInterface
{
    /**
     * Returns the log level handled by this handler.
     * 
     * @return int
     */
    public function getHandledLevel();

    /**
     * Checks if a log level is handled by this handler.
     * 
     * @param int $level
     * @return bool
     */
    public function isHandled($level);

    /**
     * Process and writes a log.
     * 
     * @param array $log
     * @return bool
     */
    public function handle(array $log);
}
