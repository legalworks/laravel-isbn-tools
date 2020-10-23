# legalworks/laravel-isbn-tools

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Build Status][ico-travis]][link-travis]

This package allows casting and validation of ISBN in Laravel Eloquent models, usind the [nicebooks/isbn](https://github.com/nicebooks-com/isbn)-package.

## Installation

Via Composer

``` bash
$ composer require legalworks/laravel-isbn-tools
```

## Usage

### Casting

``` php
use Legalworks\IsbnTools\IsbnCast;

protected $casts = [
    'isbn' => IsbnCast::class,
];
```

### Validation

``` php
use Legalworks\IsbnTools\IsbnValidator;

$request->validate([
    'isbn' => ['required', 'string', new IsbnValidator],
]);
```

## Change log

Please see the [changelog](changelog.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [contributing.md](contributing.md) for details and a todolist.

## Security

If you discover any security related issues, please email author email instead of using the issue tracker.

## Credits

- [author name][link-author]
- [All Contributors][link-contributors]

## License

license. Please see the [license file](license.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/legalworks/laravelisbntools.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/legalworks/laravelisbntools.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/legalworks/laravelisbntools/master.svg?style=flat-square
[ico-styleci]: https://styleci.io/repos/12345678/shield

[link-packagist]: https://packagist.org/packages/legalworks/laravelisbntools
[link-downloads]: https://packagist.org/packages/legalworks/laravelisbntools
[link-travis]: https://travis-ci.org/legalworks/laravelisbntools
[link-styleci]: https://styleci.io/repos/12345678
[link-author]: https://github.com/legalworks
[link-contributors]: ../../contributors
