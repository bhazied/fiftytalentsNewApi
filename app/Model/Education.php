<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    protected $table = 'educations';

    public function CandidateProfile(){
        return $this->belongsTo(CandidateProfile::class, 'c_profile_id');
    }
}
