<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PostAsk;
use App\Models\PostMoney;
class SoldierController extends Controller
{
    public function form_postAsk(){
        return view('soldier/form_post-ask');
    }

    public function create_postAsk(Request $request, $userid){
        $request->validate([
            'header' => 'required|string|max:255',
            'content' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'category_id' => 'required|exists:category,id',
        ]);
    
        $post = new PostAsk();
        $post->user_id = $userid;
        $post->header = $request->input('header');
        $post->content = $request->input('content');
        $post->category_id = $request->input('category_id');
    
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('public/postAsk');
            $post->photo = $photoPath;
        }
    
        $post->save();
    
        return redirect()->route('welcome')->with('success', 'Успішно створено пост');
    }


    public function form_postFundraising(){
        return view('soldier/form_post-fundraising');
    }

    public function create_postFundraising(Request $request, $userid){
        $request->validate([
            'header' => 'required|string|max:255',
            'content' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'category_id' => 'required|exists:category,id',
        ]);
    
        $post = new PostMoney();
        $post->user_id = $userid;
        $post->header = $request->input('header');
        $post->content = $request->input('content');
        $post->category_id = $request->input('category_id');
    
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('public/postAsk');
            $post->photo = $photoPath;
        }
    
        $post->save();
    
        return redirect()->route('welcome')->with('success', 'Успішно створено пост');
    }
    
}
