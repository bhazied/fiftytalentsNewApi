<?php

namespace App\Model;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use Translatable;

    public $translatedAttributes = ['title'];

    public function departmentTranslations()
    {
        return $this->hasMany(DepartmentTranslation::class);
    }

    public function jobs()
    {
        return $this->hasMany(Job::class);
    }
}
