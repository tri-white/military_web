<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PostMoney;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\ChangedFundraising;
use App\Mail\RemovedFundraising;
class FundraisingPostController extends Controller
{
    public function index($page,$searchKey, $category, $sort){
        $page = (int)$page;

        $categories= Category::all();
        $query = PostMoney::query();

        if ($searchKey !== "null") {
            $query->where('purpose', 'like', '%' . $searchKey . '%');
        }

        if ($category !== 'all') {
            $query->where('category_id', $category);
        }

   

        if ($sort === 'progress-desc') {
            $query->orderByRaw('(current_amount / goal_amount) * 100 DESC');
        } elseif ($sort === 'progress-asc') {
            $query->orderByRaw('(current_amount / goal_amount) * 100 ASC');
        } elseif ($sort === 'summ-asc') {
            $query->orderByRaw('(goal_amount - current_amount) ASC');
        } elseif ($sort === 'summ-desc') {
            $query->orderByRaw('(goal_amount - current_amount) DESC');
        } elseif ($sort === 'collected-asc') {
            $query->orderBy('current_amount', 'asc');
        } elseif ($sort === 'collected-desc') {
            $query->orderBy('current_amount', 'desc');
        } elseif ($sort === 'date-desc') {
            $query->orderBy('created_at', 'desc');
        } elseif ($sort === 'date-asc') {
            $query->orderBy('created_at', 'asc');
        } elseif ($sort === 'header-desc') {
            $query->orderBy('purpose', 'asc');
        } elseif ($sort === 'header-asc') {
            $query->orderBy('purpose', 'desc');
        } elseif ($sort === 'goal-desc') {
            $query->orderBy('goal_amount', 'asc');
        } elseif ($sort === 'goal-asc') {
            $query->orderBy('goal_amount', 'desc');
        }
        

        $fundraisingPosts = $query->get();

        $postsPerPage = 5;
        $startIndex = ($page - 1) * $postsPerPage;
        $totalPages = ceil($fundraisingPosts->count() / $postsPerPage);
        $currentPagePosts= $fundraisingPosts->slice($startIndex, $postsPerPage);

        return view('fundraising_posts', [
            'categories' => $categories,
            'currentPage' => $page,
            'currentPagePosts' => $currentPagePosts,
            'totalPages' => $totalPages,
            'searchInput' => $searchKey,
            'selectedCategory' => $category,
            'selectedSort' => $sort,
        ]);
    }
    public function showPost($postid)
    {
        $fundraisingPost = PostMoney::find($postid);
        if (!$fundraisingPost) {
            return redirect()->route('welcome')->with('error', 'Оголошення не знайдено');
        }
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
    public function search(Request $request)
    {
        $searchKey = $request->input('search-input-key');
        $category = $request->input('product-category-filter');
        $sort = $request->input('product-sort');

        if ($searchKey === "" || $searchKey === null) {
            $searchKey = "null";
        }

        return redirect()->action([FundraisingPostController::class, 'index'], [
            'page' => 1,  
            'searchKey' => $searchKey,
            'category' => $category,
            'sort' => $sort,
        ]);
    }
    public function remove(Request $request, $postid, $userid){
        $user = User::find($userid);
        $post = PostMoney::find($postid);

        if($request->has('reason')){
            Mail::to($user->email)->send(new RemovedFundraising($request->input('reason'), $post));
        }
        
        $post->delete();
    
        return redirect()->route('welcome')->with('success','Оголошення вилучено.');
    }
    public function showRemoveForm($postid, $userid)
    {
        $postMoney = PostMoney::findOrFail($postid);

        return view('remove/remove-fundraising', compact('postMoney', 'userid'));
    }
    public function edit($postid)
    {
        $post = PostMoney::find($postid);

        return view('edit/fundraising-edit', compact('post'));
    }
    
    public function editPostFundraising(Request $request, $userid, $postid)
    {
        $request->validate([
            'purpose' => 'required|string|max:255',
            'goal_amount' => 'required|numeric|min:0',
            'current_amount' => 'required|numeric|min:0',
            'category_id' => 'required|exists:category,id',
        ]);

        if ($request->input('goal_amount') <= $request->input('current_amount')) {
            return redirect()->back()->with('error', 'Зібрана сума не може бути більшою або рівною за суму, яку потрібно зібрати. Уважно заповюйте поля у формі!');
        }

        $user = User::findOrFail($userid);
        $fundraisingPost = PostMoney::findOrFail($postid);
    
        $fundraisingPost->purpose = $request->input('purpose');
        $fundraisingPost->goal_amount = $request->input('goal_amount');
        $fundraisingPost->category_id = $request->input('category_id');
    
        $fundraisingPost->save();

        if($user->id != $fundraisingPost->user_id)
            Mail::to($user->email)->send(new ChangedFundraising($fundraisingPost));
    
        return redirect()->route('fundraising-post',['postid' => $fundraisingPost->id])->with('success', 'Збір коштів успішно оновлено.');
    }
}
