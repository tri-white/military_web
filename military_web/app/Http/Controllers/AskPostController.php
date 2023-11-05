<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PostAsk;
use App\Models\Proposition;
class AskPostController extends Controller
{
    public function index(){
        $askPosts = PostAsk::all();
        return view('ask_posts', compact('askPosts'));
    }
    public function showPost($postid){
        $postAsk = PostAsk::find($postid);

        if (!$postAsk) {
            return redirect()->route('welcome')->with('error', 'Post not found');
        }

        $propositions = Proposition::where('post_ask_id', $postid)->get();

        return view('detailed_pages/ask-post', [
            'postAsk' => $postAsk,
            'propositions' => $propositions,
        ]);
    }
    public function propose(Request $request, $postid)
    {
        // Validate the request data
        $request->validate([
            'price' => 'required|numeric|min:0',
            'photo' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'message' => 'required|string',
            'post_ask_id' => 'required|exists:post_asks,id',
            'user_id' => 'required|exists:users,id',
        ]);

        // Handle the submission and save the proposition to the database
        $proposition = new Proposition();
        $proposition->price = $request->input('price');
        $proposition->message = $request->input('message');
        $proposition->post_ask_id = $request->input('post_ask_id');
        $proposition->user_id = $request->input('user_id');

        // Handle photo upload if provided

        $proposition->save();

        return redirect()->route('ask-post', ['postid' => $postid])->with('success', 'Proposition submitted successfully');
    }
}
