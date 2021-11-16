# Sentriable Laravel

<img src="https://preview.dragon-code.pro/TheDragonCode/sentriable-laravel.svg?brand=sentry" alt="Sentriable Laravel"/>

[![Stable Version][badge_stable]][link_packagist]
[![Unstable Version][badge_unstable]][link_packagist]
[![Total Downloads][badge_downloads]][link_packagist]
[![License][badge_license]][link_license]


## Installation

To get the latest version, simply require the project using [Composer](https://getcomposer.org):

```bash
$ composer require dragon-code/sentriable-laravel
```

Or manually update `require` block of `composer.json` and run `composer update`.

```json
{
    "require": {
        "dragon-code/sentriable-laravel": "^2.0"
    }
}
```

### Upgrade from `andrey-helldar/sentriable-laravel`

1. Replace `"andrey-helldar/sentriable-laravel": "^1.0"` with `"dragon-code/sentriable-laravel": "^2.0"` in the `composer.json` file;
2. Replace `Helldar\Sentry` namespace prefix with `DragonCode\Sentry`;
3. Call the `composer update` console command.

### Lumen

This package is focused on Laravel development, but it can also be used in Lumen with some workarounds. Because Lumen works a little different, as it is like a barebone version of
Laravel and the main configuration parameters are instead located in `bootstrap/app.php`, some alterations must be made.

You can install Laravel Lang Publisher in `app/Providers/AppServiceProvider.php`, and uncommenting this line that registers the App Service Providers so it can properly load.

```
// $app->register(App\Providers\AppServiceProvider::class);
```

If you are not using that line, that is usually handy to manage gracefully multiple Lumen installations, you will have to add this line of code under
the `Register Service Providers` section of your `bootstrap/app.php`.

```php
$app->register(\DragonCode\Sentry\ServiceProvider::class);
```

## How to use

Add Sentry reporting to `App/Exceptions/Handler.php`.

### For Laravel 7.x and later

```php
use DragonCode\Sentry\Traits\Sentriable;
use Throwable;

public function report(Throwable $exception)
{
    parent::report($exception);

    if ($this->shouldReport($e)) {
        $this->sentryException($e);
    }
}
```

### For Laravel 6.x

```php
use DragonCode\Sentry\Traits\Sentriable;
use Exception;

public function report(Exception $exception)
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
use DragonCode\Sentry\Traits\Sentriable
use Throwable;

protected function handle()
{
    try {
        // some code
    } catch (Throwable $e) {
        $this->sentryException($e);
    }
}
```

### Use in loops with flushing

```php
use DragonCode\Sentry\Traits\Sentriable;
use Throwable;

protected function handle()
{
    foreach ($this->values as $item) {
        try {
            $this->sentryFlush();
        
            // some code
        } catch (Throwable $e) {
            $this->sentryException($e);
        }
    }
}
```

### Versioning

To get the current version of the application, run the command `php artisan git:version`.

If a tag is set on the current commit, it will be passed in the `release` field of the Sentry, otherwise the sha of the current commit will be taken.

It is better to do this once when deploying the application.

You also need to uncomment the `release` key in the `config/sentry.php` file and specify the following value:

```php
use DragonCode\Sentry\Facades\Sha;

return [
    // ...
    'release' => Sha::get()
    // ...
];
```

## License

This package is licensed under the [MIT License](LICENSE).


[badge_downloads]:      https://img.shields.io/packagist/dt/dragon-code/sentriable-laravel.svg?style=flat-square

[badge_license]:        https://img.shields.io/packagist/l/dragon-code/sentriable-laravel.svg?style=flat-square

[badge_stable]:         https://img.shields.io/github/v/release/TheDragonCode/sentriable-laravel?label=stable&style=flat-square

[badge_unstable]:       https://img.shields.io/badge/unstable-dev--master-orange?style=flat-square

[link_license]:         LICENSE

[link_packagist]:       https://packagist.org/packages/dragon-code/sentriable-laravel
