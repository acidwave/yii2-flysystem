<?php
/**
 * @link https://github.com/acidwave/yii2-flysystem
 * @copyright Copyright (c) 2021 Acid Wave
 * @license http://opensource.org/licenses/BSD-3-Clause
 */

namespace Acidwave\Flysystem;

use League\Flysystem\Local\LocalFilesystemAdapter;
use Yii;
use yii\base\InvalidConfigException;

/**
 * LocalFilesystem
 *
 * @author Acid Wave <me@acidwave.ru>
 */
class LocalFilesystem extends Filesystem
{
    /**
     * @var string
     */
    public $path;

    /**
     * @inheritdoc
     */
    public function init()
    {
        if ($this->path === null) {
            throw new InvalidConfigException('The "path" property must be set.');
        }

        $this->path = Yii::getAlias($this->path);

        parent::init();
    }

    /**
     * @return LocalFilesystemAdapter
     */
    protected function prepareAdapter()
    {
        return new LocalFilesystemAdapter($this->path);
    }
}
