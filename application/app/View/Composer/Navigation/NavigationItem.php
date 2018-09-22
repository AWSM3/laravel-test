<?php
/**
 * @filename: NavigationItem.php
 */
declare(strict_types=1);

/** @namespace */
namespace App\View\Composer\Navigation;

/**
 * Class NavigationItem
 * @package App\View\Composer\Navigation
 */
class NavigationItem
{
    /** @var string */
    protected $title;
    /** @var string */
    protected $url;
    /** @var bool */
    protected $active;

    /**
     * NavigationItem constructor.
     *
     * @param string $title
     * @param string $url
     * @param bool   $active
     */
    public function __construct(string $title, string $url, bool $active)
    {
        $this->title = $title;
        $this->url = $url;
        $this->active = $active;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }
}