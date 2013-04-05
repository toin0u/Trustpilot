<?php

/**
 * This file is part of the Trustpilot library.
 *
 * (c) Antoine Corcy <contact@sbin.dk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Trustpilot\Tests\TrustScore;

use Trustpilot\Tests\TestCase;
use Trustpilot\TrustScore\TrustScore;

/**
 * @author Antoine Corcy <contact@sbin.dk>
 */
class TrustScoreTest extends TestCase
{
    protected $trustscore;

    protected function setUp()
    {
        $feed = json_decode(TestCase::FEED);

        $this->trustscore = new TrustScore($feed->TrustScore);
    }

    public function testGetName()
    {
        $this->assertTrue(is_object($this->trustscore));
        $this->assertInstanceOf('\Trustpilot\TrustScore\TrustScore', $this->trustscore);
        $this->assertTrue(is_int($this->trustscore->getScore()));
        $this->assertTrue($this->trustscore->getScore() >= 0);
        $this->assertTrue($this->trustscore->getScore() <= 100);
        $this->assertEquals(84, $this->trustscore->getScore());
    }

    public function testGetStars()
    {
        $this->assertTrue(is_object($this->trustscore));
        $this->assertInstanceOf('\Trustpilot\TrustScore\TrustScore', $this->trustscore);
        $this->assertTrue(is_int($this->trustscore->getStars()));
        $this->assertTrue($this->trustscore->getStars() >= 1);
        $this->assertTrue($this->trustscore->getStars() <= 5);
        $this->assertEquals(4, $this->trustscore->getStars());
    }

    public function testGetReadableScore()
    {
        $this->assertTrue(is_object($this->trustscore));
        $this->assertInstanceOf('\Trustpilot\TrustScore\TrustScore', $this->trustscore);
        $this->assertSame('Good', $this->trustscore->getReadableScore());
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage "foo" is an invalid size please choose between "small", "medium" and "large".
     */
    public function testGetImageUrlShouldThrowAnException()
    {
        $this->trustscore->getImageUrl('foo');
    }

    public function testGetImageUrlWithoutArgument()
    {
        $this->assertTrue(is_object($this->trustscore));
        $this->assertInstanceOf('\Trustpilot\TrustScore\TrustScore', $this->trustscore);
        $this->assertSame('//s3-eu-west-1.amazonaws.com/s.trustpilot.com/images/tpelements/stars/s/4.png', $this->trustscore->getImageUrl());
    }

    /**
     * @dataProvider sizeProvider
     */
    public function testGetImageUrl($size, $expectedUrl)
    {
        $this->assertTrue(is_object($this->trustscore));
        $this->assertInstanceOf('\Trustpilot\TrustScore\TrustScore', $this->trustscore);
        $this->assertSame($expectedUrl, $this->trustscore->getImageUrl($size));
    }

    public function sizeProvider()
    {
        return array(
            array('small', '//s3-eu-west-1.amazonaws.com/s.trustpilot.com/images/tpelements/stars/s/4.png'),
            array('medium', '//s3-eu-west-1.amazonaws.com/s.trustpilot.com/images/tpelements/stars/m/4.png'),
            array('large', '//s3-eu-west-1.amazonaws.com/s.trustpilot.com/images/tpelements/stars/l/4.png'),
        );
    }
}
