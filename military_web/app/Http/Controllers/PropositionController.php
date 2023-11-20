<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proposition;
use App\Models\User;
use App\Mail\ChangedProposition;
use App\Mail\RemovedProposition;
class PropositionController extends Controller
{
    public function remove(Request $request, $propositionid, $userid){
        $user = User::find($userid);
        $proposition = Proposition::find($propositionid);

        if($request->has('reason'))
            Mail::to($user->email)->send(new RemovedProposition($request->input('reason')));
        
        $proposition->delete();
        return redirect()->back()->with('success','Пропозицію вилучено.');
    }
}
