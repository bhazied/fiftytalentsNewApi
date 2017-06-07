<?php

namespace App\Model;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Departement extends Model
{
    use Translatable;

    public $translatedAttributes = ['title'];

    public function departementTranslations(){
        return $this->hasMany(DepartementTranslation::class);
    }
}
