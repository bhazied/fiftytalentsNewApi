<?php
/**
 * Created by PhpStorm.
 * User: dev03
 * Date: 12/05/17
 * Time: 11:40
 */

namespace App\Repositories;

use App\Repositories\Contracts\BaseRepository;
use Illuminate\Database\Eloquent\Model;

class StateRepository extends BaseRepository
{
    protected function model()
    {
        return 'App\Model\State';
    }
}
