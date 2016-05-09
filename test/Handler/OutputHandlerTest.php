<?php

namespace ZeusTest\Log\Handler;

use Zeus\Log\Logger;
use Zeus\Log\Handler\OutputHandler;
use Zeus\Log\Level;

/**
 * 
 * @author Rafael M. Salvioni
 */
class OutputHandlerTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     * @var Logger
     */
    private $logger;
    
    public function setUp()
    {
        $this->logger = new Logger(
            new OutputHandler(Level::maskAll()->getMask())
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
