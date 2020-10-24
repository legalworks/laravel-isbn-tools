# legalworks/laravel-isbn-tools

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![License](https://img.shields.io/badge/license-MIT-blue.svg)](http://opensource.org/licenses/MIT)

This package allows casting and validation of ISBN in Laravel Eloquent models, using the [nicebooks/isbn](https://github.com/nicebooks-com/isbn)-library.

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

- [JayAhr][link-author]
- [All Contributors][link-contributors]

## License

license. Please see the [license file](license.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/legalworks/laravel-isbn-tools.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/legalworks/laravel-isbn-tools.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/legalworks/laravel-isbn-tools
[link-downloads]: https://packagist.org/packages/legalworks/laravel-isbn-tools
[link-author]: https://github.com/legalworks
[link-contributors]: ../../contributors
