<?php
/**
 * @filename: RecipientsList.php
 */
declare(strict_types=1);

/** @namespace */
namespace App\Mail\DTO;

/** @uses */
use Illuminate\Support\Collection;

/**
 * Class RecipientsList
 * @package App\Mail\DTO
 */
class RecipientsList
{
    /** @var Collection */
    protected $items;

    /**
     * RecipientsList constructor.
     *
     * @param array $items
     */
    public function __construct(array $items)
    {
        $this->items = new Collection($items);
    }

    /**
     * @param string $recipient
     *
     * @return RecipientsList
     */
    public function addRecipient(string $recipient): RecipientsList
    {
        $this->items->push($recipient);

        return $this;
    }

    /**
     * @return RecipientsList
     */
    public function flush(): RecipientsList
    {
        $this->items = new Collection;

        return $this;
    }

    /**
     * @return bool
     */
    public function isEmpty(): bool
    {
        return $this->items->isEmpty();
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->items->toArray();
    }
}