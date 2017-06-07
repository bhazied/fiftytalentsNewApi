<?php

namespace App\Model;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use Translatable;

    public $translatedAttributes = ['title', 'description'];

    public function jobTranslations(){
        return $this->hasMany(JobTranslation::class);
    }
}
