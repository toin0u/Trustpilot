<?php

/**
 * This file is part of the Trustpilot library.
 *
 * (c) Antoine Corcy <contact@sbin.dk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Trustpilot\Time;

/**
 * Time class.
 *
 * @author Antoine Corcy <contact@sbin.dk>
 */
class Time
{
    /**
     * The uncompressed data in JSON format.
     *
     * @var string
     */
    protected $time;


    /**
     * Constructor.
     *
     * @param string $time The uncompressed data in JSON format.
     */
    public function __construct($time)
    {
        $this->time = $time;
    }

    /**
     * Returns the DateTime object made from the UNIX timestamp.
     *
     * @return \DateTime
     */
    public function getDateTime()
    {
        return new \DateTime('@' . $this->getUnixTime());
    }

    /**
     * Returns the human readable representation of the time localized to the language of the domain.
     * Ex: "4 October 2011 10:16:52 GMT".
     *
     * @return string
     */
    public function getHuman()
    {
        return $this->time->Human;
    }

    /**
     * Returns the UNIX timestamp.
     *
     * @return int
     */
    public function getUnixTime()
    {
        return $this->time->UnixTime;
    }

    /**
     * Returns the human readable representation of the date part of the time localized to the language of the domain.
     * Ex: "15. Oct".
     *
     * @return string
     */
    public function getHumanDate()
    {
        return $this->time->HumanDate;
    }
}
