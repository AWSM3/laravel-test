<?php
/**
 * @filename: MailingManagerTest.php
 */
declare(strict_types=1);

/** @namespace */
namespace Tests\Unit\Services;

/** @uses */
use App\Entity\MailingStatus;
use App\Entity\MailingTask;
use App\Http\Requests\ProcessMailingRequest;
use App\Mail\DTO\RecipientsList;
use App\Services\MailingManager;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Testing\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Artisan;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\TestCase;
use Faker\Generator as Faker;

/**
 * Class MailingManagerTest
 * @package Tests\Unit\Services
 */
class MailingManagerTest extends TestCase
{
    use RefreshDatabase;

    const EMAIL = 'test@mail.ru';

    /** @var MailingManager */
    private $mailingManager;
    /** @var File */
    private $tempFile;
    /** @var Faker */
    private $faker;

    /**
     * @return void
     */
    protected function setUp()
    {
        parent::setUp();

        $this->mailingManager = $this->app->make(MailingManager::class);
        $this->tempFile = $this->makeTempFile();
        $this->faker = $this->app->get(Faker::class);

        /** seed for test data */
        Artisan::call('db:seed', [
            '--class' => 'MailingTasksSeeder'
        ]);

        $this->afterApplicationCreated(function () {
            /** Транзакция, дабы не сохранять тестовые данные */
            $this->beginDatabaseTransaction();
        });
    }

    /** @test */
    public function testRetrieveAllPaginatedTasks()
    {
        $result = $this->mailingManager->retrieveAllPaginatedTasks();
        $this->assertInstanceOf(
            \Illuminate\Contracts\Pagination\LengthAwarePaginator::class,
            $result
        );
        $this->assertTrue(!$result->isEmpty());
    }

    /**
     * @test
     * @throws \ReflectionException
     */
    public function testParseRecipientsFromFile()
    {
        $reflection = new \ReflectionClass(get_class($this->mailingManager));
        $method = $reflection->getMethod('parseRecipientsFromFile');
        $method->setAccessible(true);
        /** @var RecipientsList $recipientsList */
        $recipientsList = $method->invokeArgs($this->mailingManager, [$this->tempFile]);
        $this->assertInstanceOf(RecipientsList::class, $recipientsList);
        $this->assertTrue(!$recipientsList->isEmpty());
    }

    /** @test */
    public function testMakeTask()
    {
        /** @var MockObject|ProcessMailingRequest $request */
        $request = $this->createMock(ProcessMailingRequest::class);
        $request->expects(self::any())->method('getFile')->willReturn($this->tempFile);
        $request->expects(self::any())->method('getImages')->willReturn(
            [
                $this->faker->imageUrl(),
                $this->faker->imageUrl(),
                $this->faker->imageUrl(),
                $this->faker->imageUrl(),
                $this->faker->imageUrl(),
            ]
        );

        $created = $this->mailingManager->makeTask($request);

        $this->assertInstanceOf(MailingTask::class, $created);
    }

    /** @test */
    public function testMakeRecipientStatus()
    {
        $items = $this->mailingManager->retrieveAllPaginatedTasks()->items();
        $task = reset($items);
        $mailingStatus = $this->mailingManager->makeRecipientStatus($task, self::EMAIL, MailingStatus::STATUS_SUCCESS);

        $this->assertInstanceOf(MailingStatus::class, $mailingStatus);
    }

    /**
     * @return File
     */
    private function makeTempFile(): File
    {
        $file = UploadedFile::fake()->create('emails.txt');
        file_put_contents($file->getRealPath(), self::EMAIL);

        return $file;
    }

}
