<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proposition;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\ChangedProposition;
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

        return view('edit/proposition-edit', compact('proposition'));
    }
    
    public function editProposition(Request $request, $userid, $propositionid)
    {
        $request->validate([
            'price' => 'required|numeric|min:0',
            'message' => 'required|string',
            'photo' => 'image|mimes:jpg,jpeg,png|max:2048',
        ]);
        $user = User::findOrFail($userid);
        $proposition = Proposition::findOrFail($propositionid);
    
        $proposition->price = $request->input('price');
        $proposition->message = $request->input('message');
    
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('public/propositions');
            $proposition->photo = $photoPath;
        }
    
        $proposition->save();
    
        if($user->id != $proposition->user_id)
            Mail::to($user->email)->send(new ChangedProposition($proposition));

        return redirect()->route('ask-post', ['postid' => $proposition->post_ask_id])->with('success', 'Пропозицію успішно оновлено.');
    }
    
}
