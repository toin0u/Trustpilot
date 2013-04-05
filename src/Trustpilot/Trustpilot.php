<?php

/**
 * This file is part of the Trustpilot library.
 *
 * (c) Antoine Corcy <contact@sbin.dk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Trustpilot;

use Trustpilot\Category\Category;
use Trustpilot\Review\Review;
use Trustpilot\TrustScore\TrustScore;
use Trustpilot\Time\Time;

/**
 * Trustpilot class.
 *
 * @author Antoine Corcy <contact@sbin.dk>
 */
class Trustpilot extends AbstractTrustpilot
{
    /**
     * Version.
     * @see http://semver.org/
     */
    const VERSION = '0.1.1-dev';


    /**
     * Returns the domain name.
     *
     * @return string
     */
    public function getDomainName()
    {
        return $this->getData()->DomainName;
    }

    /**
     * Returns the Time object of the last feed update.
     *
     * @return Time
     */
    public function getLastUpdate()
    {
        return new Time($this->getData()->FeedUpdateTime);
    }

    /**
     * Returns the url of the Trustpilot page.
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->getData()->ReviewPageUrl;
    }

    /**
     * Returns the total number of reviews.
     *
     * @return integer
     */
    public function getTotalReviews()
    {
        return $this->getData()->ReviewCount->Total;
    }

    /**
     * Returns an array of the number of reviews grouped by number of stars.
     *
     * @return array
     */
    public function getDistributionOverStars()
    {
        return $this->getData()->ReviewCount->DistributionOverStars;
    }

    /**
     * Returns an array of Review object.
     *
     * @return Review[]
     */
    public function getReviews()
    {
        $allReviews = $this->getData()->Reviews;

        foreach ($allReviews as $review) {
            $reviews[] = new Review($review);
        }

        return $reviews;
    }

    /**
     * Returns an array of Category object.
     *
     * @return Category[]
     */
    public function getCategories()
    {
        $allCategories = $this->getData()->Categories;

        foreach ($allCategories as $category) {
            $categories[] = new Category($category);
        }

        return $categories;
    }

    /**
     * Returns the TrustScore object.
     *
     * @return TrustScore
     */
    public function getTrustScore()
    {
        return new TrustScore($this->getData()->TrustScore);
    }
}
