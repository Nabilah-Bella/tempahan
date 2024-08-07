<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function changeLanguage()
    {
        $lang = isset($_GET['lang']) ? $_GET['lang'] : 'en';
        Session::put('lang', $lang);

        return redirect()->back();
    }
}
