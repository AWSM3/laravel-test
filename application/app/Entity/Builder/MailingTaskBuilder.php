<?php
/**
 * @filename: MailingTaskBuilder.php
 */
declare(strict_types=1);

/** @namespace */
namespace App\Entity\Builder;

/** @uses */
use App\Entity\MailingTask;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;

/**
 * Class MailingTaskBuilder
 * @package App\Entity\Builder
 */
class MailingTaskBuilder implements EntityBuilderInterface
{
    /** @var MailingTask $task */
    protected $task;

    /**
     * MailingTaskBuilder constructor.
     *
     * @param MailingTask $mailingTask
     */
    public function __construct(MailingTask $mailingTask)
    {
        $this->task = $mailingTask;
    }

    /**
     * @param UploadedFile $file
     *
     * @return MailingTaskBuilder
     */
    public function setFile(UploadedFile $file): MailingTaskBuilder
    {
        $hash = md5(file_get_contents($file->getRealPath()));
        $this->task->setAttribute('hash', $hash);

        return $this;
    }

    /**
     * @return MailingTask|Model
     */
    public function build(): Model
    {
        return $this->task;
    }
}