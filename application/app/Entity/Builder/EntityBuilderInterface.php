<?php
/**
 * @filename: EntityBuilderInterface.php
 */
declare(strict_types=1);

/** @namespace */
namespace App\Entity\Builder;

/** @uses */
use Illuminate\Database\Eloquent\Model;

/**
 * Interface EntityBuilderInterface
 * @package App\Entity\Builder
 */
interface EntityBuilderInterface
{
    /**
     * @return Model
     */
    public function build(): Model;
}