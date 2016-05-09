<?php

namespace ZeusTest\Log\Handler;

use Zeus\Log\Logger;
use Zeus\Log\Handler\HandlerChain;
use Zeus\Log\Handler\OutputHandler;
use Zeus\Log\Level;

/**
 * 
 * @author Rafael M. Salvioni
 */
class LoggerChainTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     * @var Logger
     */
    private $logger;
    
    public function setUp()
    {
        $handler = new HandlerChain();
        $handler->pushHandler(new OutputHandler(Level::ALERT));
        $handler->pushHandler(new OutputHandler(Level::ALERT));
        $handler->pushHandler(new OutputHandler(Level::DEBUG));
        $this->logger = new Logger($handler);
    }
    
    /**
     * @test
     */
    public function getLevelTest()
    {
        $this->assertEquals($this->logger->getHandler()->getHandledLevel(), 130);
    }

    /**
     * @test
     */
    public function isHandledTest()
    {
        $this->assertTrue($this->logger->getHandler()->isHandled(Level::ALERT));
        $this->assertTrue($this->logger->getHandler()->isHandled(Level::DEBUG));
        $this->assertFalse($this->logger->getHandler()->isHandled(Level::CRITICAL));
        $this->assertFalse($this->logger->getHandler()->isHandled(Level::ERROR));
    }

    /**
     * @test
     */
    public function alertHandleTest()
    {
        $this->logger->alert(__FUNCTION__);
        $this->expectOutputRegex('/' . __FUNCTION__ . '/');
    }
    
    /**
     * @test
     */
    public function debugHandleTest()
    {
        $this->logger->debug(__FUNCTION__);
        $this->expectOutputRegex('/' . __FUNCTION__ . '/');
    }
    
    /**
     * @test
     */
    public function bubblingTest()
    {
        $this->logger->getHandler()->isBubbling(true);
        $this->logger->alert(__FUNCTION__);
        $this->expectOutputRegex('/' . __FUNCTION__ . '.+' . __FUNCTION__ .  '/sm');
    }
}
