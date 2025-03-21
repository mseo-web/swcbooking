<?php

namespace App\Providers;
use Illuminate\Http\Request;
use App\Services\BookingService;
use App\Services\ResourceService;
use App\Repositories\BookingRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\ResourceRepository;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use App\Repositories\Interfaces\BookingRepositoryInterface;
use App\Repositories\Interfaces\ResourceRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ResourceRepositoryInterface::class, ResourceRepository::class);
        $this->app->singleton(ResourceService::class, function ($app) {
            return new ResourceService($app->make(ResourceRepositoryInterface::class));
        });
    
        $this->app->bind(BookingRepositoryInterface::class, BookingRepository::class);
        $this->app->singleton(BookingService::class, function ($app) {
            return new BookingService($app->make(BookingRepositoryInterface::class));
        });
    }

    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}
