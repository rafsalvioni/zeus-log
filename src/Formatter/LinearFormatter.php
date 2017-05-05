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
     * Line template;
     * 
     * @var string
     */
    private $line;
    
    /**
     * 
     * @param string $line Line template
     */
    public function __construct($line = self::LINE)
    {
        $this->line = \trim($line);
    }

    /**
     * 
     * @param array $log
     * @return string
     */
    public function format(array $log): string
    {
        $return         = $this->line;
        $log['date']    = \date('r', $log['timestamp']);
        $log['message'] = \preg_replace('/\r\n|\r|\n/', ' ', $log['message']);
        
        foreach ($log as $field => &$value) {
            if (!\is_scalar($value)) {
                continue;
            }
            $return = \str_replace("{{$field}}", $value, $return);
        }
        
        $return = \preg_replace('/\r\n|\r|\n/', ' ', $return);
        return $return;
    }
}
