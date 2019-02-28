# LightService

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

Php port for https://github.com/adomokos/light-service


## Install

Via Composer

``` bash
$ composer require crojasaragonez/light-service
```

## Usage

``` php
require_once 'vendor/autoload.php';

use crojasaragonez\LightService\Action;
use crojasaragonez\LightService\Organizer;

class FileOps extends Organizer
{
    public function __construct(array $context = [])
    {
        parent::__construct($context);
    }
}

class CreateTmpFile extends Action
{
    public $promises = ['file_path'];
    public function execute()
    {
        $this->context['file_path'] = tempnam(sys_get_temp_dir(), 'img_') . '.png';
    }
}

class Download extends Action
{
    public $expects  = ['url', 'file_path'];
    public function execute()
    {
        if (!@file_put_contents($this->context['file_path'], file_get_contents($this->context['url']))) {
            $this->skipRemaining();
        }
    }
}

class ZipFile extends Action
{
    public $expects  = ['file_path'];
    public $promises = ['zip_path'];
    public function execute()
    {
        $zip_path = str_replace('.png', '.zip', $this->context['file_path']);
        $zip = new ZipArchive();
        $zip->open($zip_path, ZipArchive::CREATE);
        $zip->addFile($this->context['file_path'], basename($this->context['file_path']));
        $zip->close();
        $this->context['zip_path'] = $zip_path;
    }
}

$organizer = new FileOps(['url' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/2/27/PHP-logo.svg/100px-PHP-logo.svg.png']);
$result = $organizer->reduce([
  CreateTmpFile::class,
  Download::class,
  ZipFile::class
]);

print_r($result);
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CODE_OF_CONDUCT](CODE_OF_CONDUCT.md) for details.

## Security

If you discover any security related issues, please email crojas@go-labs.net instead of using the issue tracker.

## Credits

- [Carlos Luis Rojas Aragonés][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/crojasaragonez/light-service.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/crojasaragonez/light-service/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/crojasaragonez/light-service.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/crojasaragonez/light-service.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/crojasaragonez/light-service.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/crojasaragonez/light-service
[link-travis]: https://travis-ci.org/crojasaragonez/light-service
[link-scrutinizer]: https://scrutinizer-ci.com/g/crojasaragonez/light-service/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/crojasaragonez/light-service
[link-downloads]: https://packagist.org/packages/crojasaragonez/light-service
[link-author]: https://github.com/crojasaragonez
[link-contributors]: ../../contributors
