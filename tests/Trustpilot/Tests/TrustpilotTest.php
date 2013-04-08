<?php

/**
 * This file is part of the Trustpilot library.
 *
 * (c) Antoine Corcy <contact@sbin.dk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Trustpilot\Tests;

use Trustpilot\Trustpilot;
use Trustpilot\HttpAdapter\CurlHttpAdapter;

/**
 * @author Antoine Corcy <contact@sbin.dk>
 */
class TrustpilotTest extends TestCase
{
    protected $trustpilot;

    protected function setUp()
    {
        $this->trustpilot = new TestableTrustpilot();

        $method = new \ReflectionMethod(
            $this->trustpilot, 'setData'
        );
        $method->setAccessible(true);
        $method->invoke($this->trustpilot, json_decode(TestCase::FEED));
    }

    public function testConstructor()
    {
        $trustpilot = new Trustpilot(TestCase::FEED_ID, new CurlHttpAdapter());

        $this->assertTrue(is_object($trustpilot));
        $this->assertInstanceOf('\Trustpilot\Trustpilot', $trustpilot);
        $this->assertTrue(is_object($trustpilot->getLastUpdate()));
        $this->assertInstanceOf('\Trustpilot\Time\Time', $trustpilot->getLastUpdate());
        $this->assertTrue(is_object($trustpilot->getLastUpdate()->getDateTime()));
        $this->assertInstanceOf('\DateTime', $trustpilot->getLastUpdate()->getDateTime());
        $this->assertTrue(is_array($trustpilot->getReviews()));
        foreach ($trustpilot->getReviews() as $review) {
            $this->assertTrue(is_object($review));
            $this->assertInstanceOf('\Trustpilot\Review\Review', $review);
            $this->assertTrue(is_object($review->getTime()));
            $this->assertInstanceOf('\Trustpilot\Time\Time', $review->getTime());
            $this->assertTrue(is_object($review->getTime()->getDateTime()));
            $this->assertInstanceOf('\DateTime', $review->getTime()->getDateTime());
            $this->assertTrue(is_string($review->getTitle()));
            $this->assertTrue(is_string($review->getContent()));
            $this->assertTrue(is_object($review->getTrustScore()));
            $this->assertInstanceOf('\Trustpilot\TrustScore\TrustScore', $review->getTrustScore());
            $this->assertTrue(is_string($review->getCompanyReply()));
            $this->assertTrue(is_object($review->getUser()));
            $this->assertInstanceOf('\Trustpilot\User\User', $review->getUser());
            $this->assertTrue(is_string($review->getUrl()));
            $this->assertTrue(is_bool($review->isVerified()));
        }
        $this->assertTrue(is_array($trustpilot->getCategories()));
        foreach ($trustpilot->getCategories() as $category) {
            $this->assertTrue(is_object($category));
            $this->assertTrue(is_string($category->getName()));
            $this->assertTrue(is_int($category->getPosition()));
            $this->assertTrue(is_int($category->getTotalDomain()));
            $this->assertTrue(is_string($category->getImageUrl()));
        }
        $this->assertTrue(is_object($trustpilot->getTrustScore()));
        $this->assertInstanceOf('\Trustpilot\TrustScore\TrustScore', $trustpilot->getTrustScore());

    }

    public function testGetData()
    {
        $method = new \ReflectionMethod(
            $this->trustpilot, 'getData'
        );
        $method->setAccessible(true);
        $this->assertEquals($method->invoke($this->trustpilot), json_decode(TestCase::FEED));
    }

    public function testGetDomainName()
    {
        $this->assertSame('demoshop.com', $this->trustpilot->getDomainName());
    }

    public function testGetLastUpdate()
    {
        $this->assertTrue(is_object($this->trustpilot->getLastUpdate()));
        $this->assertInstanceOf('\Trustpilot\Time\Time', $this->trustpilot->getLastUpdate());
        $this->assertTrue(is_object($this->trustpilot->getLastUpdate()->getDateTime()));
        $this->assertInstanceOf('\DateTime', $this->trustpilot->getLastUpdate()->getDateTime());
        $this->assertEquals('2013-04-04', $this->trustpilot->getLastUpdate()->getDateTime()->format('Y-m-d'));
        $this->assertEquals('15:37:11+00:00', $this->trustpilot->getLastUpdate()->getDateTime()->format('H:i:sP'));
    }

    public function testGetUrl()
    {
        $this->assertSame('http://www.trustpilot.co.uk/review/demoshop.com', $this->trustpilot->getUrl());
    }

