<p align="center"><img src="/art/socialcard.png" alt="Social Card for the Larasapien package"></p>

# Larasapien for Laravel

This package creates an endpoint for the Larasapien API. Once installed,
you can use this endpoint to connect your application to a Larasapien account.

By default, this package will report the following information:

 - Laravel, PHP, and Larasapien package version
 - Cache status
 - Environment type
 - Debug mode value
 - CPU load
 - Redis and Horizon status
 - Scheduler status
 - Git branch and last commit hash

You may disable any of these checks using your Larasapien configuration file.

## Installation

1. Install this package via composer using the following command:

```bash
composer require ellipticmarketing/larasapien
```

2. Add your Larasapien project token to your .env file:

```
LARASAPIEN_TOKEN={{your-token}}
```

You can find your project token in the Larasapien dashboard.

4. Optional: Publish the configuration file:

```bash
php artisan vendor:publish --tag=larasapien-config
```

## Usage

After the package is installed, it will create a new route for the Larasapien endpoint. By default, 
this route will be available at `/_larasapien`. The package will only serve requests
including the Larasapien token.

In addition to retrieving your application's status through Larasapien, you can 
also check it locally using the following command: `php artisan larasapien:check`.

## Configuring the schedule checker

To make the schedule checker work, it is necessary to invoke the `ScheduleChecker` command every 
five minutes. 

The command can be scheduled in your application's console Kernel locate under `app/Console/Kernel.php`:

```php
namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

use EllipticMarketing\Larasapien\Checkers\ScheduleChecker;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // ...
        
        $schedule->call(new ScheduleChecker)->everyFiveMinutes();
    }
}
```

## Enabling specific checks

In some instances, you may not want to run all checks. For example, you may want to disable the 
Redis check if your application doesn't use Redis.

To disable certain checks, you may comment the appropriate classes in your `config/larasapien.php` file:

```php
return [
    'token' => env('LARASAPIEN_TOKEN'),

    'checkers' => [
        EllipticMarketing\Larasapien\Checkers\GitChecker::class,
        EllipticMarketing\Larasapien\Checkers\CacheChecker::class,
        EllipticMarketing\Larasapien\Checkers\CpuLoadChecker::class,
        // EllipticMarketing\Larasapien\Checkers\HorizonChecker::class,
        // EllipticMarketing\Larasapien\Checkers\RedisChecker::class,
        EllipticMarketing\Larasapien\Checkers\ScheduleChecker::class,
    ],
];
```
## Acknowledgments

Many of the checks were inspired by the Laravel-health package created by [Spatie](https://github.com/spatie).

## License

You may use this package to connect your application to your Larasapien.com account.

This package is provided "as-is" with no warranties. Usage is subject to 
the [Larasapien Terms & Conditions](https://larasapien.com/terms).

Elliptic Marketing, LLC - All rights reserved.
