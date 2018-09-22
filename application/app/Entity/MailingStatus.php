<?php
declare(strict_types=1);

/** @namespace */
namespace App\Entity;

/** @uses */
use App\Events\MailingStatusCreated;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class MailingStatus
 * @package App\Entity
 */
class MailingStatus extends Model
{
    use Traits\UUIDEntityTrait;

    const
        STATUS_SUCCESS = 'success',
        STATUS_FAIL = 'fail';

    /** @var string */
    protected $table = 'mailing_statuses';
    /** @var bool */
    public $incrementing = false;
    /** @var bool */
    public $timestamps = false;
    /** @var array */
    protected $fillable = [
        'id',
        'email',
        'task',
        'status',
    ];
    /** @var array */
    protected $dispatchesEvents = [
        'created' => MailingStatusCreated::class,
    ];

    /**
     * @return HasOne
     */
    public function task(): HasOne
    {
        return $this->hasOne(MailingTask::class, 'id', 'task');
    }

    /**
     * @return mixed
     */
    public function getTask()
    {
        return $this->task;
    }

    /**
     * @param $task
     *
     * @return void
     */
    public function setTaskAttribute($task): void
    {
        $this->attributes['task'] = $task instanceof MailingTask ? $task->getId() : $task;
    }

    /**
     * @param string $status
     *
     * @return MailingStatus
     */
    public function changeStatus(string $status): MailingStatus
    {
        if (!$this->isValidStatus($status)) {
            throw new \LogicException('Невалидный статус');
        }
        $this->status = $status;

        return $this;
    }

    /**
     * @return bool
     */
    public function isSuccess(): bool
    {
        return $this->status === self::STATUS_SUCCESS;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $status
     *
     * @return bool
     */
    protected function isValidStatus(string $status): bool
    {
        return in_array($status, [self::STATUS_SUCCESS, self::STATUS_FAIL]);
    }
}