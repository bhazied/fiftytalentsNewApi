<?php
/**
 * Created by PhpStorm.
 * User: dev03
 * Date: 01/05/17
 * Time: 00:10
 */

namespace App\Repositories;

use App\Model\Country;
use App\Repositories\Contracts\BaseRepository;
use App\Repositories\Criteria\AfriqueCountryCritaria;

class CountryRepository extends BaseRepository
{
    protected $seachableField = ['name' => 'like', 'code' => 'like'];

    protected function model()
    {
        //   return 'App\Model\Country';
        return Country::class;
    }

    public function initRepository()
    {
        //$this->pushCriteria(AfriqueCountryCritaria::class);
    }
}
