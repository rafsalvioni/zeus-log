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
    public function getFormatter()
    {
        if (!($this->formatter instanceof FormatterInterface)) {
            $this->formatter = new \Zeus\Log\Formatter\LinearFormatter();
        }
        return $this->formatter;
    }

    /**
     * 
     * @param FormatterInterface $formatter
     * @return self
     */
    public function setFormatter(FormatterInterface $formatter)
    {
        $this->formatter = $formatter;
        return $this;
    }
}
