<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PostMoney;

class FundraisingPostController extends Controller
{
    public function index(){
        $fundraisingPosts = PostMoney::all();
        return view('fundraising_posts', compact('fundraisingPosts'));
    }
    public function showPost($postid){
        return redirect()->back();
    }
}
