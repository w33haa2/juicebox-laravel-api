<?php

namespace App\Providers;

use App\Repositories\Contracts\PostRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\Contracts\WeatherRepositoryInterface;
use App\Repositories\Implementations\UserRepository;
use App\Repositories\Implementations\PostRepository;
use App\Repositories\Implementations\WeatherRepository;
use Illuminate\Console\Scheduling\Schedule;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(PostRepositoryInterface::class, PostRepository::class);
        $this->app->bind(WeatherRepositoryInterface::class, WeatherRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureSchedule();
    }

    protected function configureSchedule(): void
    {
        $this->app->booted(function () {
            $schedule = $this->app->make(Schedule::class);

            $schedule->command('weather:fetch-perth')->hourly();
        });
    }
}
