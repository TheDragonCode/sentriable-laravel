# Sentriable Laravel

[sentry/sentry-laravel](https://github.com/getsentry/sentry-laravel) package extension

![cover](https://camo.githubusercontent.com/2dfeafbee0904d6df16ddf7200993dace1629e60/68747470733a2f2f73656e7472792d6272616e642e73746f726167652e676f6f676c65617069732e636f6d2f73656e7472792d6c6f676f2d626c61636b2e706e67)


[![StyleCI Status][badge_styleci]][link_styleci]
[![Stable Version][badge_stable]][link_packagist]
[![Unstable Version][badge_unstable]][link_packagist]
[![Total Downloads][badge_downloads]][link_packagist]
[![License][badge_license]][link_license]


## Installation

To get the latest version, simply require the project using [Composer](https://getcomposer.org):

```bash
$ composer require andrey-helldar/sentriable-laravel
```

Or manually update `require` block of `composer.json` and run `composer update`.

```json
{
    "require": {
        "andrey-helldar/sentriable-laravel": "^1.0"
    }
}
```


#### Lumen

This package is focused on Laravel development, but it can also be used in Lumen with some workarounds. Because Lumen works a little different, as it is like a barebone version of Laravel and the main configuration parameters are instead located in `bootstrap/app.php`, some alterations must be made.

You can install Laravel Lang Publisher in `app/Providers/AppServiceProvider.php`, and uncommenting this line that registers the App Service Providers so it can properly load.

```
// $app->register(App\Providers\AppServiceProvider::class);
```

If you are not using that line, that is usually handy to manage gracefully multiple Lumen installations, you will have to add this line of code under the `Register Service Providers` section of your `bootstrap/app.php`.

```php
if ($app->environment() !== 'production') {
    $app->register(\Helldar\Sentry\ServiceProvider::class);
}
```


## How to use

Add Sentry reporting to `App/Exceptions/Handler.php`.

### For Laravel 7.x and later

```php
use Helldar\Sentry\Traits\Sentriable;

public function report(\Throwable $exception)
{
    parent::report($exception);

    if ($this->shouldReport($e)) {
        $this->sentryException($e);
    }
}
```

### For Laravel 6.x

```php
use Helldar\Sentry\Traits\Sentriable;

public function report(\Exception $exception)
{
    parent::report($exception);

    if ($this->shouldReport($e)) {
        $this->sentryException($e);
    }
}
```

For more information on configuring the Sentry package, see [here](https://docs.sentry.io/platforms/php/laravel).

### Using code elsewhere

```php
use Helldar\Sentry\Traits\Sentriable;

protected function handle()
{
    try {
        // some code
    } catch (\Throwable $e) {
        $this->sentryException($e);
    }
}
```

### Use in loops with flushing
```php
use Helldar\Sentry\Traits\Sentriable;

protected function handle()
{
    foreach ($this->values as $item) {
        try {
            $this->sentryFlush();
        
            // some code
        } catch (\Throwable $e) {
            $this->sentryException($e);
        }
    }
}
```

### Versioning

To get the current version of the application, run the command `php artisan git:version`.

If a tag is set on the current commit, it will be passed in the `release` field of the Sentry, otherwise the sha of the current commit will be taken.

It is better to do this once when deploying the application.


## Credits

- [Andrey Helldar][link_author]
- [![All contributors][badge_contributors]][link_contributors]


[badge_contributors]:   https://img.shields.io/github/contributors/andrey-helldar/sentriable-laravel?style=flat-square
[badge_downloads]:      https://img.shields.io/packagist/dt/andrey-helldar/sentriable-laravel.svg?style=flat-square
[badge_license]:        https://img.shields.io/packagist/l/andrey-helldar/sentriable-laravel.svg?style=flat-square
[badge_stable]:         https://img.shields.io/github/v/release/andrey-helldar/sentriable-laravel?label=stable&style=flat-square
[badge_styleci]:        https://styleci.io/repos/283724960/shield
[badge_unstable]:       https://img.shields.io/badge/unstable-dev--master-orange?style=flat-square

[link_author]:          https://github.com/andrey-helldar
[link_contributors]:    https://github.com/andrey-helldar/sentriable-laravel/graphs/contributors
[link_license]:         LICENSE
[link_packagist]:       https://packagist.org/packages/andrey-helldar/sentriable-laravel
[link_styleci]:         https://github.styleci.io/repos/283724960
