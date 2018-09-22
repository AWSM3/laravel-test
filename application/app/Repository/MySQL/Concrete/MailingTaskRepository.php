<?php
/**
 * @filename: MailingTaskRepository.php
 */
declare(strict_types=1);

/** @namespace */
namespace App\Repository\MySQL\Concrete;

/** @uses */
use App\Entity\MailingTask;
use App\Repository\Interfaces\MailingTaskRepositoryInterface;
use App\Repository\MySQL\AbstractRepository;

/**
 * Class MailingTaskRepository
 * @package App\Repository\MySQL\Concrete
 */
class MailingTaskRepository extends AbstractRepository implements MailingTaskRepositoryInterface
{
    /**
     * Метод должен вернуть класс сущности для которой инстанцируется репозиторий
     *
     * @return string
     */
    public function entity(): string
    {
        return MailingTask::class;
    }
}