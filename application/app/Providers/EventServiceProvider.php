<?php
declare(strict_types=1);

/** @namespace */
namespace App\Providers;

/** @uses */
use App\Events\MailingStatusCreated as MailingStatusCreatedEvent;
use App\Listeners\MailingStatusCreated as MailingStatusCreatedListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

/**
 * Class EventServiceProvider
 * @package App\Providers
 */
class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        MailingStatusCreatedEvent::class => [
            MailingStatusCreatedListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}