    public function testGetTotalReviews()
    {
        $this->assertTrue(is_int($this->trustpilot->getTotalReviews()));
        $this->assertEquals(105, $this->trustpilot->getTotalReviews());
    }

    public function testGetDistributionOverStars()
    {
        $this->assertTrue(is_array($this->trustpilot->getDistributionOverStars()));
        $this->assertArrayHasKey(0, $this->trustpilot->getDistributionOverStars());
        $this->assertArrayHasKey(1, $this->trustpilot->getDistributionOverStars());
        $this->assertArrayHasKey(2, $this->trustpilot->getDistributionOverStars());
        $this->assertArrayHasKey(3, $this->trustpilot->getDistributionOverStars());
        $this->assertArrayHasKey(4, $this->trustpilot->getDistributionOverStars());
        $this->assertCount(5, $this->trustpilot->getDistributionOverStars());
        $distributionOverStars = $this->trustpilot->getDistributionOverStars();
        $this->assertEquals(3, $distributionOverStars[0]);
        $this->assertEquals(1, $distributionOverStars[1]);
        $this->assertEquals(11, $distributionOverStars[2]);
        $this->assertEquals(28, $distributionOverStars[3]);
        $this->assertEquals(62, $distributionOverStars[4]);
    }

    public function testGetReviews()
    {
        $this->assertTrue(is_array($this->trustpilot->getReviews()));
        foreach ($this->trustpilot->getReviews() as $review) {
            $this->assertTrue(is_object($review));
            $this->assertInstanceOf('\Trustpilot\Review\Review', $review);
            $this->assertTrue(is_object($review->getTime()));
            $this->assertInstanceOf('\Trustpilot\Time\Time', $review->getTime());
            $this->assertTrue(is_object($review->getTime()->getDateTime()));
            $this->assertInstanceOf('\DateTime', $review->getTime()->getDateTime());
            $this->assertTrue(is_string($review->getTitle()));
            $this->assertTrue(is_string($review->getContent()));
            $this->assertTrue(is_object($review->getTrustScore()));
            $this->assertInstanceOf('\Trustpilot\TrustScore\TrustScore', $review->getTrustScore());
            $this->assertTrue(is_string($review->getCompanyReply()));
            $this->assertTrue(is_object($review->getUser()));
            $this->assertInstanceOf('\Trustpilot\User\User', $review->getUser());
            $this->assertTrue(is_string($review->getUrl()));
            $this->assertTrue(is_bool($review->isVerified()));
        }
    }

    public function testGetReviewsReturnsEmptyArray()
    {
        $trustpilot = new TestableTrustpilot();

        $method = new \ReflectionMethod(
            $trustpilot, 'setData'
        );
        $method->setAccessible(true);
        $method->invoke($trustpilot, json_decode(TestCase::FEED_WITHOUT_REVIEWS));

        $this->assertTrue(is_array($trustpilot->getReviews()));
        $this->assertCount(0, $trustpilot->getReviews());
    }

    public function testGetCategories()
    {
        $this->assertTrue(is_array($this->trustpilot->getCategories()));
        foreach ($this->trustpilot->getCategories() as $category) {
            $this->assertTrue(is_object($category));
            $this->assertTrue(is_string($category->getName()));
            $this->assertTrue(is_int($category->getPosition()));
            $this->assertTrue(is_int($category->getTotalDomain()));
            $this->assertTrue(is_string($category->getImageUrl()));
        }
    }

    public function testGetCategoriesReturnsEmptyArray()
    {
        $trustpilot = new TestableTrustpilot();

        $method = new \ReflectionMethod(
            $trustpilot, 'setData'
        );
        $method->setAccessible(true);
        $method->invoke($trustpilot, json_decode(TestCase::FEED_WITHOUT_CATEGORIES));

        $this->assertTrue(is_array($trustpilot->getCategories()));
        $this->assertCount(0, $trustpilot->getCategories());
    }

    public function testGetTrustScore()
    {
        $this->assertTrue(is_object($this->trustpilot->getTrustScore()));
        $this->assertInstanceOf('\Trustpilot\TrustScore\TrustScore', $this->trustpilot->getTrustScore());
        $this->assertSame(84, $this->trustpilot->getTrustScore()->getScore());
        $this->assertSame(4, $this->trustpilot->getTrustScore()->getStars());
        $this->assertSame('Good', $this->trustpilot->getTrustScore()->getReadableScore());
        $this->assertSame('//s3-eu-west-1.amazonaws.com/s.trustpilot.com/images/tpelements/stars/s/4.png', $this->trustpilot->getTrustScore()->getImageUrl());
    }
}

class TestableTrustpilot extends Trustpilot
{
    public function __construct()
    {
        //
    }
}
