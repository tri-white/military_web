<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PostBid;
use App\Models\User;
use App\Models\Category;
class LotPostController extends Controller
{
    public function index($page,$searchKey, $category, $sort){
        $page = (int)$page;

        $categories= Category::all();
           
        $query = PostBid::query();

        if ($searchKey !== "null") {
            $query->where('header', 'like', '%' . $searchKey . '%');
        }

        if ($category !== 'all') {
            $query->where('category_id', $category);
        }
        
        if ($sort === 'date-desc') {
            $query->orderBy('created_at', 'desc');
        } elseif ($sort === 'date-asc') {
            $query->orderBy('created_at', 'asc');
        } elseif ($sort === 'header-desc') {
            $query->orderBy('header', 'asc');
        } elseif ($sort === 'header-asc') {
            $query->orderBy('header', 'desc');
        } elseif ($sort === 'bid-desc') {
            $query->orderBy('current_bid', 'asc');
        } elseif ($sort === 'bid-asc') {
            $query->orderBy('current_bid', 'desc');
        } elseif ($sort === 'time-desc') {
            $query->orderBy('expiration_datetime', 'asc');
        } elseif ($sort === 'time-asc') {
            $query->orderBy('expiration_datetime', 'desc');
        }

        $lotPosts = $query->get();

        $postsPerPage = 5;
        $startIndex = ($page - 1) * $postsPerPage;
        $totalPages = ceil($lotPosts->count() / $postsPerPage);
        $currentPagePosts= $lotPosts->slice($startIndex, $postsPerPage);

        return view('lot_posts', [
            'categories' => $categories,
            'currentPage' => $page,
            'currentPagePosts' => $currentPagePosts,
            'totalPages' => $totalPages,
            'searchInput' => $searchKey,
            'selectedCategory' => $category,
            'selectedSort' => $sort,
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
    public function search(Request $request)
    {
        $searchKey = $request->input('search-input-key');
        $category = $request->input('product-category-filter');
        $sort = $request->input('product-sort');

        if ($searchKey === "" || $searchKey === null) {
            $searchKey = "null";
        }

        return redirect()->action([LotPostController::class, 'index'], [
            'page' => 1,  
            'searchKey' => $searchKey,
            'category' => $category,
            'sort' => $sort,
        ]);
    }
}
