<?php
use App\Facade\UserPath;

if (!function_exists('getCustomerBaseDirectory')) {
    function getCustomerBaseDirectory($str)
    {
        return UserPath::getBaseCustomerDirectory($str);
    }
}
