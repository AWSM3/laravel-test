<?php
declare(strict_types=1);

/** @namespace */
namespace App\Providers;

/** @uses */
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\View\Composer\Navigation\SidebarComposer;

/**
 * Class ComposerServiceProvider
 * @package App\Providers
 */
class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('partials.sidebar', SidebarComposer::class);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
