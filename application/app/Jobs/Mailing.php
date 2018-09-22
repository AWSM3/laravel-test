<?php
declare(strict_types=1);

/** @namespace */
namespace App\Jobs;

/** @uses */
use App\Entity\MailingStatus;
use App\Entity\MailingTask;
use App\Mail\DTO\RecipientsList;
use App\Services\MailingManager;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

/**
 * Class Mailing
 * @package App\Jobs
 */
class Mailing implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var MailingTask */
    private $mailingTask;
    /** @var RecipientsList */
    private $recipientsList;
    /** @var array */
    private $images;

    /**
     * Create a new job instance.
     *
     * @param MailingTask    $mailingTask
     * @param RecipientsList $recipientsList
     * @param array          $images
     */
    public function __construct(MailingTask $mailingTask, RecipientsList $recipientsList, array $images)
    {
        $this->mailingTask = $mailingTask;
        $this->recipientsList = $recipientsList;
        $this->images = $images;
    }

    /**
     * Execute the job.
     *
     * @param Mailer         $mailer
     *
     * @param MailingManager $mailingManager
     *
     * @return void
     */
    public function handle(Mailer $mailer, MailingManager $mailingManager)
    {
        foreach ($this->recipientsList->toArray() as $recipient) {
            try {
                $mailer->send(
                    new \App\Mail\ShutterStockTop($recipient, $this->images)
                );
                $status = MailingStatus::STATUS_SUCCESS;
            } catch (\Exception $e) {
                $status = MailingStatus::STATUS_FAIL;
            }
            /** Пишем статусы отправки для каждого email */
            $mailingManager->makeRecipientStatus($this->mailingTask, $recipient, $status);
        }
    }
}
