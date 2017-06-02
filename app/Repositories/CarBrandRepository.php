<?php
/**
 * Created by PhpStorm.
 * User: dev03
 * Date: 12/05/17
 * Time: 11:54
 */

namespace App\Repositories;

use App\Repositories\Contracts\BaseRepository;

class CarBrandRepository extends BaseRepository
{
    protected $seachableField = ['name'];
    
    public function model()
    {
        return 'App\Model\CarBrand';
    }
}
