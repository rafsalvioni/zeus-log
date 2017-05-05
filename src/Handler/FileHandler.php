<?php

namespace Zeus\Log\Handler;

use Zeus\Log\Formatter\FormatterInterface;
use Zeus\Stream\Stream;

/**
 * Handle logs to a file.
 *
 * @author Rafael M. Salvioni
 */
class FileHandler extends StreamHandler
{
    /**
     * 
     * @param string $filePath
     * @param int|string $level
     * @param FormatterInterface $formatter
     */
    public function __construct(
        string $filePath,
        $level = 0,
        FormatterInterface $formatter = null
    ) {
        $stream = Stream::open($filePath, 'a+');
        parent::__construct($stream, $level, $formatter);
    }
    
    /**
     * 
     * @param array $log
     * @param string $formatted
     */
    protected function write(array $log, string $formatted)
    {
        parent::write($log, $formatted);
        $this->stream->write($this->stream->eol());
    }
}
