<?php

namespace ZeusTest\Log;

use Zeus\Log\Logger;
use Zeus\Log\Level;

/**
 * 
 * @author Rafael M. Salvioni
 */
class LoggerTest extends \PHPUnit_Framework_TestCase {

    /**
     *
     * @var Logger
     */
    private $logger;

    public function setUp() {
        $handler = new GenericHandler(Level::maskAll()->getMask());
        $this->logger = new Logger($handler);
    }
    
    /**
     * @test
     */
    public function defaultTest()
    {
        $logger = new Logger(new NullHandler());
        $this->assertTrue($this->logger === Logger::getDefault());
        Logger::setDefault($logger);
        $this->assertTrue($logger === Logger::getDefault());
    }

    /**
     * @test
     */
    public function logTest() {
        $str = 'Log Test';
        $logger = $this->logger->log(Level::EMERGENCY, $str);
        $this->expectOutputRegex("/$str/");
        $this->assertTrue($logger === $this->logger);
    }

    /**
     * @test
     */
    public function logNameTest() {
        $str = 'Log Test';
        $this->logger->log('eMergENCy', $str);
        $this->expectOutputRegex("/$str/");
    }

    /**
     * @test
     */
    public function logNameErrorTest() {
        $str = 'Log Test';
        $this->logger->log('emergency1', $str);
        $this->expectOutputString('');
    }

    /**
     * @test
     */
    public function logUnhandledTest() {
        $str = 'Log Test';
        $handler = new GenericHandler(Level::ERROR);
        $this->logger->setHandler($handler);
        $this->logger->info($str);
        $this->expectOutputString('');
    }

    /**
     * @test
     */
    public function logCompositeTest() {
        $str = 'Log Test';
        $this->logger->log(Level::ALERT | Level::ERROR, $str);
        $this->expectOutputRegex('/ALERT.+ERROR/sm');
    }

    /**
     * @test
     */
    public function logRecordTest() {
        $this->logger->info(__FUNCTION__);
        $lastLog = & $this->logger->getHandler()->lastLog;
        $this->assertTrue(
                isset($lastLog['level']) && $lastLog['level'] == Level::INFO && isset($lastLog['name']) && $lastLog['name'] == 'INFO' && isset($lastLog['message']) && $lastLog['message'] == __FUNCTION__ && isset($lastLog['context']) && \is_array($lastLog['context']) && isset($lastLog['extra']) && \is_array($lastLog['extra']) && isset($lastLog['timestamp']) && \is_float($lastLog['timestamp'])
        );
    }

    /**
     * @test
     * @depends logRecordTest
     */
    public function logFilterTest() {
        $this->logger->pushFilter(function(array $log) {
            $log['extra']['foo'] = true;
            return $log;
        });
        $this->logger->info(__FUNCTION__);
        $lastLog = & $this->logger->getHandler()->lastLog;
        $this->assertTrue(isset($lastLog['extra']['foo']));
    }

    /**
     * @test
     */
    public function logEvents()
    {
        $output = '';
        $observer = function($emitter, $event) use (&$output) {
            $output .= "#$event";
        };
        $this->logger->on('log', $observer);
        $this->logger->on('unhandled', $observer);
        $this->logger->on('unknown', $observer);
        $this->logger->on('alert', $observer);
        $this->logger->on('info', $observer);

        $this->logger->setHandler(new NullHandler(Level::ALERT));
        $this->logger->alert(__FUNCTION__);
        $this->logger->info(__FUNCTION__);
        $this->logger->log(0, '');

        $this->assertTrue(!!\preg_match('/^#log#alert#unhandled#unknown$/', $output));
    }

    /**
     * @test
     */
    public function alertTest() {
        $str = __FUNCTION__;
        $logger = $this->logger->alert($str);
        $this->expectOutputRegex("/\\[ALERT\\]: $str/");
        $this->assertTrue($logger === $this->logger);
    }

    /**
     * @test
     */
    public function critTest() {
        $str = __FUNCTION__;
        $logger = $this->logger->critical($str);
        $this->expectOutputRegex("/\\[CRITICAL\\]: $str/");
        $this->assertTrue($logger === $this->logger);
    }

    /**
     * @test
     */
    public function debugTest() {
        $str = __FUNCTION__;
        $logger = $this->logger->debug($str);
        $this->expectOutputRegex("/\\[DEBUG\\]: $str/");
        $this->assertTrue($logger === $this->logger);
    }

    /**
     * @test
     */
    public function emerTest() {
        $str = __FUNCTION__;
        $logger = $this->logger->emergency($str);
        $this->expectOutputRegex("/\\[EMERGENCY\\]: $str/");
        $this->assertTrue($logger === $this->logger);
    }

    /**
     * @test
     */
    public function errorTest() {
        $str = __FUNCTION__;
        $logger = $this->logger->error($str);
        $this->expectOutputRegex("/\\[ERROR\\]: $str/");
        $this->assertTrue($logger === $this->logger);
    }

    /**
     * @test
     */
    public function infoTest() {
        $str = __FUNCTION__;
        $logger = $this->logger->info($str);
        $this->expectOutputRegex("/\\[INFO\\]: $str/");
        $this->assertTrue($logger === $this->logger);
    }

    /**
     * @test
     */
    public function noticeTest() {
        $str = __FUNCTION__;
        $logger = $this->logger->notice($str);
        $this->expectOutputRegex("/\\[NOTICE\\]: $str/");
        $this->assertTrue($logger === $this->logger);
    }

    /**
     * @test
     */
    public function warningTest() {
        $str = __FUNCTION__;
        $logger = $this->logger->warning($str);
        $this->expectOutputRegex("/\\[WARNING\\]: $str/");
        $this->assertTrue($logger === $this->logger);
    }

}
