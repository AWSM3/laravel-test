<?php
/**
 * @filename: UUIDEntityTrait.php
 */
declare(strict_types=1);

/** @namespace */
namespace App\Entity\Traits;

/** @uses */
use Ramsey\Uuid\Uuid;

/**
 * Trait UUIDEntityTrait
 * @package App\Entity\Traits
 */
trait UUIDEntityTrait
{
    /**
     * @inheritDoc
     */
    public function getRouteKeyName()
    {
        return 'id';
    }

    /**
     *  Setup model event hooks
     */
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = (string) Uuid::uuid4();
        });
    }
}