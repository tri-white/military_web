<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PostBid;
use App\Models\User;
class LotPostController extends Controller
{
    public function index(){
        $lotPosts = PostBid::all();
        return view('lot_posts', compact('lotPosts'));
    }
    public function showPost($postid){
        $postBid = PostBid::find($postid);

        if (!$postBid) {
            return redirect()->route('welcome')->with('error', 'Post not found');
        }

        $author = User::find($postBid->user_id);

        return view('detailed_pages/lot-post', [
            'postBid' => $postBid,
            'user' => $author,
        ]);
    }
    public function bid(Request $request, $postid){
        return redirect()->back();
    }
}
