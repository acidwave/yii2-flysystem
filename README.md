# Flysystem Extension for Yii 2

[![Code Quality](https://img.shields.io/scrutinizer/g/acidwave/yii2-flysystem/master.svg?style=flat-square)](https://scrutinizer-ci.com/g/acidwave/yii2-flysystem/?branch=master)
[![Packagist Version](https://img.shields.io/packagist/v/acidwave/yii2-flysystem.svg?style=flat-square)](https://packagist.org/packages/acidwave/yii2-flysystem)
[![Total Downloads](https://img.shields.io/packagist/dt/acidwave/yii2-flysystem.svg?style=flat-square)](https://packagist.org/packages/acidwave/yii2-flysystem)

This extension provides [Flysystem](http://flysystem.thephpleague.com/) integration for the Yii framework.
[Flysystem](http://flysystem.thephpleague.com/) is a filesystem abstraction which allows you to easily swap out a local filesystem for a remote one.

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```bash
$ composer require acidwave/yii2-flysystem
```

or add

```
"acidwave/yii2-flysystem": "1.0.*"
```

to the `require` section of your `composer.json` file.

## Configuring

### Local filesystem

Configure application `components` as follows

```php
return [
    //...
    'components' => [
        //...
        'fs' => [
            'class' => 'Acidwave\Flysystem\LocalFilesystem',
            'path' => '@webroot/files',
        ],
    ],
];
```

### FTP filesystem

Configure application `components` as follows

```php
return [
    //...
    'components' => [
        //...
        'ftpFs' => [
            'class' => 'Acidwave\Flysystem\FtpFilesystem',
            'host' => 'ftp.example.com',
            // 'port' => 21,
            'username' => 'your-username',
            'password' => 'your-password',
            // 'ssl' => true,
            // 'timeout' => 60,
            'root' => '/path/to/root',
            // 'passive' => false,
            // 'transferMode' => FTP_TEXT,
            // 'enableTimestampsOnUnixListings' => false,
            // 'systemType' => null, // 'windows' or 'unix'
        ],
    ],
];
```

### AWS S3 filesystem

Either run

```bash
$ composer require league/flysystem-aws-s3-v3
```

or add

```
"league/flysystem-aws-s3-v3": "^2.0"
```

to the `require` section of your `composer.json` file and configure application `components` as follows

```php
return [
    //...
    'components' => [
        //...
        'awss3Fs' => [
            'class' => 'Acidwave\Flysystem\AwsS3Filesystem',
            'key' => 'your-key',
            'secret' => 'your-secret',
            'bucket' => 'your-bucket',
            'region' => 'your-region',
            // 'version' => 'latest',
            // 'baseUrl' => 'your-base-url',
            // 'prefix' => 'your-prefix',
            // 'visibility' => \League\Flysystem\Visibility::PUBLIC,
            // 'endpoint' => 'http://my-custom-url'
        ],
    ],
];
```

### Dropbox filesystem

Either run

```bash
$ composer require league/flysystem-dropbox
```

or add

```
"league/flysystem-dropbox": "^2.0"
```

to the `require` section of your `composer.json` file and configure application `components` as follows

```php
return [
    //...
    'components' => [
        //...
        'dropboxFs' => [
            'class' => 'Acidwave\Flysystem\DropboxFilesystem',
            'token' => 'your-token',
            // 'prefix' => 'your-prefix',
        ],
    ],
];
```

### SFTP filesystem

Either run

```bash
$ composer require league/flysystem-sftp
```

or add

```
"league/flysystem-sftp": "^2.0"
```

to the `require` section of your `composer.json` file and configure application `components` as follows

```php
return [
    //...
    'components' => [
        //...
        'sftpFs' => [
            'class' => 'Acidwave\Flysystem\SftpFilesystem',
            'host' => 'sftp.example.com',
            // 'port' => 22,
            'username' => 'your-username',
            'password' => 'your-password',
            'privateKey' => '/path/to/or/contents/of/privatekey',
            'passphrase' => 'my-super-secret-passphrase-for-the-private-key',
            // 'useAgent' => false,
            // 'timeout' => 60,
            'root' => '/path/to/root',
            // 'dirPrivate' => 0700,
            // 'dirPublic' => 0755,
            // 'filePrivate' => 0600,
            // 'filePublic' => 0644,
        ],
    ],
];
```

### ZipArchive filesystem

Either run

```bash
$ composer require league/flysystem-ziparchive
```

or add

```
"league/flysystem-ziparchive": "^2.0"
```

to the `require` section of your `composer.json` file and configure application `components` as follows

```php
return [
    //...
    'components' => [
        //...
        'ziparchiveFs' => [
            'class' => 'Acidwave\Flysystem\ZipArchiveFilesystem',
            'filename' => '@webroot/files/archive.zip',
            // 'localDirectoryPermissions' => 700,
        ],
    ],
];
```

### Global visibility settings

Configure `fsID` application component as follows

```php
return [
    //...
    'components' => [
        //...
        'fsID' => [
            //...
            'config' => [
                'visibility' => \League\Flysystem\Visibility::PRIVATE,
            ],
        ],
    ],
];
```

## Usage

### Writing files

To write file

```php
Yii::$app->fs->write('filename.ext', 'contents');
```

To write file using stream contents

```php
$stream = fopen('/path/to/somefile.ext', 'r+');
Yii::$app->fs->writeStream('filename.ext', $stream);
```

### Reading files

To read file

```php
$contents = Yii::$app->fs->read('filename.ext');
```

To retrieve a read-stream

```php
$stream = Yii::$app->fs->readStream('filename.ext');
$contents = stream_get_contents($stream);
fclose($stream);
```

### Checking if a file exists

To check if a file exists

```php
$exists = Yii::$app->fs->fileExists('filename.ext');
```

### Deleting files

To delete file

```php
Yii::$app->fs->delete('filename.ext');
```

### Renaming files

To rename file

```php
Yii::$app->fs->move('filename.ext', 'newname.ext');
```

### Getting files mimetype

To get file mimetype

```php
$mimetype = Yii::$app->fs->mimeType('filename.ext');
```

### Getting files timestamp

To get file timestamp

```php
$timestamp = Yii::$app->fs->lastModified('filename.ext');
```

### Getting files size

To get file size

```php
$timestamp = Yii::$app->fs->fileSize('filename.ext');
```

### Creating directories

To create directory

```php
Yii::$app->fs->createDirectory('path/to/directory');
```

Directories are also made implicitly when writing to a deeper path

```php
Yii::$app->fs->write('path/to/filename.ext');
```

### Deleting directories

To delete directory

```php
Yii::$app->fs->deleteDirectory('path/to/filename.ext');
```

### Managing visibility

Visibility is the abstraction of file permissions across multiple platforms. Visibility can be either public or private.

```php
use League\Flysystem\Visibility;

Yii::$app->fs->write('filename.ext', 'contents', [
    'visibility' => Visibility::PRIVATE
]);
```

You can also change and check visibility of existing files

```php
use League\Flysystem\Visibility;

if (Yii::$app->fs->visibility('filename.ext') === Visibility::PRIVATE) {
    Yii::$app->fs->setVisibility('filename.ext', Visibility::PUBLIC);
}
```

### Listing contents

To list contents

```php
$contents = Yii::$app->fs->listContents('path/to/directory');

foreach ($contents as $object) {
    echo basename($object->path())
        . ' is located at' . $object->path()
        . ' and is a ';
    if ($object instanceof \League\Flysystem\FileAttributes) {
        echo 'file' . PHP_EOF;
    } elseif ($object instanceof \League\Flysystem\DirectoryAttributes) {
        echo 'directory' . PHP_EOF;
    }
}
```

By default Flysystem lists the top directory non-recursively. You can supply a directory name and recursive boolean to get more precise results

```php
$contents = Yii::$app->fs->listContents('path/to/directory', true);
```

## Donating

Support this project and [others by acidwave](https://liberapay.com/acidwave/) via [Liberapay](https://liberapay.com/acidwave/).

[![Support via Liberapay](https://liberapay.com/assets/widgets/donate.svg)](https://liberapay.com/acidwave/)
