<?php

namespace Zeus\Log\Handler;

use Zeus\Core\BitMask;

/**
 * Implements a handler chain.
 *
 * @author Rafael M. Salvioni
 */
class HandlerChain implements HandlerInterface
{
    use HandlerTrait;
    
    /**
     * Stores the handlers
     * 
     * @var HandlerInterface[]
     */
    private $handlers = [];
    /**
     * Allow bubbling?
     * 
     * @var bool
     */
    private $bubbling = false;
    
    /**
     * 
     * @param bool $bubbling Allow bubbling logs?
     */
    public function __construct($bubbling = false)
    {
        $this->isBubbling($bubbling);
    }

    /**
     * Attach a logger handler on the end of list.
     * 
     * @param HandlerInterface $handler
     * @return self
     */
    public function pushHandler(HandlerInterface $handler)
    {
        $this->handlers[] = $handler;
        $this->level      = BitMask::addFlag(
                                $this->level,
                                $handler->getHandledLevel()
                            );
        return $this;
    }
    
    /**
     * Returns / sets the bubbling mode.
     * 
     * @param bool $set Bubbling?
     * @return bool
     */
    public function isBubbling($set = null)
    {
        if (!\is_null($set)) {
            $this->bubbling = (bool)$set;
        }
        return $this->bubbling;
    }

    /**
     * 
     * @param array $log
     * @return self
     */
    public function handle(array $log)
    {
        foreach ($this->handlers as &$handler) {
            if (!isset($log['level']) || !$handler->isHandled($log['level'])) {
                continue;
            }
            try {
                $handler->handle($log);
                if (!$this->bubbling) {
                    break;
                }
            }
            catch (\Exception $ex) {
                continue;
            }
        }
        return $this;
    }
}
