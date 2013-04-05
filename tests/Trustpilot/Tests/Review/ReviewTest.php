<?php

/**
 * This file is part of the Trustpilot library.
 *
 * (c) Antoine Corcy <contact@sbin.dk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Trustpilot\Tests\Review;

use Trustpilot\Tests\TestCase;
use Trustpilot\Review\Review;

/**
 * @author Antoine Corcy <contact@sbin.dk>
 */
class ReviewTest extends TestCase
{
    protected $review;

    protected function setUp()
    {
        $feed = json_decode(TestCase::FEED);

        $this->review = new Review($feed->Reviews[0]);
    }

    public function testGetDateTime()
    {
        $this->assertTrue(is_object($this->review));
        $this->assertInstanceOf('\Trustpilot\Review\Review', $this->review);
        $this->assertTrue(is_object($this->review->getDateTime()));
        $this->assertInstanceOf('\Trustpilot\Time\Time', $this->review->getDateTime());
        $this->assertTrue(is_object($this->review->getDateTime()->getDateTime()));
        $this->assertInstanceOf('\DateTime', $this->review->getDateTime()->getDateTime());
        $this->assertEquals('2013-03-07', $this->review->getDateTime()->getDateTime()->format('Y-m-d'));
        $this->assertEquals('13:58:36+00:00', $this->review->getDateTime()->getDateTime()->format('H:i:sP'));
    }

    public function testGetTitle()
    {
        $this->assertTrue(is_object($this->review));
        $this->assertInstanceOf('\Trustpilot\Review\Review', $this->review);
        $this->assertSame('Testing testing', $this->review->getTitle());
    }

    public function testGetContent()
    {
        $this->assertTrue(is_object($this->review));
        $this->assertInstanceOf('\Trustpilot\Review\Review', $this->review);
        $this->assertSame('Testing like a boss!!!!', $this->review->getContent());
    }

    public function testGetTrustScore()
    {
        $this->assertTrue(is_object($this->review));
        $this->assertInstanceOf('\Trustpilot\Review\Review', $this->review);
        $this->assertTrue(is_object($this->review->getTrustScore()));
        $this->assertInstanceOf('\Trustpilot\TrustScore\TrustScore', $this->review->getTrustScore());
        $this->assertSame(100, $this->review->getTrustScore()->getScore());
        $this->assertSame(5, $this->review->getTrustScore()->getStars());
        $this->assertSame('Excellent', $this->review->getTrustScore()->getReadableScore());
        $this->assertSame('//s3-eu-west-1.amazonaws.com/s.trustpilot.com/images/tpelements/stars/s/5.png', $this->review->getTrustScore()->getImageUrl());
        $this->assertSame('//s3-eu-west-1.amazonaws.com/s.trustpilot.com/images/tpelements/stars/s/5.png', $this->review->getTrustScore()->getImageUrl('small'));
        $this->assertSame('//s3-eu-west-1.amazonaws.com/s.trustpilot.com/images/tpelements/stars/m/5.png', $this->review->getTrustScore()->getImageUrl('medium'));
        $this->assertSame('//s3-eu-west-1.amazonaws.com/s.trustpilot.com/images/tpelements/stars/l/5.png', $this->review->getTrustScore()->getImageUrl('large'));
    }

    public function testGetCompanyReply()
    {
        $this->assertTrue(is_object($this->review));
        $this->assertInstanceOf('\Trustpilot\Review\Review', $this->review);
        $this->assertEmpty($this->review->getCompanyReply());
    }

    public function testGetUser()
    {
        $this->assertTrue(is_object($this->review));
        $this->assertInstanceOf('\Trustpilot\Review\Review', $this->review);
        $this->assertTrue(is_object($this->review->getUser()));
        $this->assertInstanceOf('\Trustpilot\User\User', $this->review->getUser());
        $this->assertSame('Jacob Mortensen', $this->review->getUser()->getName());
        $this->assertSame('Amager', $this->review->getUser()->getCity());
        $this->assertSame('da-DK', $this->review->getUser()->getLocale());
        $this->assertSame(2, $this->review->getUser()->getTotalReviews());
        $this->assertFalse($this->review->getUser()->isVerified());
        $this->assertTrue($this->review->getUser()->hasImage());
        $this->assertSame('//s3-eu-west-1.amazonaws.com/images.trustpilot.com/CloudImages/User/881929/24x24.png', $this->review->getUser()->getImageUrl());
        $this->assertSame('//s3-eu-west-1.amazonaws.com/images.trustpilot.com/CloudImages/User/881929/24x24.png', $this->review->getUser()->getImageUrl('i24'));
        $this->assertSame('//s3-eu-west-1.amazonaws.com/images.trustpilot.com/CloudImages/User/881929/35x35.png', $this->review->getUser()->getImageUrl('i35'));
        $this->assertSame('//s3-eu-west-1.amazonaws.com/images.trustpilot.com/CloudImages/User/881929/64x64.png', $this->review->getUser()->getImageUrl('i64'));
        $this->assertSame('//s3-eu-west-1.amazonaws.com/images.trustpilot.com/CloudImages/User/881929/73x73.png', $this->review->getUser()->getImageUrl('i73'));
    }

    public function testGetUrl()
    {
        $this->assertTrue(is_object($this->review));
        $this->assertInstanceOf('\Trustpilot\Review\Review', $this->review);
        $this->assertSame('http://www.trustpilot.co.uk/review/demoshop.com#3943492', $this->review->getUrl());
    }

    public function testIsVerified()
    {
        $this->assertTrue(is_object($this->review));
        $this->assertInstanceOf('\Trustpilot\Review\Review', $this->review);
        $this->assertFalse($this->review->isVerified());
    }
}
