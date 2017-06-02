<?php
/**
 * Created by PhpStorm.
 * User: dev03
 * Date: 30/04/17
 * Time: 16:45
 */

namespace App\Repositories;

use App\Repositories\Contracts\BaseRepository;

class UserRepository extends BaseRepository
{
    public function model()
    {
        return '\App\Model\User';
    }
}
