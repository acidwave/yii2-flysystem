<?php
/**
 * @link https://github.com/acidwave/yii2-flysystem
 * @copyright Copyright (c) 2021 Acid Wave
 * @license http://opensource.org/licenses/BSD-3-Clause
 */

namespace Acidwave\Flysystem;

use League\Flysystem\FilesystemAdapter;
use League\Flysystem\Filesystem as NativeFilesystem;
use Yii;
use yii\base\Component;

/**
 * Filesystem
 *
 * @method \League\Flysystem\FilesystemInterface addPlugin(\League\Flysystem\PluginInterface $plugin)
 * @method void assertAbsent(string $path)
 * @method void assertPresent(string $path)
 * @method void copy(string $path, string $newpath, array $config = null)
 * @method void createDirectory(string $dirname, array $config = null)
 * @method boolean delete(string $path)
 * @method boolean deleteDirectory(string $dirname)
 * @method \League\Flysystem\Handler get(string $path, \League\Flysystem\Handler $handler = null)
 * @method \League\Flysystem\FilesystemAdapter getAdapter()
 * @method \League\Flysystem\Config getConfig()
 * @method string mimeType(string $path)
 * @method integer fileSize(string $path)
 * @method integer lastModified(string $path)
 * @method string visibility(string $path)
 * @method array getWithMetadata(string $path, array $metadata)
 * @method boolean fileExists(string $path)
 * @method \League\Flysystem\DirectoryListing listContents(string $directory = '', boolean $recursive = false)
 * @method array listFiles(string $path = '', boolean $recursive = false)
 * @method array listPaths(string $path = '', boolean $recursive = false)
 * @method array listWith(array $keys = [], $directory = '', $recursive = false)
 * @method string read(string $path)
 * @method resource readStream(string $path)
 * @method void move(string $path, string $newpath, array $config = null)
 * @method void setVisibility(string $path, string $visibility)
 * @method boolean write(string $path, string $contents, array $config = [])
 * @method boolean writeStream(string $path, resource $resource, array $config = [])
 *
 * @author Acid Wave <me@acidwave.ru>
 */
abstract class Filesystem extends Component
{
    /**
     * @var \League\Flysystem\Config|array|string|null
     */
    public $config;
    /**
     * @var \League\Flysystem\Filesystem
     */
    protected $filesystem;

    /**
     * @inheritdoc
     */
    public function init()
    {
        $adapter = $this->prepareAdapter();
        $this->filesystem = new NativeFilesystem($adapter, $this->config);
    }

    /**
     * @return FilesystemAdapter
     */
    abstract protected function prepareAdapter();

    /**
     * @param string $method
     * @param array $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return call_user_func_array([$this->filesystem, $method], $parameters);
    }

    /**
     * @return \League\Flysystem\Filesystem
     */
    public function getFilesystem()
    {
        return $this->filesystem;
    }
}
