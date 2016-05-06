<?php

namespace ZeusTest\Log;

use Zeus\Log\Level;
use Zeus\Core\BitMask;

/**
 *
 * @author Rafael M. Salvioni
 */
class LevelTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Level names
     * 
     * @var string[]
     */
    private static $constsNames = [
        'ALERT', 'CRITICAL', 'ERROR', 'EMERGENCY',
        'DEBUG', 'INFO', 'WARNING', 'NOTICE'
    ];
    
    /**
     * @test
     */
    public function constsTest()
    {
        $mask = 0;
        foreach (self::$constsNames as &$name) {
            $const = Level::class . '::' . $name;
            if (!\defined($const)) {
                $this->assertTrue(false);
                return;
            }
            $level = \constant($const);
            if (!\is_int($level)) {
                $this->assertTrue(false);
                return;
            }
            if (!BitMask::isSingleFlag($level)) {
                $this->assertTrue(false);
                return;
            }
            $foo = BitMask::addFlag($mask, $level);
            if ($foo === $mask) {
                $this->assertTrue(false);
                return;
            }
            $mask = $foo;
        }
        $this->assertTrue(true);
    }
    
    /**
     * @test
     * @depends constsTest
     */
    public function listLevelsTest()
    {
        $list = Level::listLevels();
        $comp = \array_diff(\array_keys($list), self::$constsNames);
        $this->assertTrue(empty($comp));
    }
    
    /**
     * @test
     * @depends constsTest
     */
    public function toLevelTest()
    {
        $this->assertEquals(Level::toLevel('CriTIcal'), Level::CRITICAL);
        $this->assertEquals(Level::toLevel('error'), Level::ERROR);
        $this->assertEquals(Level::toLevel('asdgfasd'), 0);
        $this->assertEquals(Level::toLevel(8), 8);
        $this->assertEquals(Level::toLevel(12.6), 12);
        $this->assertEquals(Level::toLevel('12'), 12);
    }
    
    /**
     * @test
     * @depends listLevelsTest
     */
    public function getLevelNameTest()
    {
        $list = Level::listLevels();
        foreach ($list as $name => $level) {
            $this->assertEquals(Level::getLevelName($level), $name);
        }
        $this->assertEquals(Level::getLevelName('__FOO__'), null);
    }
    
    /**
     * @test
     * @depends listLevelsTest
     */
    public function isTest()
    {
        $list = Level::listLevels();
        $mask = 0;
        
        foreach ($list as $name => $level) {
            $this->assertTrue(Level::is($level));
            $mask = BitMask::addFlag($mask, $level);
        }
        $this->assertTrue(Level::is($mask));
        $this->assertFalse(Level::is(1 << 10));
    }
}
