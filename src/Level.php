<?php

namespace Zeus\Log;

use Zeus\Core\BitMask;

/**
 * Manages the log levels.
 *
 * @author Rafael M. Salvioni
 */
final class Level
{
    /**
     * 
     */
    const EMERGENCY = 1;
    /**
     * 
     */
    const ALERT     = 2;
    /**
     * 
     */
    const CRITICAL  = 4;
    /**
     * 
     */
    const ERROR     = 8;
    /**
     * 
     */
    const WARNING   = 16;
    /**
     * 
     */
    const NOTICE    = 32;
    /**
     * 
     */
    const INFO      = 64;
    /**
     * 
     */
    const DEBUG     = 128;
    
    /**
     * Returns the list of levels registered, indexed by level name.
     * 
     * @return array
     */
    public static function listLevels()
    {
        static $list = [];
        if (empty($list)) {
            $list = (new \ReflectionClass(__CLASS__))->getConstants();
        }
        return $list;
    }
    
    /**
     * Converts a value to a level value.
     * 
     * If value is unknown, returns 0.
     * 
     * @param mixed $value
     * @return int
     */
    public static function toLevel($value)
    {
        $level = 0;
        
        switch (true) {
            case \is_number($value):
            case \is_numeric($value):
                $level = (int)$value;
                break;
            default:
                $const = self::class . '::' . \strtoupper($value);
                if (\defined($const)) {
                    $level = \constant($const);
                }
        }
        
        return $level;
    }
    
    /**
     * Returns the level name by its value.
     * 
     * If a value is unknown, returns null.
     * 
     * @param int $level
     * @return string
     */
    public static function getLevelName($level)
    {
        $list = \array_flip(static::listLevels());
        return \array_get($list, $level);
    }
    
    /**
     * Checks if a integer represents one or more log levels.
     * 
     * @param int $level
     * @return bool
     */
    public static function is($level)
    {
        return self::maskAll()->has($level);
    }
    
    /**
     * Returns a bitmask with all log levels registered.
     * 
     * @return BitMask
     */
    public static function maskAll()
    {
        static $mask = null;
        if (\is_null($mask)) {
            $mask = new BitMask();
            foreach (static::listLevels() as $level) {
                $mask->add($level);
            }
        }
        return clone $mask;
    }
    
    /**
     * Returns a bitmask with lower log levels.
     * 
     * Are considered lower levels: DEBUG, INFO, WARNING and NOTICE.
     * 
     * @return BitMask
     */
    public static function maskLower()
    {
        static $mask = null;
        if (empty($mask)) {
            $mask = self::maskAll()
                    ->remove(self::ALERT)
                    ->remove(self::CRITICAL)
                    ->remove(self::EMERGENCY)
                    ->remove(self::ERROR);
        }
        return clone $mask;
    }
    
    /**
     * Returns a bitmask with higher log levels.
     * 
     * Are considered lower levels: ALERT, CRITICAL, EMERGENCY and ERROR.
     * 
     * @return BitMask
     */
    public static function maskHigher()
    {
        static $mask = null;
        if (empty($mask)) {
            $mask = self::maskAll()
                    ->remove(self::DEBUG)
                    ->remove(self::INFO)
                    ->remove(self::NOTICE)
                    ->remove(self::WARNING);
        }
        return clone $mask;
    }
}
