<?php

/**
 * This file is part of the Trustpilot library.
 *
 * (c) Antoine Corcy <contact@sbin.dk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Trustpilot\Tests\Cache;

use Trustpilot\Tests\TestCase;
use Trustpilot\Cache\File;
use Symfony\Component\Filesystem\Filesystem;

/**
 * @author Antoine Corcy <contact@sbin.dk>
 */
class FileTest extends TestCase
{
    protected $id;
    protected $data;
    protected $tmpPath;

    protected function clean($file)
    {
        if (is_dir($file) && !is_link($file)) {
            $dir = new \FilesystemIterator($file);
            foreach ($dir as $childFile) {
                $this->clean($childFile);
            }

            rmdir($file);
        } else {
            unlink($file);
        }
    }

    protected function setUp()
    {
        $this->id      = 1234;
        $this->data    = 'fake_data';
        $this->tmpPath = sprintf('%s%s', rtrim(sys_get_temp_dir(), DIRECTORY_SEPARATOR), DIRECTORY_SEPARATOR);
    }

    protected function tearDown()
    {
        // $this->clean($this->workspace);
    }

    public function testConstructorCreatesDefaultTemporaryFolder()
    {
        $cache     = new TestableFile();
        $tmpFolder = sprintf('%s%s', $this->tmpPath, File::TEMPORARY_FOLDER_NAME);

        $this->assertEquals(File::CACHE_TIME_LIMIT, $cache->getCacheTimeLimit());
        $this->assertEquals($tmpFolder, $cache->getTemporaryPath());
        $this->assertTrue(is_dir($tmpFolder));

        $this->clean($tmpFolder);
    }

    public function testConstructorWithArguments()
    {
        $cache     = new TestableFile('since yesterday', 'foobarbaz');
        $tmpFolder = sprintf('%s%s', $this->tmpPath, 'foobarbaz');

        $this->assertEquals('since yesterday', $cache->getCacheTimeLimit());
        $this->assertEquals($tmpFolder, $cache->getTemporaryPath());
        $this->assertTrue(is_dir($tmpFolder));

        $this->clean($tmpFolder);
    }

    public function testGetNotCached()
    {
        $cache     = new TestableFile();
        $tmpFolder = sprintf('%s%s', $this->tmpPath, File::TEMPORARY_FOLDER_NAME);
        $tmpFile   = sprintf('%s%s%s', $tmpFolder, DIRECTORY_SEPARATOR, $this->id);

        $this->assertFalse($cache->get($this->id));

        $this->clean($tmpFolder);
    }

    public function testGetCached()
    {
        $cache     = new TestableFile();
        $tmpFolder = sprintf('%s%s', $this->tmpPath, File::TEMPORARY_FOLDER_NAME);
        $tmpFile   = sprintf('%s%s%s', $tmpFolder, DIRECTORY_SEPARATOR, $this->id);

        $cache->set($this->id, $this->data);
        $cached = $cache->get($this->id);

        $this->assertTrue(is_string($cached));
        $this->assertSame($this->data, $cached);

        $this->clean($tmpFolder);
    }

    public function testSet()
    {
        $cache     = new TestableFile();
        $tmpFolder = sprintf('%s%s', $this->tmpPath, File::TEMPORARY_FOLDER_NAME);
        $tmpFile   = sprintf('%s%s%s', $tmpFolder, DIRECTORY_SEPARATOR, $this->id);

        $cache->set($this->id, $this->data);

        $this->assertEquals(File::CACHE_TIME_LIMIT, $cache->getCacheTimeLimit());
        $this->assertEquals($tmpFolder, $cache->getTemporaryPath());
        $this->assertTrue(is_dir($tmpFolder));
        $this->assertTrue(is_file($tmpFile));

        $this->clean($tmpFolder);
    }
}

class TestableFile extends File
{
    public function getCacheTimeLimit()
    {
        return $this->cacheTimeLimit;
    }

    public function getTemporaryPath()
    {
        return $this->temporaryPath;
    }
}
