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
        $previousUrl = url()->previous();
    
        return redirect($previousUrl)->with('success','Пропозицію вилучено.');
    }
    public function showRemoveForm($propositionid, $userid)
    {
        $proposition = Proposition::findOrFail($propositionid);

        return view('remove/remove-proposition', compact('proposition', 'userid'));
    }
}
