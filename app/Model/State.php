<?php

namespace App\Model;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use Translatable;

    public $translatedAttributes = ['name'];

    public function state_translations()
    {
        return  $this->hasMany(StateTranslation::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
