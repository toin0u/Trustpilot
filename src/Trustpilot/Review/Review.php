<?php

/**
 * This file is part of the Trustpilot library.
 *
 * (c) Antoine Corcy <contact@sbin.dk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Trustpilot\Review;

use Trustpilot\TrustScore\TrustScore;
use Trustpilot\Time\Time;
use Trustpilot\User\User;

/**
 * Review class.
 *
 * @author Antoine Corcy <contact@sbin.dk>
 */
class Review
{
    /**
     * The uncompressed data in JSON format.
     *
     * @var string
     */
    protected $review;


    /**
     * Constructor.
     *
     * @param string $review The uncompressed data in JSON format.
     */
    public function __construct($review)
    {
        $this->review = $review;
    }

    /**
     * Returns the Time object of the review creation.
     *
     * @return Time
     */
    public function getTime()
    {
        return new Time($this->review->Created);
    }

    /**
     * Returns the title of the review.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->review->Title;
    }

    /**
     * Returns the content of the review.
     *
     * @return string
     */
    public function getContent()
    {
        return $this->review->Content;
    }

    /**
     * Return the TrustScore object of the review.
     *
     * @return TrustScore
     */
    public function getTrustScore()
    {
        return new TrustScore($this->review->TrustScore);
    }

    /**
     * Returns the reply content of the company.
     *
     * @return string
     */
    public function getCompanyReply()
    {
        return $this->review->CompanyReply;
    }

    /**
     * Returns the User object of the review.
     *
     * @return User
     */
    public function getUser()
    {
        return new User($this->review->User);
    }

    /**
     * Returns the url of the review.
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->review->Url;
    }

    /**
     * Returns true is the review is verified.
     *
     * @return boolean
     */
    public function isVerified()
    {
        return $this->review->IsVerified;
    }
}
