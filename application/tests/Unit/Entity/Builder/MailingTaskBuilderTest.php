<?php
/**
 * @filename: MailingTaskBuilderTest.php
 */
declare(strict_types=1);

/** @namespace */
namespace Tests\Unit\Entity\Builder;

/** @uses */
use App\Entity\Builder\MailingTaskBuilder;
use App\Entity\MailingTask;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

/**
 * Class MailingTaskBuilderTest
 * @package Tests\Unit\Entity\Builder
 */
class MailingTaskBuilderTest extends TestCase
{
    /** @var MailingTaskBuilder */
    private $builder;

    protected function setUp()
    {
        parent::setUp();

        $this->builder = $this->app->make(MailingTaskBuilder::class);
    }

    /** @test */
    public function testSetFile()
    {
        $file = UploadedFile::fake()->create('emails.txt');
        $fileHash = md5(file_get_contents($file->getRealPath()));
        /** @var MailingTask $entity */
        $entity = $this->builder
            ->setFile($file)
            ->build();

        $this->assertTrue($entity->getHash() === $fileHash);

    }

    /** @test */
    public function testBuild()
    {
        /** @var MailingTask $entity */
        $entity = $this->builder
            ->build();

        $this->assertInstanceOf(MailingTask::class, $entity);
    }
}
