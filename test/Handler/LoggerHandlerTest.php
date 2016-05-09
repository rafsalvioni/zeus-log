<?php

namespace ZeusTest\Log\Handler;

use Zeus\Log\Logger;
use Zeus\Log\Handler\LoggerHandler;
use Zeus\Log\Level;
use ZeusTest\Log\PsrLogger;

/**
 * 
 * @author Rafael M. Salvioni
 */
class LoggerHandlerTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     * @var Logger
     */
    private $logger;
    
    public function setUp()
    {
        $handler = new LoggerHandler(new PsrLogger(), Level::maskAll()->getMask());
        $this->logger = new Logger($handler);
    }
    
    /**
     * @test
     */
    public function handleTest()
    {
        $this->logger->alert(__FUNCTION__);
        $this->expectOutputRegex('/alert.+' . __FUNCTION__ . '/');
    }
    
    /**
     * @test
     */
    public function handleTest2()
    {
        $this->logger->log(132, __FUNCTION__);
        $this->expectOutputRegex('/critical.+' . __FUNCTION__ . '.+debug.+' . __FUNCTION__ . '/sm');
    }
}
