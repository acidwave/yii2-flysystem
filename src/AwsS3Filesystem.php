<?php
/**
 * @link https://github.com/acidwave/yii2-flysystem
 * @copyright Copyright (c) 2021 Acid Wave
 * @license http://opensource.org/licenses/BSD-3-Clause
 */

namespace Acidwave\Flysystem;

use Aws\S3\S3Client;
use League\Flysystem\Visibility;
use yii\base\InvalidConfigException;
use League\Flysystem\AwsS3V3\AwsS3V3Adapter;
use League\Flysystem\AwsS3V3\PortableVisibilityConverter;

/**
 * AwsS3Filesystem
 *
 * @author Acid Wave <me@acidwave.ru>
 */
class AwsS3Filesystem extends Filesystem
{
    /**
     * @var string
     */
    public $key;
    /**
     * @var string
     */
    public $secret;
    /**
     * @var string
     */
    public $region;
    /**
     * @var string
     */
    public $baseUrl;
    /**
     * @var string
     */
    public $version;
    /**
     * @var string
     */
    public $bucket;
    /**
     * @var string|null
     */
    public $prefix;
    /**
     * @var bool
     */
    public $pathStyleEndpoint = false;
    /**
     * @var string
     */
    public $visibility = Visibility::PUBLIC;
    /**
     * @var bool
     */
    public $streamReads = false;
    /**
     * @var string
     */
    public $endpoint;
    /**
     * @var array|\Aws\CacheInterface|\Aws\Credentials\CredentialsInterface|bool|callable
     */
    public $credentials;

    /**
     * @inheritdoc
     */
    public function init()
    {
        if ($this->credentials === null) {
            if ($this->key === null) {
                throw new InvalidConfigException('The "key" property must be set.');
            }

            if ($this->secret === null) {
                throw new InvalidConfigException('The "secret" property must be set.');
            }
        }

        if ($this->bucket === null) {
            throw new InvalidConfigException('The "bucket" property must be set.');
        }

        parent::init();
    }

    /**
     * @return AwsS3V3Adapter
     */
    protected function prepareAdapter()
    {
        $config = [];

        if ($this->credentials === null) {
            $config['credentials'] = ['key' => $this->key, 'secret' => $this->secret];
        } else {
            $config['credentials'] = $this->credentials;
        }


        if ($this->pathStyleEndpoint === true) {
            $config['use_path_style_endpoint'] = true;
        }

        if ($this->region !== null) {
            $config['region'] = $this->region;
        }

        if ($this->baseUrl !== null) {
            $config['base_url'] = $this->baseUrl;
        }

        if ($this->endpoint !== null) {
            $config['endpoint'] = $this->endpoint;
        }

        $config['version'] = (($this->version !== null) ? $this->version : 'latest');

        $client = new S3Client($config);

        return new AwsS3V3Adapter(
            $client,
            $this->bucket,
            $this->prefix,
            new PortableVisibilityConverter(
                $this->visibility
            )
        );
    }
}
