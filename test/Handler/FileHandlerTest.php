<?php

namespace ZeusTest\Log\Handler;

use Zeus\Log\Logger;
use Zeus\Log\Handler\FileHandler;
use Zeus\Log\Level;
use Zeus\Stream\Output;

/**
 * 
 * @author Rafael M. Salvioni
 */
class FileHandlerTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     * @var Logger
     */
    private $logger;
    private $filePath;
    
    public function setUp()
    {
        $this->filePath = \tempnam(\SYS_TEMP_DIR, 'foo');
        $this->logger = new Logger(
            new FileHandler($this->filePath, Level::maskAll()->getMask())
        );
    }
    
    /**
     * @test
     */
    public function handleTest()
    {
        $this->logger->alert(__FUNCTION__);
        $contents = \file_get_contents($this->filePath);
        $this->assertTrue(\strpos($contents, __FUNCTION__) >= 0);
    }
}
