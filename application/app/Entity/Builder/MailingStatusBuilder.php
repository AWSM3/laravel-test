<?php
/**
 * @filename: MailingStatusBuilder.php
 */
declare(strict_types=1);

/** @namespace */
namespace App\Entity\Builder;

/** @uses */
use App\Entity\MailingStatus;
use App\Entity\MailingTask;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MailingStatusBuilder
 * @package App\Entity\Builder
 */
class MailingStatusBuilder implements EntityBuilderInterface
{
    /** @var MailingStatus $task */
    protected $status;

    /**
     * MailingStatusBuilder constructor.
     *
     * @param MailingStatus $mailingStatus
     */
    public function __construct(MailingStatus $mailingStatus)
    {
        $this->status = $mailingStatus;
    }

    /**
     * @param MailingTask $task
     *
     * @return MailingStatusBuilder
     */
    public function setTask(MailingTask $task): MailingStatusBuilder
    {
        $this->status->setAttribute('task', $task->getId());

        return $this;
    }

    /**
     * @param string $email
     *
     * @return MailingStatusBuilder
     */
    public function setEmail(string $email): MailingStatusBuilder
    {
        $this->status->setAttribute('email', $email);

        return $this;
    }

    /**
     * @param string $status
     *
     * @return MailingStatusBuilder
     */
    public function setStatus(string $status): MailingStatusBuilder
    {
        $this->status->changeStatus($status);

        return $this;
    }

    /**
     * @return MailingStatus|Model
     */
    public function build(): Model
    {
        return $this->status;
    }
}