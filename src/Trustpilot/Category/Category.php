<?php

/**
 * This file is part of the Trustpilot library.
 *
 * (c) Antoine Corcy <contact@sbin.dk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Trustpilot\Category;

/**
 * Category class.
 *
 * @author Antoine Corcy <contact@sbin.dk>
 */
class Category
{
    /**
     * The uncompressed data in JSON format.
     *
     * @var string
     */
    protected $category;


    /**
     * Constructor.
     *
     * @param string $category The uncompressed data in JSON format.
     */
    public function __construct($category)
    {
        $this->category = $category;
    }

    /**
     * Returns the category name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->category->Name;
    }

    /**
     * Returns the position number in the category.
     *
     * @return integer
     */
    public function getPosition()
    {
        return $this->category->Position;
    }

    /**
     * Returns the amount of domains in the category.
     *
     * @return integer
     */
    public function getTotalDomain()
    {
        return $this->category->Count;
    }

    /**
     * Returns the url to image showing the position of the domain in the category, e.g. in the top 3.
     * Available sizes are: "i100", "i120", "i140", "i180", "i220", "i280" for the six different pixel sizes.
     * The "i100" size is the default one.
     *
     * @param string $size The width or the image (optional).
     *
     * @return string
     *
     * @throws \InvalidArgumentException
     */
    public function getImageUrl($size = 'i100')
    {
        if (!in_array($size, array('i100', 'i120', 'i140', 'i180', 'i220', 'i280'))) {
            throw new \InvalidArgumentException(sprintf(
                '"%s" is an invalid size please choose between "i100", "i120", "i140", "i180", "i220" and "i280".',
                $size
            ));
        }

        return $this->category->ImageUrls->{$size};
    }
}
