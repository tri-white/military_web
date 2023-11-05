<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FundraisingPostController extends Controller
{
    public function index(){
        return view('fundraising_posts');
    }
}
