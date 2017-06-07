<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CountryTranslation extends Model
{
    public function country(){
        return $this->belongsTo(Country::class);
    }
}
