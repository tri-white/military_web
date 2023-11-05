<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PostMoney;

class FundraisingPostController extends Controller
{
    public function index(){
        $fundraisingPosts = PostMoney::all();
        return view('fundraising_posts', compact('fundraisingPosts'));
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
