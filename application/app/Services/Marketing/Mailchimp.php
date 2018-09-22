<?php
/**
 * @filename: Mailchimp.php
 */
declare(strict_types=1);

/** @namespace */
namespace App\Services\Marketing;

/** @uses */
use Spatie\Newsletter\Newsletter;

/**
 * Class Mailchimp
 * @package App\Services\Marketing
 */
class Mailchimp implements MarketingServiceInterface
{
    /** @var Newsletter */
    private $newsletter;

    /**
     * Mailchimp constructor.
     *
     * @param Newsletter $newsletter
     */
    public function __construct(Newsletter $newsletter)
    {
        $this->newsletter = $newsletter;
    }

    /**
     * @param string $email
     *
     * @return void
     */
    public function subscribe(string $email): void
    {
        $this->newsletter->subscribe($email);
    }
}