<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proposition;
use App\Models\User;
class PropositionController extends Controller
{
    public function remove(Request $request, $propositionid, $userid){
        $user = User::find($userid);
        $proposition = Proposition::find($propositionid);
        //mail to user
        $proposition->delete();
        return redirect()->back()->with('success','Пропозицію вилучено.');
    }
}
