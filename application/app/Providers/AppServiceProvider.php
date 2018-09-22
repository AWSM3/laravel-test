<?php
declare(strict_types=1);

/** @namespace */
namespace App\Providers;

/** @uses */
use App\Services\Marketing\Mailchimp;
use App\Services\Marketing\MarketingServiceInterface;
use Illuminate\Support\ServiceProvider;

/**
 * Class AppServiceProvider
 * @package App\Providers
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(MarketingServiceInterface::class, Mailchimp::class);
    }
}
