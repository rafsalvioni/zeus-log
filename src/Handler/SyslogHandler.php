<?php

namespace Zeus\Log\Handler;

use Zeus\Log\Level;

/**
 * Handle logs on a system logger.
 *
 * @see \syslog()
 * @author Rafael M. Salvioni
 */
class SyslogHandler extends AbstractFormattableHandler
{
    /**
     * 
     * @param array $log
     * @param string $formatted
     */
    protected function write(array $log, string $formatted)
    {
        $const = '\\LOG_' . \strtoupper($log['name']);
        $level = 0;
        
        switch (true) {
            case $log['level'] == Level::EMERGENCY:
                $level = \LOG_EMERG;
                break;
            case $log['level'] == Level::ERROR:
                $level = \LOG_ERR;
                break;
            case \defined($const):
                $level = \constant($const);
                break;
        }
        
        \syslog($level, $formatted);
    }
}
