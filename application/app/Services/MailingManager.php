<?php
/**
 * @filename: MailingManager.php
 */
declare(strict_types=1);

/** @namespace */
namespace App\Services;

/** @uses */
use App\Entity\Builder\MailingStatusBuilder;
use App\Entity\Builder\MailingTaskBuilder;
use App\Entity\MailingStatus;
use App\Entity\MailingTask;
use App\Http\Requests\ProcessMailingRequest;
use App\Jobs\Mailing;
use App\Mail\DTO\RecipientsList;
use App\Repository\Interfaces\MailingStatusRepositoryInterface;
use App\Repository\Interfaces\MailingTaskRepositoryInterface;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\UploadedFile;

/**
 * Class MailingManager
 * @package App\Services
 */
class MailingManager
{
    /** @var MailingTaskRepositoryInterface */
    private $mailingTaskRepository;
    /** @var MailingStatusRepositoryInterface */
    private $mailingStatusRepository;
    /** @var Dispatcher */
    private $dispatcher;
    /** @var MailingTaskBuilder */
    private $mailingTaskBuilder;
    /** @var MailingStatusBuilder */
    private $mailingStatusBuilder;

    /**
     * MailingManager constructor.
     *
     * @param MailingTaskRepositoryInterface   $mailingTaskRepository
     * @param MailingStatusRepositoryInterface $mailingStatusRepository
     * @param Dispatcher                       $dispatcher
     * @param MailingTaskBuilder               $mailingTaskBuilder
     * @param MailingStatusBuilder             $mailingStatusBuilder
     */
    public function __construct(MailingTaskRepositoryInterface $mailingTaskRepository,
                                MailingStatusRepositoryInterface $mailingStatusRepository, Dispatcher $dispatcher,
                                MailingTaskBuilder $mailingTaskBuilder, MailingStatusBuilder $mailingStatusBuilder)
    {
        $this->mailingTaskRepository = $mailingTaskRepository;
        $this->mailingStatusRepository = $mailingStatusRepository;
        $this->dispatcher = $dispatcher;
        $this->mailingTaskBuilder = $mailingTaskBuilder;
        $this->mailingStatusBuilder = $mailingStatusBuilder;
    }

    /**
     * @param int   $perPage
     * @param array $where
     *
     * @return LengthAwarePaginator
     */
    public function retrieveAllPaginatedTasks(int $perPage = 50, array $where = []): LengthAwarePaginator
    {
        return $this->mailingTaskRepository->paginate($where, $perPage);
    }

    /**
     * @param ProcessMailingRequest $request
     *
     * @return void
     */
    public function processNewTask(ProcessMailingRequest $request): void
    {
        $recipientsList = $this->parseRecipientsFromFile($request->getFile());
        if ($recipientsList->isEmpty()) {
            return;
        }

        $task = $this->makeTask($request);

        $this->dispatcher->dispatch(
            new Mailing(
                $task,
                $this->parseRecipientsFromFile($request->getFile()),
                $request->getImages()
            )
        );
    }

    /**
     * @param UploadedFile $file
     *
     * @return RecipientsList
     */
    protected function parseRecipientsFromFile(UploadedFile $file): RecipientsList
    {
        $content = $file->getRealPath();

        $emails = array_map(
            function ($line) {
                return filter_var($line, FILTER_SANITIZE_EMAIL);
            }, file($content));
        $recipients = new RecipientsList($emails);

        return $recipients;
    }

    /**
     * @param ProcessMailingRequest $request
     *
     * @return MailingTask
     */
    public function makeTask(ProcessMailingRequest $request): MailingTask
    {
        $task = $this->mailingTaskBuilder
                     ->setFile($request->getFile())
                     ->build();
        // Illuminate\Database\Connection::beginTransaction()
        // Illuminate\Database\Connection::rollback()
        // Illuminate\Database\Connection::commit()

        /** @var MailingTask $created */
        $created = $this->mailingTaskRepository->create($task->toArray());

        return $created;
    }

    /**
     * @param MailingTask $task
     * @param string      $recipient
     * @param string      $status
     *
     * @return MailingStatus
     */
    public function makeRecipientStatus(MailingTask $task, string $recipient, string $status): MailingStatus
    {
        $status = $this->mailingStatusBuilder
                       ->setTask($task)
                       ->setEmail($recipient)
                       ->setStatus($status)
                       ->build();

        /** @var MailingStatus $created */
        $created = $this->mailingStatusRepository->create($status->toArray());

        return $created;
    }
}