<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class EntrepriseProfile extends Model
{
    protected $table = 'e_profiles';

    protected $guarded = ['id'];

    protected $casts = [
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
