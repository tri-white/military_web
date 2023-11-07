<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PostMoney;
use App\Models\Category;

class FundraisingPostController extends Controller
{
    public function index($page){
        $page = (int)$page;

        $fundraisingPosts = PostMoney::all();
        $categories= Category::all();

        $postsPerPage = 5;
        $startIndex = ($page - 1) * $postsPerPage;
        $totalPages = ceil($fundraisingPosts->count() / $postsPerPage);
        $currentPagePosts= $fundraisingPosts->slice($startIndex, $postsPerPage);

        return view('fundraising_posts', [
            'categories' => $categories,
            'currentPage' => $page,
            'currentPagePosts' => $currentPagePosts,
            'totalPages' => $totalPages,
        ]);
    }
    public function showPost($postid)
    {
        $fundraisingPost = PostMoney::findOrFail($postid);

        return view('detailed_pages/fundraising-post', compact('fundraisingPost'));
    }
    
    public function donate($postid, Request $request)
    {
        $fundraisingPost = PostMoney::findOrFail($postid);
        
        $request->validate([
            'donationAmount' => 'required|numeric|min:1',
        ]);

        $donationAmount = $request->input('donationAmount');

        $fundraisingPost->current_amount += $donationAmount;
        $fundraisingPost->save();

        return redirect()->back()->with('success', 'Donation successful.');
    }
}
