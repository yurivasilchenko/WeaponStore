<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HelperController extends Controller
{
    public static function parseTree($obj, $specs = []) {

        $keys = array_keys($obj);
        foreach ($keys as $key) {
            if (gettype($obj[$key]) === 'string') {
                $specs[] = array($key => $obj[$key]);
            } else {
                $specs = HelperController::parseTree($obj[$key], $specs);
            }
        }


        return $specs;
    }
}
