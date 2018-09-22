<?php
/**
 * @filename: RepositoryInterface.php
 */
declare(strict_types=1);

/** @namespace */
namespace App\Repository\Interfaces;

/** @uses */
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\{Collection, Model};

/**
 * Interface RepositoryInterface
 * @package App\Repository\Interfaces
 */
interface RepositoryInterface
{
    /**
     * @param array $data
     *
     * @return Model
     */
    public function create(array $data): Model;

    /**
     * @param       $id
     * @param array $columns
     *
     * @return Model
     */
    public function get($id, array $columns = ['*']): Model;

    /**
     * @param       $id
     * @param array $data
     *
     * @return bool
     */
    public function update($id, array $data): bool;

    /**
     * @param Model $entity
     *
     * @return bool
     */
    public function save(Model $entity): bool;

    /**
     * @param $id
     *
     * @return bool
     */
    public function delete($id): bool;

    /**
     * @param array $columns
     *
     * @return Collection
     */
    public function getAll(array $columns = ['*']): Collection;

    /**
     * @param       $attribute
     * @param       $value
     * @param array $columns
     *
     * @return Model
     */
    public function getBy($attribute, $value, array $columns = ['*']): Model;

    /**
     * @param       $attribute
     * @param       $value
     * @param array $columns
     *
     * @return Collection
     */
    public function getAllBy($attribute, $value, array $columns = ['*']): Collection;

    /**
     * @param     array $where
     * @param array     $columns
     *
     * @return Collection
     */
    public function getWhere(array $where, array $columns = ['*']): Collection;

    /**
     * @param array $where
     * @param int   $perPage
     * @param array $columns
     *
     * @return LengthAwarePaginator
     */
    public function paginate(array $where = [], $perPage = 50, $columns = ['*']): LengthAwarePaginator;
}