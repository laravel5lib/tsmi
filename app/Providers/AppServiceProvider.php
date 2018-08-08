<?php

namespace App\Providers;

use App\Group;
use App\Observers\GroupObserver;
use App\Observers\SourceObserver;
use App\Source;
use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        setlocale(LC_TIME, 'Russia');
        Carbon::setLocale('ru');
        Carbon::setUtf8(true);
        Source::observe(SourceObserver::class);
        Group::observe(GroupObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
