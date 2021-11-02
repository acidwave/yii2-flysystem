<?php
/**
 * @link https://github.com/acidwave/yii2-flysystem
 * @copyright Copyright (c) 2021 Acid Wave
 * @license http://opensource.org/licenses/BSD-3-Clause
 */

namespace Acidwave\Flysystem;

use Spatie\Dropbox\Client;
use Spatie\FlysystemDropbox\DropboxAdapter;
use yii\base\InvalidConfigException;

/**
 * DropboxFilesystem
 *
 * @author Acid Wave <me@acidwave.ru>
 */
class DropboxFilesystem extends Filesystem
{
    /**
     * @var string
     */
    public $token;
    /**
     * @var string|null
     */
    public $prefix;

    /**
     * @inheritdoc
     */
    public function init()
    {
        if ($this->token === null) {
            throw new InvalidConfigException('The "token" property must be set.');
        }

        parent::init();
    }

    /**
     * @return DropboxAdapter
     */
    protected function prepareAdapter()
    {
        $this->config['case_sensitive'] = false;
        return new DropboxAdapter(
            new Client($this->token),
            $this->prefix
        );
    }
}
