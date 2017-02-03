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

use Symfony\Component\Finder\Finder;
use Symfony\Component\Filesystem\Filesystem;

/**
 * File cache class.
 *
 * @author Antoine Corcy <contact@sbin.dk>
 */
class File implements CacheInterface
{
    /**
     * The default temporary folder name.
     *
     * @var string
     */
    const TEMPORARY_FOLDER_NAME = 'trustpilot';

    /**
     * The time limit to use the cached file.
     *
     * @see http://api.symfony.com/2.2/Symfony/Component/Finder/Finder.html#method_date
     *
     * @var string
     */
    const CACHE_TIME_LIMIT = '> now - 3 hours';


    /**
     * The temporary path.
     *
     * @var string
     */
    protected $temporaryPath;

    /**
     * The time limit to use the cached file.
     *
     * @var string
     */
    protected $cacheTimeLimit;


    /**
     * Constructor.
     * Set variables and create the temporary folder if it does not exist.
     *
     * @param string $cacheTimeLimit      The time limit to use the cached file (optional).
     * @param string $temporaryFolderName The temporary folder name (optional).
     */
    public function __construct($cacheTimeLimit = self::CACHE_TIME_LIMIT, $temporaryFolderName = self::TEMPORARY_FOLDER_NAME)
    {
        $this->cacheTimeLimit = $cacheTimeLimit;
        if (substr($temporaryFolderName, 0, 1) == '/') {
            $this->temporaryPath = $temporaryFolderName;
        } else {
            $this->temporaryPath = sprintf(
                '%s%s%s',
                rtrim(sys_get_temp_dir(), DIRECTORY_SEPARATOR), DIRECTORY_SEPARATOR, $temporaryFolderName
            );
        }

        $fs = new Filesystem();
        if (!$fs->exists($this->temporaryPath)) {
            $fs->mkdir($this->temporaryPath);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function get($id)
    {
        $finder = new Finder();
        $finder->files()->in($this->temporaryPath)->name((string) $id)->date($this->cacheTimeLimit);

        foreach ($finder as $file) {
            return $file->getContents();
        }

        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function set($id, $data)
    {
        file_put_contents(sprintf('%s%s%s', $this->temporaryPath, DIRECTORY_SEPARATOR, $id), $data);
    }
}
