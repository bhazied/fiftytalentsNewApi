<?php
/**
 * Created by PhpStorm.
 * User: dev03
 * Date: 09/06/17
 * Time: 11:30
 */

namespace App\Repositories;

use App\Model\Subscriber;
use App\Repositories\Contracts\BaseRepository;
use Illuminate\Database\Eloquent\Model;

class SubscriberRepository extends BaseRepository
{

    /**
     * init the model with we want to use
     * @return Model
     */
    protected function model()
    {
        return Subscriber::class;
    }
}
