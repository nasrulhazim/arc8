## About arc8

arc8 is a boilerplate for starting up a new Laravel project, with pre-configured with common packages. see [`composer.json`](composer.json) for list of packages installed.

## Create New Project

```
composer create-project nasrulhazim/arc8 app
```

## Installation

Configure your `.env` accordingly.

Then run `bin/install`.

## Development

There is few pre-built features provided in `arc8`.

```
# Clear all caches
bin/clear-cache

# Apply PHP CS Fixer
bin/clear-cache

# Reload Database
bin/reload-db
```

## Scheduler

Setup the cronjob as following format:

```
* * * * * /path-to-your-project/bin/run-scheduler
```

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
