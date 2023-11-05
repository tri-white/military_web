<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\PostBid;
use Carbon\Carbon;
class UserController extends Controller
{
    public function form_postBid(){
        return view('user/form_post-bid');
    }

    public function create_postBid(Request $request, $userid)
    {
        $request->validate([
            'header' => 'required|string|max:50',
            'content' => 'required|string|max:900',
            'photo' => 'image|mimes:jpg,jpeg,png|max:2048',
            'expiration_datetime' => 'required|date_format:Y-m-d\TH:i|after:now',
            'current_bid' => 'required|numeric|min:0',
            'buy_price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:category,id',
        ]);
        if($request->input('current_bid') > $request->input('buy_price')){
            return redirect()->back()->with('error','Початкова ціна не може бути більшою за ціну завершення торгів');
        }
        $listing = new PostBid();
        $listing->header = $request->input('header');
        $listing->content = $request->input('content');
        $listing->user_id = $userid;
        
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('public/postBid');
            $listing->photo = $photoPath;
        }
        $listing->expiration_datetime = $request->input('expiration_datetime');
        $listing->current_bid = $request->input('current_bid');
        $listing->buy_price = $request->input('buy_price');
        $listing->category_id = $request->input('category_id');
        $listing->save();

        return redirect()->route('welcome')->with('success', 'Лот успішно створено. Вам надійде лист при його завершенні');
    }
    public function create_postBidFree(Request $request, $userid)
    {
        $request->validate([
            'header' => 'required|string|max:255',
            'content' => 'required|string',
            'photo' => 'image|mimes:jpg,jpeg,png|max:2048',
            'expiration_datetime' => 'required|date_format:Y-m-d\TH:i|after:now',
            'category_id' => 'required|exists:category,id',
        ]);
        $listing = new PostBid();
        $listing->header = $request->input('header');
        $listing->content = $request->input('content');
        $listing->user_id = $userid;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('public/postBid');
            $listing->photo = $photoPath;
        }
        $listing->expiration_datetime = $request->input('expiration_datetime');
        $listing->category_id = $request->input('category_id');
        $listing->save();
        return redirect()->route('welcome')->with('success', 'Лот успішно створено. Вам надійде лист при його завершенні');
    }
}
