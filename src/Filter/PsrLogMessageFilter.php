<?php

namespace Zeus\Log\Filter;

/**
 * Implements a filter to translate Psr log model messages.
 *
 * @author Rafael M. Salvioni
 */
class PsrLogMessageFilter
{
    /**
     * 
     * @param array $log
     * @return array
     */
    public function __invoke(array $log)
    {
        if (!empty($log['context']) && strpos($log['message'], '{') !== false) {
            $trans = [];
            foreach ($log['context'] as $key => &$value) {
                $trans["{{$key}}"] =& $value;
            }
            $log['message'] = \strtr($log['message'], $trans);
        }
        return $log;
    }
}
