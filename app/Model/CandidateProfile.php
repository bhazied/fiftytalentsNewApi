<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CandidateProfile extends Model
{
    protected $table = 'c_profiles';

    public function educations(){
        return $this->hasMany(Education::class, 'c_profile_id');
    }
}
