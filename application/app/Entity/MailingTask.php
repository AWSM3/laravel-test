<?php
declare(strict_types=1);

/** @namespace */
namespace App\Entity;

/** @uses*/
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class MailingTask
 * @package App\Entity
 */
class MailingTask extends Model
{
    use Traits\UUIDEntityTrait;

    /** @var string */
    protected $table = 'mailing_tasks';
    /** @var bool */
    public $incrementing = false;
    /** @var array */
    protected $fillable = [
        'id',
        'hash',
    ];

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getHash(): string
    {
        return $this->hash;
    }

    /**
     * @return HasMany
     */
    public function statuses(): HasMany
    {
        return $this->hasMany(MailingStatus::class, 'task', 'id');
    }
}
