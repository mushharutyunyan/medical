<?php

namespace App\Http\Controllers\Admin;

use Config;
use Session;
use Redirect;
use App;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LanguageController extends Controller
{
    public function switchLang($lang)
    {
        if (array_key_exists($lang, Config::get('languages'))) {
            Session::put('adminapplocale', $lang);
        }
        return Redirect::back();
    }
}
