<?php
/**
 * @link https://github.com/acidwave/yii2-flysystem
 * @copyright Copyright (c) 2021 Acid Wave
 * @license http://opensource.org/licenses/BSD-3-Clause
 */

namespace Acidwave\Flysystem;

use League\Flysystem\ZipArchive\FilesystemZipArchiveProvider;
use League\Flysystem\ZipArchive\ZipArchiveAdapter;
use Yii;
use yii\base\InvalidConfigException;

/**
 * ZipArchiveFilesystem
 *
 * @author Acid Wave <me@acidwave.ru>
 */
class ZipArchiveFilesystem extends Filesystem
{
    /**
     * @var string
     */
    public $filename;
    /**
     * @var integer
     */
    public $localDirectoryPermissions = 700;

    /**
     * @inheritdoc
     */
    public function init()
    {
        if ($this->filename === null) {
            throw new InvalidConfigException('The "filename" property must be set.');
        }

        $this->filename = Yii::getAlias($this->filename);

        parent::init();
    }

    /**
     * @return ZipArchiveAdapter
     */
    protected function prepareAdapter()
    {
        $provider = new FilesystemZipArchiveProvider($this->filename, $this->localDirectoryPermissions);
        return new ZipArchiveAdapter($provider);
    }
}
