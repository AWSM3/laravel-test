<?php
/**
 * @filename: AbstractRepository.php
 */
declare(strict_types=1);

/** @namespace */
namespace App\Repository\MySQL;

/** @uses */
use App\Repository\{Exception, Interfaces\RepositoryInterface};
use Illuminate\Container\Container as App;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\{Builder, Collection, Model};

/**
 * Class AbstractRepository
 * Примитивный Eloquent репозиторий
 *
 * @package App\Repository\MySQL
 *
 * @todo    : in-memory cache
 */
abstract class AbstractRepository implements RepositoryInterface
{
    /** @var App */
    private $app;
    /** @var Model */
    protected $entity;
    /** @var Builder */
    protected $query;

    /**
     * AbstractRepository constructor.
     *
     * @param App $app
     */
    public function __construct(App $app)
    {
        $this->app = $app;
        $this->makeEntity();
    }

    /**
     * Метод должен вернуть класс сущности для которой инстанцируется репозиторий
     *
     * @return string
     */
    abstract public function entity(): string;

    /**
     * @return void
     */
    protected function makeEntity(): void
    {
        $this->setEntity($this->entity());
    }

    /**
     * @param $entityName
     *
     * @return AbstractRepository
     */
    protected function setEntity(string $entityName): AbstractRepository
    {
        $entity = $this->app->make($entityName);
        if ($entity instanceof Model) {
            $this->entity = $entity;
            $this->query = $entity->newQuery();

            return $this;
        }

        throw new Exception\InvalidEntityClassException(
            sprintf(
                'Некорректный класс сущности, ожидается инстанс %s, получен %s',
                Model::class,
                get_class($entity)
            )
        );
    }

    /**
     * @param array $data
     *
     * @return Model
     */
    public function create(array $data): Model
    {
        return $this->query->create($data);
    }

    /**
     * @param       $id
     * @param array $columns
     *
     * @return Model
     */
    public function get($id, array $columns = ['*']): Model
    {
        $entity = $this->query->find($id, $columns);
        if ($entity instanceof Model) {
            return $entity;
        }

        throw new Exception\EntityNotFoundException;
    }

    /**
     * @param       $id
     * @param array $data
     *
     * @return bool
     */
    public function update($id, array $data): bool
    {
        return $this->query->find($id)->update($data);
    }

    /**
     * @param Model $entity
     *
     * @return bool
     */
    public function save(Model $entity): bool
    {
        $id = $entity->getAttribute($entity->getKeyName());

        return $this->query->find($id)->update($entity->toArray());
    }

    /**
     * @param $id
     *
     * @return bool
     * @throws \Exception
     */
    public function delete($id): bool
    {
        $entity = $this->query->find($id);

        return $entity->delete();
    }

    /**
     * @param array $columns
     *
     * @return Collection
     */
    public function getAll(array $columns = ['*']): Collection
    {
        return $this->query->get($columns);
    }

    /**
     * @param       $attribute
     * @param       $value
     * @param array $columns
     *
     * @return Model
     */
    public function getBy($attribute, $value, array $columns = ['*']): Model
    {
        $entity = $this->query->where($attribute, '=', $value)->first($columns);
        if ($entity instanceof Model) {
            return $entity;
        }

        throw new Exception\EntityNotFoundException;
    }

    /**
     * @param       $attribute
     * @param       $value
     * @param array $columns
     *
     * @return Collection
     */
    public function getAllBy($attribute, $value, array $columns = ['*']): Collection
    {
        return $this->query->where($attribute, '=', $value)->get($columns);
    }

    /**
     * @param \Closure|array $where
     * @param array          $columns
     *
     * @return Collection
     */
    public function getWhere(array $where, array $columns = ['*']): Collection
    {
        return $this->query->get($columns);
    }

    /**
     * @param array $where
     * @param int   $perPage
     * @param array $columns
     *
     * @return LengthAwarePaginator
     */
    public function paginate(array $where = [], $perPage = 50, $columns = ['*']): LengthAwarePaginator
    {
        $this->processWhere($where);

        return $this->query->paginate($perPage, $columns);
    }

    /**
     * @param array $where
     *
     * @return void
     */
    protected function processWhere(array $where): void
    {
        foreach ($where as $field => $value) {
            if ($value instanceof \Closure) {
                $this->query->where($value);
            } elseif (is_array($value)) {
                if (count($value) === 3) {
                    list($field, $operator, $search) = $value;
                    $this->query->where($field, $operator, $search);
                } elseif (count($value) === 2) {
                    list($field, $search) = $value;
                    $this->query->where($field, '=', $search);
                }
            } else {
                $this->query->where($field, '=', $value);
            }
        }
    }
}