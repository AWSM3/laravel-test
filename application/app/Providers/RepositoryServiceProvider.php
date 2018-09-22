<?php
/**
 * @filename: RepositoryServiceProvider.php
 */
declare(strict_types=1);

/** @namespace */
namespace App\Providers;

/** @uses */
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Support\ServiceProvider;
use App\Repository\Interfaces;
use App\Repository\MySQL;

/**
 * Class RepositoryServiceProvider
 * @package App\Providers
 */
class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function boot(): void
    {
    }

    /**
     * @return void
     */
    public function register(): void
    {
        /** Регистриуем синглтон на каждый репозиторий */
        foreach ($this->getRepositories() as $interface => $concrete) {
            $this->app->singleton($interface, $concrete);
        }
    }

    /**
     * @return array
     */
    private function getRepositories(): array
    {
        return [
            /** интерфейс                                      => реализация или фабрика */
            Interfaces\MailingTaskRepositoryInterface::class   => MySQL\Concrete\MailingTaskRepository::class,
            Interfaces\MailingStatusRepositoryInterface::class => MySQL\Concrete\MailingStatusRepository::class,
        ];
    }
}