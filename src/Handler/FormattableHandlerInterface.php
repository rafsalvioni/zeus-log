<?php

namespace Zeus\Log\Handler;

use Zeus\Log\Formatter\FormatterInterface;

/**
 * Identifies a formattable handler.
 * 
 * @author Rafael M. Salvioni
 */
interface FormattableHandlerInterface extends HandlerInterface
{
    /**
     * Define the handler formatter.
     * 
     * @param FormatterInterface $formatter
     * @return self
     */
    public function setFormatter(FormatterInterface $formatter);
    
    /**
     * Returns the handler formatter.
     * 
     * @return FormatterInterface
     */
    public function getFormatter();
}
