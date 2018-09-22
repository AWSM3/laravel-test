<?php
declare(strict_types=1);

/** @namespace */
namespace App\Listeners;

/** @uses */
use App\Events\MailingStatusCreated as MailingStatusCreatedEvent;
use App\Services\Marketing\MarketingServiceInterface;

/**
 * Class MailingStatusCreated
 * @package App\Listeners
 */
class MailingStatusCreated
{
    /** @var MarketingServiceInterface */
    private $marketingService;

    /**
     * Create the event listener.
     *
     * @param MarketingServiceInterface $marketingService
     */
    public function __construct(MarketingServiceInterface $marketingService)
    {
        $this->marketingService = $marketingService;
    }

    /**
     * Handle the event.
     *
     * @param  MailingStatusCreatedEvent $event
     *
     * @return mixed
     */
    public function handle(MailingStatusCreatedEvent $event): void
    {
        $mailingStatus = $event->getMailingStatus();
        if (!$mailingStatus->isSuccess()) {
            return;
        }

        /** Подписываем юзера в системе рассылок */
        $this->marketingService->subscribe($mailingStatus->getEmail());
    }
}
