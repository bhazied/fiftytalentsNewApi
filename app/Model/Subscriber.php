<?php

namespace App\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Subscriber extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $guard = 'subscribers';

    protected $guarded = ['id'];

    protected $dates = [
        'created_at',
        'modified_at',
        'deleted_at'
    ];

    public function profiles()
    {
        return $this->hasMany(CandidateProfile::class);
    }

    public function sponsorships()
    {
        return $this->hasMany(Sponsorship::class);
    }
}
