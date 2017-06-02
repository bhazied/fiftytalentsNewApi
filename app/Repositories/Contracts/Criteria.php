<?php
/**
 * Created by PhpStorm.
 * User: dev03
 * Date: 01/05/17
 * Time: 17:43
 */

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Model;

abstract class Criteria
{
    abstract public function apply($model, IRepository $repository);
}
