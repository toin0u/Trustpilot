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

use Trustpilot\Httpadapter\HttpAdapterInterface;
use Trustpilot\Httpadapter\CurlHttpAdapter;
use Trustpilot\Cache\CacheInterface;

/**
 * Trustpilot abstract class.
 *
 * @author Antoine Corcy <contact@sbin.dk>
 */
abstract class AbstractTrustpilot
{
    /**
     * The url feed.
     *
     * @var string
     */
    const FEED = 'http://s.trustpilot.com/tpelements/%s/f.json.gz';


    /**
     * The uncompressed data in JSON format.
     *
     * @var string
     */
    protected $data;


    /**
     * Constructor.
     *
     * @param string|int           $id      The site id.
     * @param CacheInterface       $cache   The CacheInterface to use (optional).
     * @param HttpAdapterInterface $adapter The HttpAdapter to use (optional).
     */
    public function __construct($id, CacheInterface $cache = null, HttpAdapterInterface $adapter = null)
    {
        $adapter = $adapter ?: new CurlHttpAdapter();

        if (null !== $cache) {
            $data = $cache->get($id);
            if (!$data) {
                $data = $adapter->getContent(sprintf(self::FEED, $id));
                $cache->set($id, $data);
            }
        } else {
            $data = $adapter->getContent(sprintf(self::FEED, $id));
        }

        $this->setData(json_decode($this->gzdecode($data)));
    }

    /**
     * Set the data result.
     *
     * @param string $data The data result.
     */
    protected function setData($data)
    {
        $this->data = $data;
    }

    /**
     * Get the data result.
     *
     * @return string
     */
    protected function getData()
    {
        return $this->data;
    }

    /**
     * Decode a gzip compressed string.
     *
     * @param string $data A gzip compressed string.
     *
     * @return string
     */
    protected function gzdecode($data)
    {
        return function_exists('gzdecode') ? gzdecode($data) : gzinflate(substr($data, 10, -8));
    }
}
