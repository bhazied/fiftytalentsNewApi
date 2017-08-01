<?php
/**
 * Created by PhpStorm.
 * User: dev03
 * Date: 01/08/17
 * Time: 16:10
 */

namespace App\Repositories;

use App\Model\EntrepriseProfile;
use App\Repositories\Contracts\BaseRepository;
use Illuminate\Database\Eloquent\Model;

class EnterpriseProfileRepository extends BaseRepository
{

    /**
     * init the model with we want to use
     * @return Model
     */
    protected function model()
    {
        return EntrepriseProfile::class;
    }
}
