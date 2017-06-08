<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class DepartmentTranslation extends Model
{
    public function departement(){
        return $this->belongsTo(Department::class);
    }
}
