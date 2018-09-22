<?php
declare(strict_types=1);

/** @uses */
use App\Entity\MailingTask;
use Illuminate\Database\Seeder;

/**
 * Class MailingTasksSeeder
 */
class MailingTasksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(MailingTask::class, 10)->create()->each(function (MailingTask $task) {
            $task->statuses()->saveMany(factory(\App\Entity\MailingStatus::class, rand(1, 7))->make(['task' => $task]));
        });
    }
}
