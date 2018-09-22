<?php
declare(strict_types=1);

/** @namespace */
namespace App\Events;

/** @uses */
use App\Entity\MailingStatus;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

/**
 * Class MailingStatusCreated
 * @package App\Events
 */
class MailingStatusCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /** @var MailingStatus */
    private $mailingStatus;

    /**
     * Create a new event instance.
     *
     * @param MailingStatus $mailingStatus
     */
    public function __construct(MailingStatus $mailingStatus)
    {
        $this->mailingStatus = $mailingStatus;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }

    /**
     * @return MailingStatus
     */
    public function getMailingStatus(): MailingStatus
    {
        return $this->mailingStatus;
    }
}
