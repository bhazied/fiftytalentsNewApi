<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Sponsorship extends Model
{
    protected $table = 'sponsorships';

    protected $guarded = ['id'];
    
    public function subscriber()
    {
        return $this->belongsTo(Subscriber::class, 'subscriber_id');
    }
}
