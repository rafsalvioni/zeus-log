<?php

namespace Zeus\Log\Handler;

use Zeus\Log\Formatter\LinearFormatter;
use Zeus\Log\Formatter\FormatterInterface;

/**
 * Trait to implement FormattableHandlerInterface methods.
 *
 * @author Rafael M. Salvioni
 */
trait FormattableHandlerTrait
{
    /**
     * Formatter
     * 
     * @var FormatterInterface
     */
    protected $formatter;
    
    /**
     * 
     * @return FormatterInterface
     */
    public function getFormatter(): FormatterInterface
    {
        if (!($this->formatter instanceof FormatterInterface)) {
            $this->formatter = new LinearFormatter();
        }
        return $this->formatter;
    }

    /**
     * 
     * @param FormatterInterface $formatter
     * @return self
     */
    public function setFormatter(FormatterInterface $formatter)
        : FormattableHandlerInterface
    {
        $this->formatter = $formatter;
        return $this;
    }
}
