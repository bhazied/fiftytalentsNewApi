<?php
/**
 * Created by PhpStorm.
 * User: dev03
 * Date: 08/06/17
 * Time: 12:15
 */

namespace App\Repositories;


use App\Model\Department;
use App\Repositories\Contracts\BaseRepository;
use Illuminate\Database\Eloquent\Model;

class DepartmentRepository extends BaseRepository
{

    /**
     * init the model with we want to use
     * @return Model
     */
    protected function model()
    {
        return Department::class;
    }

}