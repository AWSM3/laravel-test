<?php
/**
 * @filename: MailingStatusRepository.php
 */
declare(strict_types=1);

/** @namespace */
namespace App\Repository\MySQL\Concrete;

/** @uses */
use App\Entity\MailingStatus;
use App\Repository\Interfaces\MailingStatusRepositoryInterface;
use App\Repository\MySQL\AbstractRepository;

/**
 * Class MailingStatusRepository
 * @package App\Repository\MySQL\Concrete
 */
class MailingStatusRepository extends AbstractRepository implements MailingStatusRepositoryInterface
{
    /**
     * Метод должен вернуть класс сущности для которой инстанцируется репозиторий
     *
     * @return string
     */
    public function entity(): string
    {
        return MailingStatus::class;
    }
}