<?php
/**
 * Created by PhpStorm.
 * User: dev03
 * Date: 04/08/17
 * Time: 11:55
 */

namespace App\Repositories;

use App\Model\Hit;
use App\Repositories\Contracts\BaseRepository;
use Illuminate\Database\Eloquent\Model;

class HitRepository extends BaseRepository
{

    /**
     * init the model with we want to use
     * @return Model
     */
    protected function model()
    {
        return Hit::class;
    }
}
