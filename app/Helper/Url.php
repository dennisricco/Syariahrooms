<?php

namespace App\Helper;
use Illuminate\Http\Request;

class Url {

    public static function url($string){
        return \Request::is(str_replace(url('/').'/', '', $string));
    }
}
