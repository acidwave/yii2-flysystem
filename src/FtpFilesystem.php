<?php
/**
 * @link https://github.com/acidwave/yii2-flysystem
 * @copyright Copyright (c) 2021 Acid Wave
 * @license http://opensource.org/licenses/BSD-3-Clause
 */

namespace Acidwave\Flysystem;

use League\Flysystem\Ftp\FtpAdapter;
use League\Flysystem\Ftp\FtpConnectionOptions;
use Yii;
use yii\base\InvalidConfigException;

/**
 * FtpFilesystem
 *
 * @author Acid Wave <me@acidwave.ru>
 */
class FtpFilesystem extends Filesystem
{
    /**
     * @var string
     */
    public $host;
    /**
     * @var integer
     */
    public $port;
    /**
     * @var string
     */
    public $username;
    /**
     * @var string
     */
    public $password;
    /**
     * @var boolean
     */
    public $ssl;
    /**
     * @var integer
     */
    public $timeout;
    /**
     * @var string
     */
    public $root;
    /**
     * @var integer
     */
    public $permPrivate;
    /**
     * @var integer
     */
    public $permPublic;
    /**
     * @var boolean
     */
    public $passive;
    /**
     * @var integer
     */
    public $transferMode;
    /**
     * @var bool
     */
    public $enableTimestampsOnUnixListings = false;

    /**
     * @inheritdoc
     */
    public function init()
    {
        if ($this->host === null) {
            throw new InvalidConfigException('The "host" property must be set.');
        }

        if ($this->root === null) {
            throw new InvalidConfigException('The "root" property must be set.');
        }

        if ($this->username === null) {
            throw new InvalidConfigException('The "username" property must be set.');
        }

        if ($this->password === null) {
            throw new InvalidConfigException('The "password" property must be set.');
        }

        $this->root = Yii::getAlias($this->root);

        parent::init();
    }

    /**
     * @return FtpAdapter
     */
    protected function prepareAdapter()
    {
        $config = [];

        foreach ([
            'host',
            'port',
            'username',
            'password',
            'ssl',
            'timeout',
            'root',
            'passive',
            'transferMode',
            'enableTimestampsOnUnixListings',
            'systemType',
        ] as $name) {
            if ($this->$name !== null) {
                $config[$name] = $this->$name;
            }
        }

        return new FtpAdapter(FtpConnectionOptions::fromArray($config));
    }
}
