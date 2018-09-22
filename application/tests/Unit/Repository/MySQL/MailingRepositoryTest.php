<?php
/**
 * @filename: MailingRepositoryTest.php
 */
declare(strict_types=1);

/** @namespace */
namespace Tests\Unit\Repository\MySQL;

/** @uses */
use App\Entity\MailingStatus;
use App\Entity\MailingTask;
use App\Repository\Interfaces\MailingStatusRepositoryInterface;
use App\Repository\Interfaces\MailingTaskRepositoryInterface;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class MailingRepositoryTest
 * @package Tests\Unit\Repository\MySQL
 */
class MailingRepositoryTest extends TestCase
{
    use RefreshDatabase;

    /** @var MailingTaskRepositoryInterface */
    private $taskRepository;
    /** @var MailingStatusRepositoryInterface */
    private $statusRepository;
    /** @var Faker */
    private $faker;

    /**
     * @inheritDoc
     */
    protected function setUp()
    {
        parent::setUp();
        $this->taskRepository = $this->app->get(MailingTaskRepositoryInterface::class);
        $this->statusRepository = $this->app->get(MailingStatusRepositoryInterface::class);

        $this->faker = $this->app->get(Faker::class);

        $this->afterApplicationCreated(function () {
            /** Транзакция, дабы не сохранять тестовые данные */
           $this->beginDatabaseTransaction();
        });
    }

    public function testCreate()
    {
        $task = $this->createTask();
        $status = $this->createStatus($task, MailingStatus::STATUS_SUCCESS);
        $this->assertInstanceOf(MailingTask::class, $task);
        $this->assertInstanceOf(MailingStatus::class, $status);
        $this->assertTrue($task->id === $status->task);
    }

    public function testSave()
    {
        $task = $this->createTask();
        $status = $this->createStatus($task, MailingStatus::STATUS_SUCCESS);

        $mailingTaskNewHash = $this->makeRandomMd5String();
        $mailingStatusNewStatus = MailingStatus::STATUS_FAIL;

        $task->hash = $mailingTaskNewHash;
        $status->changeStatus($mailingStatusNewStatus);

        $this->assertTrue($this->taskRepository->save($task));
        $this->assertTrue($this->statusRepository->save($status));

        $this->assertTrue($task->hash === $mailingTaskNewHash);
        $this->assertTrue($status->status === $mailingStatusNewStatus);
    }

    public function testDelete()
    {
        $task = $this->createTask();
        $status = $this->createStatus($task, MailingStatus::STATUS_SUCCESS);

        $this->assertTrue($this->taskRepository->delete($task->id));
        try {
            /** Статус должен быть удалённым, так как foreign key имеется on delete cascade */
            $status = $this->statusRepository->get($status->id);
            $this->assertNotInstanceOf(MailingStatus::class, $status);
        } catch (\Exception $e) {}
    }

    public function testGet()
    {
        $task = $this->createTask();
        $status = $this->createStatus($task, MailingStatus::STATUS_SUCCESS);

        $this->assertInstanceOf(MailingTask::class, $this->taskRepository->get($task->id));
        $this->assertInstanceOf(MailingStatus::class, $this->statusRepository->get($status->id));
    }

    public function testUpdate()
    {
        $task = $this->createTask();
        $status = $this->createStatus($task, MailingStatus::STATUS_SUCCESS);

        $this->assertTrue($this->taskRepository->update($task->id, ['hash' => $this->makeRandomMd5String()]));
        $this->assertTrue($this->statusRepository->update($status->id, ['status' => MailingStatus::STATUS_FAIL]));
    }

    public function testGetAll()
    {
        $task = $this->createTask();
        $status = $this->createStatus($task, MailingStatus::STATUS_SUCCESS);

        $taskAll = $this->taskRepository->getAll();
        $statusAll = $this->statusRepository->getAll();
        $this->assertInstanceOf(Collection::class, $taskAll);
        $this->assertInstanceOf(Collection::class, $taskAll);

        $this->assertTrue($taskAll->count() > 0);
        $this->assertTrue($statusAll->count() > 0);
    }

    public function testGetWhere()
    {
        $task = $this->createTask();
        $status = $this->createStatus($task, MailingStatus::STATUS_SUCCESS);

        $tasksResult = $this->taskRepository->getWhere(['hash' => $task->hash]);
        $statusesResult = $this->statusRepository->getWhere(['email' => $status->email]);

        $this->assertInstanceOf(Collection::class, $tasksResult);
        $this->assertInstanceOf(Collection::class, $statusesResult);

        $this->assertTrue($tasksResult->count() > 0);
        $this->assertTrue($statusesResult->count() > 0);
    }

    public function testGetBy()
    {
        $task = $this->createTask();
        $status = $this->createStatus($task, MailingStatus::STATUS_SUCCESS);

        $this->assertInstanceOf(MailingTask::class, $this->taskRepository->getBy('hash', $task->hash));
        $this->assertInstanceOf(MailingStatus::class, $this->statusRepository->getBy('email', $status->email));
    }

    public function testGetAllBy()
    {
        $task = $this->createTask();
        $status = $this->createStatus($task, MailingStatus::STATUS_SUCCESS);

        $this->assertInstanceOf(Collection::class, $this->taskRepository->getAllBy('hash', $task->hash));
        $this->assertInstanceOf(Collection::class, $this->statusRepository->getAllBy('email', $status->email));

        $this->assertTrue(true);
    }

    /**
     * @throws \Exception
     * @return MailingTask
     */
    private function createTask(): MailingTask
    {
        /** @var MailingTask $task */
        $task = $this->taskRepository->create([
            'hash' => $this->makeRandomMd5String()
        ]);

        return $task;
    }

    /**
     * @param MailingTask $task
     * @param string      $status
     *
     * @return MailingStatus
     */
    private function createStatus(MailingTask $task, string $status): MailingStatus
    {
        /** @var MailingStatus $status */
        $status = $this->statusRepository->create(
            [
                'email'   => $this->faker->email,
                'task'    => $task,
                'status'  => $status,
                'content' => $this->faker->text,
            ]
        );

        return $status;
    }

    /**
     * @return string
     * @throws \Exception
     */
    private function makeRandomMd5String(): string
    {
        return md5(random_bytes(10));
    }
}
