<?php

namespace ZeusTest\Log\Handler;

use Zeus\Log\Logger;
use Zeus\Log\Handler\StreamHandler;
use Zeus\Log\Level;
use Zeus\Stream\Output;

/**
 * 
 * @author Rafael M. Salvioni
 */
class StreamHandlerTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     * @var Logger
     */
    private $logger;
    
    public function setUp()
    {
        $this->logger = new Logger(
            new StreamHandler(Output::getInstance(), Level::maskAll()->getMask())
        );
    }
    
    /**
     * @test
     */
    public function handleTest()
    {
        $this->logger->alert(__FUNCTION__);
        $this->expectOutputRegex('/' . __FUNCTION__ . '/');
    }
}
