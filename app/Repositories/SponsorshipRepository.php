<?php
/**
 * Created by PhpStorm.
 * User: dev03
 * Date: 02/08/17
 * Time: 12:07
 */

namespace App\Repositories;

use App\Model\Sponsorship;
use App\Repositories\Contracts\BaseRepository;
use Illuminate\Database\Eloquent\Model;

class SponsorshipRepository extends BaseRepository
{

    /**
     * init the model with we want to use
     * @return Model
     */
    protected function model()
    {
        return Sponsorship::class;
    }
}
