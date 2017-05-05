<?php

namespace Zeus\Log\Formatter;

/**
 * Identifies a handler formatter.
 * 
 * @author Rafael M. Salvioni
 */
interface FormatterInterface
{
    /**
     * Makes a formatted string using a log record.
     * 
     * @param array $log
     * @return string
     */
    public function format(array $log): string;
}
