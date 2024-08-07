<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExampleController extends Controller
{
    public function aboutPage(){
        // fetch data
        return view('hello');
    }

    public function contactPage(){
        // fetch data
        return view('welcome');
    }
}
