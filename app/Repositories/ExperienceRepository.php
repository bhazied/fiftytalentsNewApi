<?php
/**
 * Created by PhpStorm.
 * User: dev03
 * Date: 14/06/17
 * Time: 14:32
 */

namespace App\Repositories;


use App\Model\Experience;
use App\Repositories\Contracts\BaseRepository;
use Illuminate\Database\Eloquent\Model;

class ExperienceRepository extends BaseRepository
{

    /**
     * init the model with we want to use
     * @return Model
     */
    protected function model()
    {
        return Experience::class;
    }
}