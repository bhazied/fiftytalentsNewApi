<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    protected $guarded = ['id'];

    public function profiles()
    {
        return $this->hasMany(CandidateProfile::class);
    }
}
