<?php

/**
 * This file is part of the Trustpilot library.
 *
 * (c) Antoine Corcy <contact@sbin.dk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Trustpilot\Tests\Category;

use Trustpilot\Tests\TestCase;
use Trustpilot\Category\Category;

/**
 * @author Antoine Corcy <contact@sbin.dk>
 */
class CategoryTest extends TestCase
{
    protected $category;

    protected function setUp()
    {
        $feed = json_decode(TestCase::FEED);

        $this->category = new Category($feed->Categories[0]);
    }

    public function testGetName()
    {
        $this->assertTrue(is_object($this->category));
        $this->assertInstanceOf('\Trustpilot\Category\Category', $this->category);
        $this->assertSame('Accounting', $this->category->getName());
    }

    public function testGetPosition()
    {
        $this->assertTrue(is_object($this->category));
        $this->assertInstanceOf('\Trustpilot\Category\Category', $this->category);
        $this->assertTrue(is_int($this->category->getPosition()));
        $this->assertSame(3, $this->category->getPosition());
    }

    public function testGetTotalDomain()
    {
        $this->assertTrue(is_object($this->category));
        $this->assertInstanceOf('\Trustpilot\Category\Category', $this->category);
        $this->assertTrue(is_int($this->category->getTotalDomain()));
        $this->assertSame(6, $this->category->getTotalDomain());
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage "foo" is an invalid size please choose between "i100", "i120", "i140", "i180", "i220" and "i280".
     */
    public function testGetImageUrlShouldThrowAnException()
    {
        $this->category->getImageUrl('foo');
    }

    public function testGetImageUrlWithoutArgument()
    {
        $this->assertTrue(is_object($this->category));
        $this->assertInstanceOf('\Trustpilot\Category\Category', $this->category);
        $this->assertSame('//s3-eu-west-1.amazonaws.com/s.trustpilot.com/images/tpelements/category_badge/en_100_3.png', $this->category->getImageUrl());
    }

    /**
     * @dataProvider sizeProvider
     */
    public function testGetImageUrl($size, $expectedUrl)
    {
        $this->assertTrue(is_object($this->category));
        $this->assertInstanceOf('\Trustpilot\Category\Category', $this->category);
        $this->assertSame($expectedUrl, $this->category->getImageUrl($size));
    }

    public function sizeProvider()
    {
        return array(
            array('i100', '//s3-eu-west-1.amazonaws.com/s.trustpilot.com/images/tpelements/category_badge/en_100_3.png'),
            array('i120', '//s3-eu-west-1.amazonaws.com/s.trustpilot.com/images/tpelements/category_badge/en_120_3.png'),
            array('i140', '//s3-eu-west-1.amazonaws.com/s.trustpilot.com/images/tpelements/category_badge/en_140_3.png'),
            array('i180', '//s3-eu-west-1.amazonaws.com/s.trustpilot.com/images/tpelements/category_badge/en_180_3.png'),
            array('i220', '//s3-eu-west-1.amazonaws.com/s.trustpilot.com/images/tpelements/category_badge/en_220_3.png'),
            array('i280', '//s3-eu-west-1.amazonaws.com/s.trustpilot.com/images/tpelements/category_badge/en_280_3.png'),
        );
    }
}
