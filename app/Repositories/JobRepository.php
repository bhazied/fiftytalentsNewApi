<?php
/**
 * Created by PhpStorm.
 * User: dev03
 * Date: 07/06/17
 * Time: 15:49
 */

namespace App\Repositories;


use App\Model\Job;
use App\Repositories\Contracts\BaseRepository;
use Illuminate\Database\Eloquent\Model;

class JobRepository extends BaseRepository
{

    protected $seachableField = ['title' => 'like', 'description' => 'like'];
    /**
     * init the model with we want to use
     * @return Model
     */
    protected function model()
    {
        return Job::class;
    }

    public function initRepository()
    {
        $this->scopeQuery(function($query){
            return $query->where('active', 1);
        });
    }
}