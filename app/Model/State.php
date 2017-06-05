<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{

    public $traslatedAttributes = ['name'];

    public function state_translations(){
        return  $this->hasMany(StateTranslation::class);
    }

    public function country(){
        return $this->belongsTo(Country::class);
    }
}
