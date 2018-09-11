<?php

namespace App\Console;

use App\Console\Commands\AddSource;
use App\Console\Commands\ClearImageCache;
use App\Console\Commands\DownloadImage;
use App\Console\Commands\GroupNews;
use App\Console\Commands\ParseNews;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        GroupNews::class,
        ParseNews::class,
        AddSource::class,
        ClearImageCache::class,
        DownloadImage::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('news:parse')->everyFiveMinutes();
        $schedule->command('news:group')->everyTenMinutes();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }

}
