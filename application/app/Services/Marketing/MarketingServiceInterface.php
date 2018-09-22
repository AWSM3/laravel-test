<?php
/**
 * @filename: MarketingServiceInterface.php
 */
declare(strict_types=1);

/** @namespace */
namespace App\Services\Marketing;

/**
 * Interface MarketingServiceInterface
 * @package App\Services\Marketing
 */
interface MarketingServiceInterface
{
    /**
     * @param string $email
     *
     * @return mixed
     */
    public function subscribe(string $email);
}