<?php

namespace Zeus\Log\Handler;

/**
 * Handler to write logs on PHP output buffer.
 *
 * @author Rafael M. Salvioni
 */
class OutputHandler extends AbstractFormattableHandler
{
    /**
     * 
     * @param array $log
     * @param string $formatted
     */
    protected function write(array $log, string $formatted)
    {
        echo $formatted . \PHP_EOL;
    }
}
