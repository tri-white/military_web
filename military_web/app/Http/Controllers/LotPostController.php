<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PostBid;
use App\Models\Bid;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\Mail;
use App\Mail\LotWon;
use App\Mail\LotWinnerNotification;
use App\Mail\ChangedLot;
use App\Mail\RemovedLot;
use Illuminate\Support\Facades\Auth;

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
    public function placeBid(Request $request, $postid, $userid)
    {
        $post = PostBid::findOrFail($postid);
        $user = User::find($userid);


        if ($post->expiration_datetime->isPast()) {
            return redirect()->back()->with('error', 'Ставку не можливо зробити. Аукціон вже завершено.');
        }

        $newBidAmount = (float)$request->input('newBid');

        if ($newBidAmount <= $post->current_bid) {
            return redirect()->back()->with('error', 'Ставку не виконано. Вже існує вища ставка.');
        }

        $bid = new Bid();
        $bid->user_id = $user->id;
        $bid->bid_amount = $newBidAmount;
        $bid->post_id = $post->id;
        $bid->save();

        $post->current_bid = $newBidAmount;
        $post->save();

        return redirect()->back()->with('success', 'Ставку зроблено.');
    }
    public function getFreeLot(Request $request, $postid, $userid)
    {
        $postBid = PostBid::findOrFail($postid);
        $author = User::find($postBid->user_id);
        $user= User::find($userid);
    
    
        Mail::to(Auth::user()->email)->send(new LotWinnerNotification($userid, $postid, $author->id));
    
        Mail::to($author->email)->send(new LotWon($userid, $postid, $author->id));

        $postBid->delete();

        $page = 1;
        $search = "null";
        $cat = "all";
        $sort = "date-desc";
        
        return redirect()->route('lot-posts', [
            'page' => $page,
            'searchKey' => $search,
            'category' => $cat,
            'sort' => $sort,
        ])->with('success', 'Ви виграли аукціон! Перевірте повідомлення у електронній скриньці');        
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
    public function lotPostPartial($postid)
    {
        $postBid = PostBid::find($postid);
        $finished = \Carbon\Carbon::now()->isAfter($postBid->expiration_datetime);

        return view('partial.lot-post-partial', compact('postBid', 'finished'));
    }
    public function remove(Request $request, $postid, $userid){
        $user = User::find($userid);
        $post = PostBid::find($postid);

        Bid::where('post_id', $postid)->delete();
        
        if($request->has('reason'))
            Mail::to($user->email)->send(new RemovedLot($request->input('reason')));
        

        $post->delete();

        return redirect()->back()->with('success','Оголошення вилучено.');
    }
}
