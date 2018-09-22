<?php
/**
 * @filename: MailingStatusFactory.php
 */
declare(strict_types=1);

/** @uses */
use App\Entity\MailingStatus;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

/** @var Factory $factory */
$factory->define(
    MailingStatus::class, function (Faker $faker) {
    return [
        'email' => $faker->email,
        'status' => $faker->randomElement([MailingStatus::STATUS_FAIL, MailingStatus::STATUS_SUCCESS]),
    ];
});