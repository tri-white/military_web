<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PostBid;
use App\Models\User;
use App\Models\Category;
class LotPostController extends Controller
{
    public function index($page){
        $page = (int)$page;

        $lotPosts = PostBid::all();
        $categories= Category::all();
           
        $postsPerPage = 5;
        $startIndex = ($page - 1) * $postsPerPage;
        $totalPages = ceil($lotPosts->count() / $postsPerPage);
        $currentPagePosts= $lotPosts->slice($startIndex, $postsPerPage);

        return view('lot_posts', [
            'categories' => $categories,
            'currentPage' => $page,
            'currentPagePosts' => $currentPagePosts,
            'totalPages' => $totalPages,
        ]);
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
