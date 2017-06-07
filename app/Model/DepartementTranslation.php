<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class DepartementTranslation extends Model
{
    public function departement(){
        return $this->belongsTo(Departement::class);
    }
}
