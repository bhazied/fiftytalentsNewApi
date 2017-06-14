<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CandidateProfile extends Model
{
    protected $table = 'c_profiles';

    protected $guarded = ['id'];

    public function educations(){
        return $this->hasMany(Education::class, 'c_profile_id');
    }

    public function subscriber()
    {
        return $this->belongsTo(Subscriber::class);
    }

    public function experience()
    {
        return $this->belongsTo(Experience::class);
    }
}
