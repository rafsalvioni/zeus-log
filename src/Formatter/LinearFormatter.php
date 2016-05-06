<?php

namespace Zeus\Log\Formatter;

/**
 * Format a log to a single line.
 *
 * @author Rafael M. Salvioni
 */
class LinearFormatter implements FormatterInterface
{
    /**
     * Default line template
     */
    const LINE = '[{date}][{name}]: {message}';
    
    /**
     * 
     * @param array $log
     * @return string
     */
    public function format(array $log)
    {
        $return         = self::LINE;
        $log['date']    = \date('r', $log['timestamp']);
        $log['message'] = \preg_replace('/\r\n|\r|\n/', ' ', $log['message']);
        
        foreach ($log as $field => &$value) {
            if (!\is_scalar($value)) {
                continue;
            }
            $return = \str_replace("{{$field}}", $value, $return);
        }
        
        return $return;
    }
}
