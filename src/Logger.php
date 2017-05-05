<?php

namespace Zeus\Log;

use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Zeus\Log\Handler\HandlerInterface;
use Zeus\Core\BitMask;
use Zeus\Event\EmitterInterface;
use Zeus\Event\EmitterTrait;

/**
 * Implements a logger compatible with Psr.
 * 
 * Its possible to attach many handlers to write logs on different sources.
 * Each handler accept one or more log levels, allowing route logs according
 * your level.
 *
 * @author Rafael M. Salvioni
 * @event [level_name::lower] When a log level will be handled
 * @event log When a any log will be handled
 * @event unhandled When a log will not be handled by current handler and it was dismissed
 * @event unknown When a log is unkown and dismissed
 */
class Logger implements LoggerInterface, EmitterInterface
{
    use EmitterTrait;
    
    /**
     * Stores the default logger
     * 
     * @var LoggerInterface
     */
    private static $default;
    /**
     * Store the log handler
     * 
     * @var HandlerInterface
     */
    private $handler;
    /**
     * Stores the filters
     * 
     * @var callback[]
     */
    private $filters = [];
    
    /**
     * Set the default logger.
     * 
     * @param LoggerInterface $logger
     */
    public static function setDefault(LoggerInterface $logger)
    {
        self::$default = $logger;
    }
    
    /**
     * Returns the default logger.
     * 
     * @return LoggerInterface
     */
    public static function getDefault(): LoggerInterface
    {
        if (empty(self::$default)) {
            self::$default = new NullLogger();
        }
        return self::$default;
    }
    
    /**
     * Allows call the default logger methods statically.
     * 
     * @param string $method
     * @param array $args
     * @return mixed
     */
    public static function __callStatic(string $method, array $args)
    {
        return \call_user_func_array([self::getDefault(), $method], $args);
    }
    
    /**
     * 
     * @param HandlerInterface $handler
     * @param bool $default Set the instance as default logger?
     */
    public function __construct(HandlerInterface $handler, bool $default = false)
    {
        if ($default || empty(self::$default)) {
            self::setDefault($this);
        }
        $this->setHandler($handler);
    }

    /**
     * Define the logger handler.
     * 
     * @param HandlerInterface $handler
     * @return Logger
     */
    public function setHandler(HandlerInterface $handler): Logger
    {
        $this->handler = $handler;
        return $this;
    }

    /**
     * Returns the logger handler.
     * 
     * @return HandlerInterface
     */
    public function getHandler(): HandlerInterface
    {
        return $this->handler;
    }

    /**
     * Attach a logger filter on the end of list.
     * 
     * @param callable $filter
     * @return Logger
     */
    public function pushFilter(callable $filter): Logger
    {
        $this->filters[] = $filter;
        return $this;
    }
    
    /**
     * Dettach a logger filter from the and of list and return it.
     * 
     * @return callable
     */
    public function popFilter(): callable
    {
        return \array_pop($this->filters);
    }

    /**
     * 
     * @param int|string $level
     * @param string $message
     * @param array $context
     * @return Logger
     */
    public function log($level, $message, array $context = array())
    {
        // Converting Psr\LogLevel to int
        $level = Level::toLevel($level);
        
        // Level is unknown? Stop
        if (!Level::is($level)) {
            $this->emit('unknown', $level, $message);
            return $this;
        }
        
        // If $level is a mask, explode it!
        if (!BitMask::isSingleFlag($level)) {
            $me = __FUNCTION__;
            foreach (BitMask::maskToFlags($level) as $flag) {
                $this->$me($flag, $message, $context);
            }
            return $this;
        }
        else if (!$this->handler->isHandled($level)) {
            $this->emit('unhandled', $level, $message);
            return $this;
        }
        
        // Make log struct
        $log = [
            'level'     => $level,
            'name'      => Level::getLevelName($level),
            'message'   => $message,
            'context'   => $context,
            'timestamp' => \microtime(true),
            'extra'     => [],
        ];
        
        // Iterate the filters
        foreach ($this->filters as &$filter) {
            $log = $filter($log);
        }
        
        $this->emit('log', $log);        
        $this->emit(\strtolower($log['name']), $log);
        
        // Call handler
        $this->handler->handle($log);
        
        return $this;
    }

    /**
     * 
     * @param string $message
     * @param array $context
     * @return self
     */
    public function alert($message, array $context = array())
    {
        return $this->log(Level::ALERT, $message, $context);
    }

    /**
     * 
     * @param string $message
     * @param array $context
     * @return self
     */
    public function critical($message, array $context = array())
    {
        return $this->log(Level::CRITICAL, $message, $context);
    }

    /**
     * 
     * @param string $message
     * @param array $context
     * @return self
     */
    public function debug($message, array $context = array())
    {
        return $this->log(Level::DEBUG, $message, $context);
    }

    /**
     * 
     * @param string $message
     * @param array $context
     * @return self
     */
    public function emergency($message, array $context = array())
    {
        return $this->log(Level::EMERGENCY, $message, $context);
    }

    /**
     * 
     * @param string $message
     * @param array $context
     * @return self
     */
    public function error($message, array $context = array())
    {
        return $this->log(Level::ERROR, $message, $context);
    }

    /**
     * 
     * @param string $message
     * @param array $context
     * @return self
     */
    public function info($message, array $context = array())
    {
        return $this->log(Level::INFO, $message, $context);
    }

    /**
     * 
     * @param string $message
     * @param array $context
     * @return self
     */
    public function notice($message, array $context = array())
    {
        return $this->log(Level::NOTICE, $message, $context);
    }

    /**
     * 
     * @param string $message
     * @param array $context
     * @return self
     */
    public function warning($message, array $context = array())
    {
        return $this->log(Level::WARNING, $message, $context);
    }
}
