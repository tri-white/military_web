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
use App\Mail\LotExpired;
use App\Mail\ChangedLot;
use App\Mail\RemovedLot;
use Illuminate\Support\Facades\Auth;

class LotPostController extends Controller
{
    public function index($page,$searchKey, $category, $sort){
        $page = (int)$page;

        $categories= Category::all();

        $this->removeExpiredLots();
           
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
            $query->orderBy('current_bid', 'desc');
        } elseif ($sort === 'bid-asc') {
            $query->orderBy('current_bid', 'asc');
        } elseif ($sort === 'time-desc') {
            $query->orderBy('expiration_datetime', 'desc');
        } elseif ($sort === 'time-asc') {
            $query->orderBy('expiration_datetime', 'asc');
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
    public function removeExpiredLots(){
        $expiredAuctions = PostBid::where('expiration_datetime', '<', now())->get();

        foreach ($expiredAuctions as $post) {
            $author = User::find($post->user_id);

            $userBid = Bid::where('post_id', $post->id)->orderBy('bid_amount', 'desc')->first();
            if(!is_null($userBid)){
                $user = User::find($userBid->user_id);

                Mail::to($user->email)->send(new LotWinnerNotification($user->id, $post->id, $author->id));
                Mail::to($author->email)->send(new LotWon($user->id, $post->id, $author->id));
            }
            else if (!is_null($author)){
                Mail::to($author->email)->send(new LotExpired($post, $author));
            }
            $post->bids()->delete();
            $post->delete();

        }
        return;
    }
    public function showPost($postid){
        $postBid = PostBid::find($postid);

        if (!$postBid) {
            return redirect()->route('welcome')->with('error', 'Оголошення не знайдено');
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
        $postBid = PostBid::find($postid);
        $author = User::find($postBid->user_id);
        $user= User::find($userid);
    
        if(!$postBid){
            return redirect()->route('welcome')->with('error','Аукціону більше не існує');
        }
    
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
            Mail::to($user->email)->send(new RemovedLot($request->input('reason'), $post));
        

        $post->delete();
    
        return redirect()->route('welcome')->with('success','Оголошення вилучено.');
    }
    public function showRemoveForm($postid, $userid)
    {
        $postBid = PostBid::findOrFail($postid);

        return view('remove/remove-lot', compact('postBid', 'userid'));
    }

    public function edit($postid)
    {
        $post = PostBid::find($postid);

        return view('edit/lot-edit', compact('post'));
    }
    
    public function editPostBid(Request $request, $userid, $postid)
    {
        $request->validate([
            'header' => 'required|string|max:50',
            'content' => 'required|string|max:900',
            'photo' => 'image|mimes:jpg,jpeg,png|max:2048',
            'expiration_datetime' => 'required|date_format:Y-m-d\TH:i',
            'category_id' => 'required|exists:category,id',
        ]);
        
        $user = User::findOrFail($userid);
        $listing = PostBid::findOrFail($postid);

        $listing->header = $request->input('header');
        $listing->content = $request->input('content');

        if ($request->hasFile('photo')) {

            $photoPath = $request->file('photo')->store('public/postBid');
            $listing->photo = $photoPath;
        }

        $listing->expiration_datetime = $request->input('expiration_datetime');
        $listing->category_id = $request->input('category_id');

        $listing->save();

        if($user->id != $listing->user_id)
            Mail::to($user->email)->send(new ChangedLot($listing));

        return redirect()->route('lot-post',['postid' => $listing->id])->with('success', 'Лот успішно оновлено.');
    }
}
