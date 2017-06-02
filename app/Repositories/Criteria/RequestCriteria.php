<?php
/**
 * Created by PhpStorm.
 * User: dev03
 * Date: 18/05/17
 * Time: 14:53
 */

namespace app\Repositories\Criteria;

use App\Repositories\Contracts\Criteria;
use App\Repositories\Contracts\IRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RequestCriteria extends Criteria
{
    /**
     * @var Request
     */
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param $model
     * @param IRepository $repository
     * @return mixed
     */
    public function apply($model, IRepository $repository)
    {
        $filters = $this->request->get(config('app.repository.criteria.request.filters'), []);
        $orderBy = $this->request->get(config('app.repository.criteria.request.orderBy'), []);
        $with = $this->request->get('with');
        $searchableFields = $repository->getSearchableFields();
        $isFirstField = true;
        $forcedAnd = true;
        /* add soem where clause */
        if (is_array($filters) && count($filters)) {
            $model = $model->where(function ($query) use ($filters, $orderBy, $searchableFields, $isFirstField, $forcedAnd) {
                foreach ($filters as $field => $value) {
                    $condition = '=';
                    if (is_numeric($value)) {
                        $condition = '=';
                    }
                    if (isset($searchableFields[$field])) {
                        $condition = $searchableFields[$field];
                        if ($condition == 'like') {
                            $value = '%'.$value.'%';
                        }
                    }

                    $relation = null;
                    if (strpos($field, '.')) {
                        $explode = explode('.', $field);
                        $field = array_pop($explode);
                        $relation = implode('.', $explode);
                        //$relation = Str::plural($relation);
                    }
                    $modelTableName = $query->getModel()->getTable();
                    if ($isFirstField || $forcedAnd) {
                        if (!is_null($value)) {
                            if (!is_null($relation)) {
                                if (!is_numeric($value)) {
                                    $condition = 'like';
                                    $value = '%'.$value.'%';
                                }
                                $query->whereHas($relation, function ($query) use ($field, $condition, $value) {
                                    $query->where($field, $condition, $value);
                                });
                            } else {
                                $query->where($field, $condition, $value);
                            }
                            $isFirstField = false;
                        }
                    } else {
                        if (!is_null($value)) {
                            if (!is_null($relation)) {
                                $query->orWhereHas($relation, function ($query) use ($field, $condition, $value) {
                                    $query->where($field, $condition, $value);
                                });
                            } else {
                                $query->where($field, $condition, $value);
                            }
                            $isFirstField = false;
                        }
                    }
                }
            });
        }
        /* Order By Clause */
        if (is_array($orderBy) && count($orderBy)) {
            $table = $model->getModel()->getTable();
            $keyName = '';
            $sortedColumn = '';
            foreach ($orderBy as $attribute => $sortedBy) {
                if (strpos($attribute, '.')) {
                    $explode = explode('.', $attribute);
                    $sortedColumn = array_pop($explode);
                    $joinTable = implode('.', $explode);
                    $keyName = $this->getForeignKeyName($joinTable);
                    $joinTable = Str::plural($joinTable);
                    //dd($joinTable, $keyName, $sortedColumn, $sortedBy, $table);
                    $model = $model->leftJoin($joinTable, $table.'.'.$keyName, '=', $joinTable.'.id')
                        ->orderBy($joinTable.'.'.$sortedColumn, $sortedBy)
                        ->select($table.'.*');
                    //dd($model);
                } else {
                    $sortedColumn = $attribute;
                    $model->orderBy($sortedColumn, $sortedBy);
                }
            }
        }
        return $model;
    }

    private function getForeignKeyName($joinTable)
    {
        $foreignKey = [
            'user' => 'creator_user_id',
            'car_brand' => 'car_brand_id',
            'car_model' => 'car_model_id'
        ];
        if (isset($foreignKey[$joinTable])) {
            return $foreignKey[$joinTable];
        } else {
            return Str::plural($joinTable).'.'.$joinTable.'_id';
        }
    }
}
