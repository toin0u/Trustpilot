<?php

/**
 * This file is part of the Trustpilot library.
 *
 * (c) Antoine Corcy <contact@sbin.dk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Trustpilot\Tests\Time;

use Trustpilot\Tests\TestCase;
use Trustpilot\Time\Time;

/**
 * @author Antoine Corcy <contact@sbin.dk>
 */
class TimeTest extends TestCase
{
    protected $time;

    protected function setUp()
    {
        $feed = json_decode(TestCase::FEED);

        $this->time = new Time($feed->FeedUpdateTime);
    }

    public function testGetHuman()
    {
        $this->assertTrue(is_object($this->time));
        $this->assertInstanceOf('\Trustpilot\Time\Time', $this->time);
        $this->assertSame('04 April 2013 14:37:11 GMT', $this->time->getHuman());
    }

    public function testGetUnixTime()
    {
        $this->assertTrue(is_object($this->time));
        $this->assertInstanceOf('\Trustpilot\Time\Time', $this->time);
        $this->assertTrue(is_int($this->time->getUnixTime()));
        $this->assertEquals(1365089831, $this->time->getUnixTime());
    }

    public function testGetHumanDate()
    {
        $this->assertTrue(is_object($this->time));
        $this->assertInstanceOf('\Trustpilot\Time\Time', $this->time);
        $this->assertSame('4. Apr', $this->time->getHumanDate());
    }

    public function testGetDateTime()
    {
        $this->assertTrue(is_object($this->time));
        $this->assertInstanceOf('\Trustpilot\Time\Time', $this->time);
        $this->assertTrue(is_object($this->time->getDateTime()));
        $this->assertInstanceOf('\DateTime', $this->time->getDateTime());
        $this->assertEquals('2013-04-04', $this->time->getDateTime()->format('Y-m-d'));
        $this->assertEquals('14:37:11+00:00', $this->time->getDateTime()->format('H:i:sP'));
    }
}
