<?php

namespace Zeus\Log\Handler;

use Zeus\Log\Level;
use Zeus\Log\Formatter\FormatterInterface;

/**
 * Abstract formattable handler.
 *
 * @author Rafael M. Salvioni
 */
abstract class AbstractFormattableHandler extends AbstractHandler implements
    FormattableHandlerInterface
{
    use FormattableHandlerTrait;
    
    /**
     * 
     * @param int|string $level Handled level
     */
    public function __construct($level = 0, FormatterInterface $formatter = null)
    {
        parent::__construct($level);
        $this->level = Level::toLevel($level);
        if ($formatter) {
            $this->setFormatter($formatter);
        }
    }
    
    /**
     * Handles the log record using its formatter.
     * 
     * @param array $log
     * @return self
     */
    public function handle(array $log)
    {
        $message = $this->getFormatter()->format($log);
        $this->write($log, $message);
        return $this;
    }

    /**
     * Writes the log on destiny.
     * 
     * @param array $log
     * @param string $formatted Formatted message
     */
    abstract protected function write(array $log, $formatted);
}
