<?php

namespace App\Model;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use Translatable;

    public $translatedAttributes = ['title'];

    public function skillTranslations(){
        return $this->hasMany(SkillTranslation::class);
    }
}
