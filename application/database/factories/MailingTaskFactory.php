<?php
/**
 * @filename: MailingTaskFactory.php
 */
declare(strict_types=1);

/** @uses */
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

/** @var Factory $factory */
$factory->define(\App\Entity\MailingTask::class, function (Faker $faker) {
    return [
        'hash' => $faker->md5,
    ];
});