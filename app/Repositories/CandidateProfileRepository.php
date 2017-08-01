<?php
/**
 * Created by PhpStorm.
 * User: dev03
 * Date: 13/06/17
 * Time: 12:47
 */

namespace App\Repositories;

use App\Model\CandidateProfile;
use App\Repositories\Contracts\BaseRepository;
use Illuminate\Database\Eloquent\Model;

class CandidateProfileRepository extends BaseRepository
{

    /**
     * init the model with we want to use
     * @return Model
     */
    protected function model()
    {
        return CandidateProfile::class;
    }
}
