<?php
/**
 * Created by PhpStorm.
 * User: Zied Ben Hadj Amor
 * Date: 21/06/17
 * Time: 11:30
 */

namespace App\Repositories;


use App\Model\Recommendation;
use App\Repositories\Contracts\BaseRepository;
use Illuminate\Database\Eloquent\Model;

class RecommendationRepository extends  BaseRepository
{

    /**
     * init the model with we want to use
     * @return Model
     */
    protected function model()
    {
        return Recommendation::class;
    }
}