<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SkillTranslation extends Model
{
    public function skill(){
        return $this->belongsTo(Skill::class);
    }
}
