## Laravel Monolog MySQL Handler.

[![Latest Version on Packagist][ico-version]](https://packagist.org/packages/montross50/laravel-database-monologger)
[![Software License][ico-license]](LICENSE.md)
[![Build Status](https://img.shields.io/travis/montross50/laravel-database-monologger.svg?branch=master&style=flat-square)](https://travis-ci.org/montross50/laravel-database-monologger)
[![Total Downloads](https://img.shields.io/packagist/dt/montross50/laravel-database-monologger.svg?style=flat-square)](https://packagist.org/packages/montross50/laravel-database-monologger)

This package will log errors into a database instead storage/log/laravel.log file.

### Installation

~~~
composer require montross50/laravel-database-monologger
~~~

Migrate tables.

~~~
php artisan migrate
~~~

## Application Integration

In your application `config/logging.php` add the following to the channels array:

~~~php
 'database' => [
     'driver' => 'custom',
     'via' => Montross50\DatabaseLogger\CreateDatabaseLogger::class,
     'level' => Monolog\Logger::DEBUG \\optional
  ]
~~~

## Environment configuration

If you wish to change default table name to write the log into or database connection use following definitions in your .env file

~~~
DB_LOG_TABLE=laravel_logs
DB_LOG_CONNECTION=mysql
APP_LOG_NAME=YOUR_APP_NAME
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

[ico-version]: https://img.shields.io/packagist/v/montross50/laravel-database-monologger.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/montross50/laravel-database-monologger/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/montross50/laravel-database-monologger.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/montross50/laravel-database-monologger.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/montross50/laravel-database-monologger.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/montross50/laravel-database-monologger
[link-travis]: https://travis-ci.org/montross50/laravel-database-monologger
[link-scrutinizer]: https://scrutinizer-ci.com/g/montross50/laravel-database-monologger/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/montross50/laravel-database-monologger
[link-downloads]: https://packagist.org/packages/montross50/laravel-database-monologger
[link-author]: https://github.com/montross50
[link-contributors]: ../../contributors




