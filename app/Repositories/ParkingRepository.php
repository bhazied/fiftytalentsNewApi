<?php
/**
 * Created by PhpStorm.
 * User: dev03
 * Date: 12/05/17
 * Time: 11:56
 */

namespace App\Repositories;

use App\Repositories\Contracts\BaseRepository;

class ParkingRepository extends BaseRepository
{
    public function model()
    {
        return 'App\Model\Parking';
    }
}
