<?php
namespace App\Facade;

use Illuminate\Support\Facades\Facade;

class UserPath extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \App\Lib\UserPath::class;
    }
}