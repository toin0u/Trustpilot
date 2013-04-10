<?php

/**
 * This file is part of the Trustpilot library.
 *
 * (c) Antoine Corcy <contact@sbin.dk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Trustpilot\Cache;

/**
 * Cache interface.
 *
 * @author Antoine Corcy <contact@sbin.dk>
 */
interface CacheInterface
{
    /**
     * Get the cache data.
     *
     * @param string|integer $id The Trustpilot feed id.
     *
     * @return string|false if the cache is too old or does not exist.
     */
    public function get($id);

    /**
     * Set the cache data.
     *
     * @param string|integer $id   The Trustpilot feed id.
     * @param string         $data The data to cache.
     */
    public function set($id, $data);
}
