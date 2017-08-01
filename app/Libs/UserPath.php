<?php

namespace App\Lib;

class UserPath
{
    public function getBaseCustomerDirectory($str)
    {
        $newstr = '';
        $str_2_splited = str_split($str, 2);
        foreach ($str_2_splited as $splite) {
            $newstr .= $splite.DIRECTORY_SEPARATOR;
        }
        return $newstr;
    }
}
