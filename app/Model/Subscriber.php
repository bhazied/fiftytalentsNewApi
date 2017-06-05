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
}
