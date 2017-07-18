<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CandidateProfile extends Model
{
    protected $table = 'c_profiles';

    protected $guarded = ['id'];

    protected $casts = [
        'skills' => 'array',
        'skills_levels' => 'array',
        'states' => 'array'
    ];

    public function educations(){
        return $this->hasMany(Education::class, 'c_profile_id');
    }

    public function subscriber()
    {
        return $this->belongsTo(Subscriber::class);
    }

    public function experiences()
    {
        return $this->hasMany(Experience::class, 'c_profile_id');
    }
}
