<?php

namespace App\Model;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use Translatable;

    public $traslatedAttributes = ['name'];

    public function countryTranslations(){
        return $this->hasMany(CountryTranslation::class);
    }

    public function states(){
        return $this->hasMany(State::class);
    }

}
