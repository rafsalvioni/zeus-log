<?php

namespace Zeus\Log\Handler;

use Zeus\Log\Formatter\FormatterInterface;
use Zeus\Stream\StreamInterface;

/**
 * Handle logs to a stream.
 *
 * @author Rafael M. Salvioni
 */
class StreamHandler extends AbstractFormattableHandler
{
    /**
     * Writable stream
     * 
     * @var StreamInterface
     */
    protected $stream;
    
    /**
     * 
     * @param StreamInterface $stream
     * @param int|string $level
     * @param FormatterInterface $formatter
     */
    public function __construct(
        StreamInterface $stream,
        $level = 0,
        FormatterInterface $formatter = null
    ) {
        parent::__construct($level, $formatter);
        $this->stream = $stream;
    }

    /**
     * 
     * @param array $log
     * @param string $formatted
     */
    protected function write(array $log, $formatted)
    {
        $this->stream->write($formatted);
    }
}
