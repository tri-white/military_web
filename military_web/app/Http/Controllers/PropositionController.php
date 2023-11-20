<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proposition;
use App\Models\User;
use App\Mail\ChangedProposition;
use Illuminate\Support\Facades\Mail;
use App\Mail\RemovedProposition;
use App\Models\PostAsk;
class PropositionController extends Controller
{
    public function remove(Request $request, $propositionid, $userid){
        $user = User::find($userid);
        $proposition = Proposition::find($propositionid);
        $post = PostAsk::find($proposition->post_ask_id);
        if($request->has('reason'))
            Mail::to($user->email)->send(new RemovedProposition($request->input('reason'), $post, $proposition));
        
        $proposition->delete();
        return redirect()->route('welcome')->with('success','Пропозицію вилучено.');
    }
    public function showRemoveForm($propositionid, $userid)
    {
        $proposition = Proposition::findOrFail($propositionid);

        return view('remove/remove-proposition', compact('proposition', 'userid'));
    }
    public function edit($propositionid)
    {
        $proposition = Proposition::find($propositionid);

        return view('edit/proposition-edit', compact('post'));
    }
    
    public function editProposition(Request $request, $userid, $propositionid)
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

        // return to post-ask
        return redirect()->route('welcome')->with('success', 'Пропозицію успішно оновлено.');
    }
}
