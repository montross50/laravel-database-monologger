## Laravel Monolog MySQL Handler.

[![Latest Version on Packagist][ico-version]](https://packagist.org/packages/montross50/laravel-monolog-mysql)
[![Software License][ico-license]](LICENSE.md)
[![Build Status](https://img.shields.io/travis/montross50/laravel-monolog-mysql.svg?branch=master&style=flat-square)](https://travis-ci.org/montross50/laravel-monolog-mysql)
[![Total Downloads](https://img.shields.io/packagist/dt/montross50/laravel-monolog-mysql.svg?style=flat-square)](https://packagist.org/packages/montross50/laravel-monolog-mysql)

This package will log errors into MySQL database instead storage/log/laravel.log file.

### Installation

~~~
composer require montross50/monolog-mysql
~~~

Open up `composer.json` and add the following or add the this to the existing providers.

~~~
"extra": {
        "laravel": {
            "providers": [
                "Logger\\Laravel\\Provider\\MonologMysqlHandlerServiceProvider"
            ]
        }
    }
~~~


Migrate tables.

~~~
php artisan migrate
~~~

## Application Integration

In your application `bootstrap/app.php` add:

~~~php

~~~

## Environment configuration

If you wish to change default table name to write the log into or database connection use following definitions in your .env file

~~~
DB_LOG_TABLE=laravel_logs
DB_LOG_CONNECTION=mysql
~~~

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.

## Security

If you discover any security related issues, please email sch43228@gmail.com instead of using the issue tracker.

## Credits

- Trent Schmidt
Based on:
- [Mark Hilton] (https://github.com/markhilton/monolog-mysql)
- [Pedro Fornaza] (https://github.com/pedrofornaza/monolog-mysql)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/montross50/laravel-monolog-mysql.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/montross50/laravel-monolog-mysql/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/montross50/laravel-monolog-mysql.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/montross50/laravel-monolog-mysql.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/montross50/laravel-monolog-mysql.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/montross50/laravel-monolog-mysql
[link-travis]: https://travis-ci.org/montross50/laravel-monolog-mysql
[link-scrutinizer]: https://scrutinizer-ci.com/g/montross50/laravel-monolog-mysql/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/montross50/laravel-monolog-mysql
[link-downloads]: https://packagist.org/packages/montross50/laravel-monolog-mysql
[link-author]: https://github.com/montross50
[link-contributors]: ../../contributors




