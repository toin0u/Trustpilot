<?php

/**
 * This file is part of the Trustpilot library.
 *
 * (c) Antoine Corcy <contact@sbin.dk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Trustpilot\Tests\User;

use Trustpilot\Tests\TestCase;
use Trustpilot\User\User;

/**
 * @author Antoine Corcy <contact@sbin.dk>
 */
class UserTest extends TestCase
{
    protected $user;

    protected function setUp()
    {
        $feed = json_decode(TestCase::FEED);

        $this->user = new User($feed->Reviews[0]->User);
    }

    public function testGetName()
    {
        $this->assertTrue(is_object($this->user));
        $this->assertInstanceOf('\Trustpilot\User\User', $this->user);
        $this->assertSame('Jacob Mortensen', $this->user->getName());
    }

    public function testGetCity()
    {
        $this->assertTrue(is_object($this->user));
        $this->assertInstanceOf('\Trustpilot\User\User', $this->user);
        $this->assertSame('Amager', $this->user->getCity());
    }

    public function testGetLocale()
    {
        $this->assertTrue(is_object($this->user));
        $this->assertInstanceOf('\Trustpilot\User\User', $this->user);
        $this->assertSame('da-DK', $this->user->getLocale());
    }

    public function testGetTotalReviews()
    {
        $this->assertTrue(is_object($this->user));
        $this->assertInstanceOf('\Trustpilot\User\User', $this->user);
        $this->assertTrue(is_int($this->user->getTotalReviews()));
        $this->assertEquals(2, $this->user->getTotalReviews());
    }

    public function testIsVerified()
    {
        $this->assertTrue(is_object($this->user));
        $this->assertInstanceOf('\Trustpilot\User\User', $this->user);
        $this->assertFalse($this->user->isVerified());
    }

    public function testHasImage()
    {
        $this->assertTrue(is_object($this->user));
        $this->assertInstanceOf('\Trustpilot\User\User', $this->user);
        $this->assertTrue($this->user->hasImage());
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage "foo" is an invalid size please choose between "i24", "i35", "i64" and "i73".
     */
    public function testGetImageUrlShouldThrowAnException()
    {
        $this->user->getImageUrl('foo');
    }

    public function testGetImageUrlWithoutArgument()
    {
        $this->assertTrue(is_object($this->user));
        $this->assertInstanceOf('\Trustpilot\User\User', $this->user);
        $this->assertSame('//s3-eu-west-1.amazonaws.com/images.trustpilot.com/CloudImages/User/881929/24x24.png', $this->user->getImageUrl());
    }

    /**
     * @dataProvider sizeProvider
     */
    public function testGetImageUrl($size, $expectedUrl)
    {
        $this->assertTrue(is_object($this->user));
        $this->assertInstanceOf('\Trustpilot\User\User', $this->user);
        $this->assertSame($expectedUrl, $this->user->getImageUrl($size));
    }

    public function sizeProvider()
    {
        return array(
            array('i24', '//s3-eu-west-1.amazonaws.com/images.trustpilot.com/CloudImages/User/881929/24x24.png'),
            array('i35', '//s3-eu-west-1.amazonaws.com/images.trustpilot.com/CloudImages/User/881929/35x35.png'),
            array('i64', '//s3-eu-west-1.amazonaws.com/images.trustpilot.com/CloudImages/User/881929/64x64.png'),
            array('i73', '//s3-eu-west-1.amazonaws.com/images.trustpilot.com/CloudImages/User/881929/73x73.png'),
        );
    }
}
