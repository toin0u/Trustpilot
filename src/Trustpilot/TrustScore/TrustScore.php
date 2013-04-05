<?php

/**
 * This file is part of the Trustpilot library.
 *
 * (c) Antoine Corcy <contact@sbin.dk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Trustpilot\TrustScore;

/**
 * TrustScore class.
 *
 * @author Antoine Corcy <contact@sbin.dk>
 */
class TrustScore
{
    /**
     * The uncompressed data in JSON format.
     *
     * @var string
     */
    protected $trustScore;


    /**
     * Constructor.
     *
     * @param string $trustScore The uncompressed data in JSON format.
     */
    public function __construct($trustScore)
    {
        $this->trustScore = $trustScore;
    }

    /**
     * Returns the trust score from 0 to 100.
     *
     * @return integer
     */
    public function getScore()
    {
        return $this->trustScore->Score;
    }

    /**
     * Returns the trust score in stars from 1 to 5.
     *
     * @return integer
     */
    public function getStars()
    {
        return $this->trustScore->Stars;
    }

    /**
     * Returns the human readable trust score localized to the language of the domain.
     *
     * @return string
     */
    public function getReadableScore()
    {
        return $this->trustScore->Human;
    }

    /**
     * Returns the url of the image which shows the number of stars.
     * Available sizes are: "small", "medium" and "large".
     * The "medium" size is the default one.
     *
     * @param string $size The size of the image, small, medium or large (optional).
     *
     * @return string
     *
     * @throws \InvalidArgumentException
     */
    public function getImageUrl($size = 'small')
    {
        if (!in_array($size, array('small', 'medium', 'large'))) {
            throw new \InvalidArgumentException(sprintf(
                '"%s" is an invalid size please choose between "small", "medium" and "large".',
                $size
            ));
        }

        return $this->trustScore->StarsImageUrls->{$size};
    }
}
