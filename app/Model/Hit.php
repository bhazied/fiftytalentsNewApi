<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Hit extends Model
{
    protected $guarded = ['id'];

    public function candidates()
    {
        return $this->belongsTo(CandidateProfile::class, 'c_profile_id');
    }
}
