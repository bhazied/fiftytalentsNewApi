<?php
/**
 * Created by PhpStorm.
 * User: dev03
 * Date: 30/04/17
 * Time: 16:15
 */

namespace App\Repositories\Contracts;

use app\Repositories\Exceptions\RepositoryExceprion;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Container\Container as App;

abstract class BaseRepository implements IRepository, IRepositoryCriteria
{
    /**
     * @var App
     */
    protected $application;

    /**
     * @var Collection
     */
    protected $criteria;

    /**
     * @var
     */
    protected $model;

    /**
     * @var bool
     */
    protected $skipAllCriteria = false;

    /**
     * @var \Closure
     */
    protected $scopeQuery;
    /**
     * @var
     */
    private $keyName;

    /**
     * @var array
     */
    protected $seachableField = [];

    /**
     * @var array
     */
    private $namedCriteria = [];

    /**
     * BaseRepository constructor.
     * @param App $application
     */
    public function __construct(App $application)
    {
        $this->application = $application;

        $this->getModel();

        $this->resetCriteria();

        $this->initRepository();
    }

    /**
     * init repository from child repository
     */
    public function initRepository()
    {
    }

    /**
     * init the model with we want to use
     * @return Model
     */
    abstract protected function model();

    /**
     * @param bool $status
     * @return $this
     */
    public function skipCriteria($status = true)
    {
        $this->skipAllCriteria = $status;
        return $this;
    }

    /**
     * @return Collection
     */
    public function getCriteria()
    {
        return $this->criteria;
    }

    /**
     * @param Criteria $criteria
     * @return mixed
     */
    public function getByCriteria(Criteria $criteria)
    {
        if (!in_array(get_class($criteria), $this->namedCriteria)) {
            $this->model = $criteria->apply($this->model, $this);
            array_push($this->namedCriteria, get_class($criteria));
        }
        $result =  $this->model->get();
        return $result;
    }

    /**
     * @param $criteria
     */
    public function pushCriteria($criteria)
    {
        if (is_string($criteria)) {
            $criteria = new $criteria;
        }
        if (! $criteria instanceof Criteria) {
            throw new RepositoryExceprion('the class '. get_class($criteria) . ' is not an instance off App\\Contract\\Criteria');
        }
        if (!in_array(get_class($criteria), $this->namedCriteria)) {
            array_push($this->namedCriteria, get_class($criteria));
            $this->criteria->push($criteria);
        }
        return $this;
    }

    /**
     * @return $this
     */
    public function applyCriteria()
    {
        if ($this->skipAllCriteria === true) {
            return $this;
        }
        $criteria = $this->getCriteria();
        if ($criteria) {
            foreach ($criteria as $condition) {
                $this->model = $condition->apply($this->model, $this);
            }
        }
        return $this;
    }

    /**
     *
     */
    public function resetCriteria()
    {
        $this->criteria = new Collection();
    }

    /**
     * @param $relations
     * @return $this
     */
    public function with($relations)
    {
        $this->model->with($relations);
        return $this;
    }


    public function scopeQuery(\Closure $scope)
    {
        $this->scopeQuery = $scope;
        return $this;
    }

    public function resetScope()
    {
        $this->scopeQuery = null;
        return $this;
    }

    public function applyScope()
    {
        if (isset($this->scopeQuery) && is_callable($this->scopeQuery)) {
            $callback = $this->scopeQuery;
            $this->model = $callback($this->model);
        }
        return $this;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function getModel()
    {
        $model = $this->application->make($this->model());
        $this->keyName = $model->getKeyName();
        if (!$model instanceof Model) {
            throw new RepositoryExceprion('the class '. $this->model() . ' is not an instance off Illuminate\\Database\\Eloquent\\Model');
        }
        return $this->model = $model->newQuery();
        //return $this->model = $model;
    }


    /**
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes)
    {
        return $this->model->create($attributes);
    }

    /**
     * @param array $attributes
     * @param $value
     * @param $field
     * @return mixed
     */
    public function update(array $attributes, $value, $field)
    {
        return $this->model->where($field, '=', $value)->update($attributes);
    }


    /**
     * @param array $columns
     * @return mixed
     */
    public function lists($columns = ['*'])
    {
        $this->applyScope();
        $this->applyCriteria();
        $results = $this->model->get($columns);
        $this->getModel();
        return $results;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        $toDelete = $this->model->find($id);
        return $toDelete->delete();
    }


    /**
     * @param array $where
     * @return mixed
     */
    public function deleteWhere(array $where)
    {
        $this->applyCriteria();
        $this->applyCondition($where);
        return $this->model->delete();
    }

    /**
     * @param array $where
     * @param array $columns
     * @return mixed
     */
    public function findWhere(array $where, $columns = ['*'])
    {
        $this->applyCriteria();
        $this->applyCondition($where);
        return $this->model->get($columns);
    }

    /**
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function find($id, $columns = ['*'])
    {
        $this->applyCriteria();
        return  $this->model->find($id, $columns);
    }

    /**
     * @param $field
     * @param $value
     * @param array $columns
     * @return mixed
     */
    public function findBy($field, $value, $columns = ['*'])
    {
        $this->applyCriteria();
        return $this->model->where($field, ' = ', $value)->get($columns);
    }

    public function count()
    {
        $this->applyCriteria();
        $this->applyScope();
        $count = $this->model->count();
        $this->getModel();
        return $count;
    }


    /**
     * @param array $where
     */
    public function applyCondition(array $where)
    {
        foreach ($where as $filed => $value) {
            if (is_array($value)) {
                list($filed, $condition, $val) = $value;
                $this->model->where($filed, $condition, $val);
            } else {
                $this->model->where($filed, '=', $value);
            }
        }
    }

    public function getModelKeyName()
    {
        return $this->keyName;
    }

    public function getSearchableFields()
    {
        return $this->seachableField;
    }
}
