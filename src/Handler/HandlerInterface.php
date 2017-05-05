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
    public function getHandledLevel(): int;

    /**
     * Checks if a log level is handled by this handler.
     * 
     * @param int $level
     * @return bool
     */
    public function isHandled(int $level): bool;

    /**
     * Process and writes a log.
     * 
     * @param array $log
     * @return HandlerInterface
     */
    public function handle(array $log): HandlerInterface;
}
