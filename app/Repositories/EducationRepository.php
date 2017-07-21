<?php
/**
 * Created by PhpStorm.
 * User: dev03
 * Date: 08/06/17
 * Time: 15:02
 */

namespace App\Repositories;


use App\Model\Education;
use App\Repositories\Contracts\BaseRepository;
use Illuminate\Database\Eloquent\Model;

class EducationRepository extends BaseRepository
{
    
    protected $createFiealds = ['school', 'graduate', 'specialization', 'graduation_year', 'c_profile_id'];

    /**
     * init the model with we want to use
     * @return Model
     */
    protected function model()
    {
        return Education::class;
    }
}