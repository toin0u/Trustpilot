<?php

/**
 * This file is part of the Trustpilot library.
 *
 * (c) Antoine Corcy <contact@sbin.dk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Trustpilot\User;

/**
 * User class.
 *
 * @author Antoine Corcy <contact@sbin.dk>
 */
class User
{
    /**
     * The uncompressed data in JSON format.
     *
     * @var string
     */
    protected $user;


    /**
     * Constructor.
     *
     * @param string $user The uncompressed data in JSON format.
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Returns the user name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->user->Name;
    }

    /**
     * Returns the user's city name if any null otherwise.
     *
     * @return string|null
     */
    public function getCity()
    {
        return $this->user->City;
    }

    /**
     * Returns the user's locale.
     *
     * @return string
     */
    public function getLocale()
    {
        return $this->user->Locale;
    }

    /**
     * Returns the total number of reviews written by the user.
     *
     * @return integer
     */
    public function getTotalReviews()
    {
        return $this->user->ReviewCount;
    }

    /**
     * Returns true if the user is verified.
     *
     * @return boolean
     */
    public function isVerified()
    {
        return $this->user->IsVerified;
    }

    /**
     * Returns true if the user has a profile image.
     *
     * @return boolean
     */
    public function hasImage()
    {
        return $this->user->HasImage;
    }

    /**
     * Returns the user's profile image in different sizes.
     * Available sizes are: "i24", "i35", "i64" and "i73".
     * The "i24" size is the default one.
     *
     * @param string $size The size of the image (optional).
     *
     * @return string
     *
     * @throws \InvalidArgumentException
     */
    public function getImageUrl($size = 'i24')
    {
        if (!in_array($size, array('i24', 'i35', 'i64', 'i73'))) {
            throw new \InvalidArgumentException(sprintf(
                '"%s" is an invalid size please choose between "i24", "i35", "i64" and "i73".',
                $size
            ));
        }

        return $this->user->ImageUrls->{$size};
    }
}
