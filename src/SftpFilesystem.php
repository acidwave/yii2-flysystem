<?php
/**
 * @link https://github.com/acidwave/yii2-flysystem
 * @copyright Copyright (c) 2021 Acid Wave
 * @license http://opensource.org/licenses/BSD-3-Clause
 */

namespace Acidwave\Flysystem;

use League\Flysystem\PhpseclibV2\SftpAdapter;
use League\Flysystem\PhpseclibV2\SftpConnectionProvider;
use League\Flysystem\UnixVisibility\PortableVisibilityConverter;
use Yii;
use yii\base\InvalidConfigException;

/**
 * SftpFilesystem
 *
 * @author Acid Wave <me@acidwave.ru>
 */
class SftpFilesystem extends Filesystem
{
    /**
     * @var string
     */
    public $host;
    /**
     * @var integer
     */
    public $port = 22;
    /**
     * @var string
     */
    public $username;
    /**
     * @var string
     */
    public $password;
    /**
     * @var integer
     */
    public $timeout = 10;
    /**
     * @var string
     */
    public $root;
    /**
     * @var string
     */
    public $privateKey;
    /**
     * @var string
     */
    public $passphrase;
    /**
     * @var integer
     */
    public $dirPrivate = 700;
    /**
     * @var integer
     */
    public $dirPublic = 755;
    /**
     * @var integer
     */
    public $filePrivate = 600;
    /**
     * @var integer
     */
    public $filePublic = 644;
    /**
     * @var bool
     */
    public $useAgent = false;
    /**
     * @inheritdoc
     */
    public function init()
    {
        if ($this->host === null) {
            throw new InvalidConfigException('The "host" property must be set.');
        }

        if ($this->username === null) {
            throw new InvalidConfigException('The "username" property must be set.');
        }

        if ($this->password === null && $this->privateKey === null) {
            throw new InvalidConfigException('Either "password" or "privateKey" property must be set.');
        }

        if ($this->root === null) {
            throw new InvalidConfigException('The "root" property must be set.');
        }

        $this->root = Yii::getAlias($this->root);

        parent::init();
    }

    /**
     * @return SftpAdapter
     */
    protected function prepareAdapter()
    {
        $provider = new SftpConnectionProvider(
            $this->host,
            $this->username,
            $this->password,
            $this->privateKey,
            $this->passphrase,
            $this->port,
            $this->useAgent,
            $this->timeout
        );
        $visibility = PortableVisibilityConverter::fromArray([
            'file' => [
                'public' => $this->filePublic,
                'private' => $this->filePrivate,
            ],
            'dir' => [
                'public' => $this->dirPublic,
                'private' => $this->dirPrivate,
            ],
        ]);
        return new SftpAdapter($provider, $this->root, $visibility);
    }
}
