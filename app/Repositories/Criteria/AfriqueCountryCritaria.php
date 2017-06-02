<?php
/**
 * Created by PhpStorm.
 * User: dev03
 * Date: 01/05/17
 * Time: 18:34
 */

namespace App\Repositories\Criteria;

use App\Repositories\Contracts\Criteria;
use App\Repositories\Contracts\IRepository;

class AfriqueCountryCritaria extends Criteria
{
    public function apply($model, IRepository $repository)
    {
        $model = $model->where('id', '>', 270);
        return $model;
    }
}
