<?php
/**
 * @filename: MailingStatusBuilderTest.php
 */
declare(strict_types=1);

/** @namespace */
namespace Tests\Unit\Entity\Builder;

/** @uses */
use App\Entity\Builder\MailingStatusBuilder;
use App\Entity\MailingStatus;
use App\Entity\MailingTask;
use App\Repository\Interfaces\MailingTaskRepositoryInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class MailingStatusBuilderTest
 * @package Tests\Unit\Entity\Builder
 */
class MailingStatusBuilderTest extends TestCase
{
    use RefreshDatabase;

    /** @var MailingStatusBuilder */
    private $builder;
    /** @var MailingTaskRepositoryInterface */
    private $taskRepository;

    /**
     * @inheritDoc
     */
    protected function setUp()
    {
        parent::setUp();
        $this->builder = $this->app->make(MailingStatusBuilder::class);
        $this->taskRepository = $this->app->get(MailingTaskRepositoryInterface::class);

        $this->afterApplicationCreated(function () {
            /** Транзакция, дабы не сохранять тестовые данные */
            $this->beginDatabaseTransaction();
        });
    }


    /** @test */
    public function testSetTask()
    {
        /** @var MailingTask $task */
        $task = $this->taskRepository->create(['hash' => md5('random_string')]);
        /** @var MailingStatus $entity */
        $entity = $this->builder
            ->setTask($task)
            ->build();

        $this->assertTrue($entity->getTask() === $task->getId());
    }

    /** @test */
    public function testBuild()
    {
        /** @var MailingStatus $entity */
        $entity = $this->builder
            ->setStatus(MailingStatus::STATUS_FAIL)
            ->build();

        $this->assertInstanceOf(MailingStatus::class, $entity);
    }

    /** @test */
    public function testSetStatus()
    {
        /** @var MailingStatus $entity */
        $entity = $this->builder
            ->setStatus(MailingStatus::STATUS_SUCCESS)
            ->build();

        $this->assertTrue($entity->isSuccess());

        /** @var MailingStatus $entity */
        $entity = $this->builder
            ->setStatus(MailingStatus::STATUS_FAIL)
            ->build();

        $this->assertTrue(!$entity->isSuccess());
    }

    /** @test */
    public function testSetEmail()
    {
        $email = 'test@mail.ru';
        /** @var MailingStatus $entity */
        $entity = $this->builder
            ->setEmail($email)
            ->build();

        $this->assertTrue($entity->getEmail() === $email);
    }
}
