<?php
/**
 * Created by PhpStorm.
 * User: dev03
 * Date: 08/06/17
 * Time: 13:28
 */

namespace App\Repositories;


use App\Model\Skill;
use App\Repositories\Contracts\BaseRepository;
use Illuminate\Database\Eloquent\Model;

class SkillRepository extends BaseRepository
{

    /**
     * init the model with we want to use
     * @return Model
     */
    protected function model()
    {
        return Skill::class;
    }
}