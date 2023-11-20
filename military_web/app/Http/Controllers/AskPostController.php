<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PostAsk;
use App\Models\Proposition;
use App\Models\Category;
use Illuminate\Support\Facades\Mail;
use App\Mail\AcceptedProposition;
use App\Mail\PropositionAdded;
use App\Models\User;
use App\Mail\ChangedAsk;
use App\Mail\RemovedAsk;
class AskPostController extends Controller
{
    public function index($page,$searchKey, $category, $sort){
        $categories= Category::all();
        $page = (int)$page;
        $query = PostAsk::query();

        if ($searchKey !== "null") {
            $query->where('header', 'like', '%' . $searchKey . '%');
        }

        if ($category !== 'all') {
            $query->where('category_id', $category);
        }
        $query->withCount('propositions');

        if ($sort === 'propositions-desc') {
            $query->orderBy('propositions_count', 'desc');
        } elseif ($sort === 'propositions-asc') {
            $query->orderBy('propositions_count', 'asc');
        } elseif ($sort === 'date-desc') {
            $query->orderBy('created_at', 'desc');
        } elseif ($sort === 'date-asc') {
            $query->orderBy('created_at', 'asc');
        } elseif ($sort === 'header-desc') {
            $query->orderBy('header', 'asc');
        } elseif ($sort === 'header-asc') {
            $query->orderBy('header', 'desc');
        }

        $askPosts= $query->get();
        
        $postsPerPage = 5;
        $startIndex = ($page - 1) * $postsPerPage;
        $totalPages = ceil($askPosts->count() / $postsPerPage);
        $currentPagePosts= $askPosts->slice($startIndex, $postsPerPage);

        return view('ask_posts', [
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
        $postAsk = PostAsk::find($postid);

        if (!$postAsk) {
            return redirect()->route('welcome')->with('error', 'Оголошення не знайдено');
        }

        $propositions = Proposition::where('post_ask_id', $postid)->get();

        return view('detailed_pages/ask-post', [
            'postAsk' => $postAsk,
            'propositions' => $propositions,
        ]);
    }
    public function propose(Request $request, $postid, $userid)
    {
        $request->validate([
            'price' => 'required|numeric|min:0',
            'message' => 'required|string',
            'photo' => 'image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $proposition = new Proposition();
        $proposition->price = $request->input('price');
        $proposition->message = $request->input('message');
        $proposition->post_ask_id = $postid;
        $proposition->user_id = $userid;

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('public/propositions');
            $proposition->photo = $photoPath;
        }

        $proposition->save();

        return redirect()->route('ask-post', ['postid' => $postid])->with('success', 'Пропозицію успішно створено');
    }
    public function search(Request $request)
    {
        $searchKey = $request->input('search-input-key');
        $category = $request->input('product-category-filter');
        $sort = $request->input('product-sort');

        if ($searchKey === "" || $searchKey === null) {
            $searchKey = "null";
        }

        return redirect()->action([AskPostController::class, 'index'], [
            'page' => 1,  
            'searchKey' => $searchKey,
            'category' => $category,
            'sort' => $sort,
        ]);
    }
    public function acceptProposition(Request $request, $propositionid){
        $proposition = Proposition::find($propositionid);

        if (!$proposition) {
            return redirect()->back()->with('error', 'Пропозицію не знайдено.');
        }
    
        
        $post = PostAsk::find($proposition->post_ask_id);
        $propositionAuthor = User::find($proposition->user_id);
        $postAuthor = User::find($post->user_id);
    
        Mail::to($propositionAuthor->email)->send(new AcceptedProposition($proposition, $post, $propositionAuthor, $postAuthor));
        Mail::to($postAuthor->email)->send(new PropositionAdded($proposition, $post, $propositionAuthor, $postAuthor));
    
        $proposition->delete();
    
        $post->accepted_propositions += 1;
        $post->save();
    

        return redirect()->back()->with('success', 'Пропозицію успішно прийнято! Перевірте вашу електронну скриньку.');
    }

    public function remove(Request $request, $postid, $userid){
        $user = User::find($userid);
        $post = PostAsk::find($postid);

        Proposition::where('post_ask_id', $postid)->delete();
        
        if($request->has('reason'))
            Mail::to($user->email)->send(new RemovedAsk($request->input('reason'), $post));

        $post->delete();
        
        return redirect()->route('welcome')->with('success','Оголошення вилучено.');
    }
    public function showRemoveForm($postid, $userid)
    {
        $postAsk = PostAsk::findOrFail($postid);

        return view('remove/remove-ask', compact('postAsk', 'userid'));
    }
    public function edit($postid)
    {
        $post = PostAsk::find($postid);

        return view('edit/ask-edit', compact('post'));
    }
    
    public function editPostAsk(Request $request, $userid, $postid)
    {
        $request->validate([
            'header' => 'required|string|max:50',
            'content' => 'required|string|max:900',
            'photo' => 'image|mimes:jpg,jpeg,png|max:2048',
            'expiration_datetime' => 'required|date_format:Y-m-d\TH:i|after:now',
            'category_id' => 'required|exists:category,id',
        ]);

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

        return redirect()->route('welcome')->with('success', 'Лот успішно оновлено.');
    }
}
