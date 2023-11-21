<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RequestForRole;
use App\Models\User;
use App\Mail\DisapprovalEmail; 
use App\Mail\ApprovalEmail;
use Mail;
use DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Models\Payment;
class AdminController extends Controller
{
    public function viewVerificationRequests()
    {
        $verificationRequests = RequestForRole::orderBy('created_at', 'desc')->get();
        return view('manager/verification-requests', compact('verificationRequests'));
    }
    public function viewPayments()
    {
        $payments = Payment::orderBy('created_at', 'desc')->get();   
        return view('manager/payments', compact('payments'));
    }
    function getEnumValues($table, $field)
    {
        $type = DB::select("SHOW COLUMNS FROM $table WHERE Field = '$field'")[0]->Type;
        preg_match('/^enum\((.*)\)$/', $type, $matches);
        $values = array();
        foreach(explode(',', $matches[1]) as $value){
            $values[] = trim($value, "'");
        }

        return $values;
    }


    public function viewVerification($id){
        $request = RequestForRole::where('id', $id)->first();
        $compositions = $this->getEnumValues('users', 'composition');
        $profiles = $this->getEnumValues('users', 'profile');
    
        return view('manager/view-verification', compact('request', 'compositions', 'profiles'));
    }
    
    public function approveVerification(Request $request, $id){
        $verificationRequest = RequestForRole::find($id);
    
        if ($verificationRequest) {
            $verificationRequest->approved = 'Підтверджено';
            $verificationRequest->save();
    
            $user = User::find($verificationRequest->user_id);
            if($user->role_id == 1)
                $user->role_id = 2;
    
            $user->military_rank = $request->input('rankInput');
            $user->composition = $request->input('selectComposition');
            $user->profile = $request->input('selectProfile');
    
            $user->save();
            Mail::to($user->email)->send(new ApprovalEmail());
    
            return redirect()->back()->with('success', 'Заяву було підтверджено.');
        } else {
            return redirect()->back()->with('error', 'Заяву не знайдено.');
        }
    }
    
    
    public function disapproveVerification(Request $request, $id){
        $verificationRequest = RequestForRole::find($id);

        if ($verificationRequest) {
            $verificationRequest->approved = 'Відмовлено';
            $verificationRequest->save();
            $user = User::find($verificationRequest->user_id);

            Mail::to($user->email)->send(new DisapprovalEmail($request->input('reason')));

            return redirect()->back()->with('success', 'Заяву було відхилено.');
        } else {
            return redirect()->back()->with('error', 'Заяву не знайдено.');
        }
    }
    public function verificationToWaiting(Request $request, $id){
        $verificationRequest = RequestForRole::find($id);
        
        if ($verificationRequest) {
            $verificationRequest->approved = 'Очікування';
            $user = User::find($verificationRequest->user_id);
            if($user->role_id==2)
                $user->role_id = 1;
            $user->save();
            $verificationRequest->save();
            return redirect()->back()->with('success', 'Заяву було перенесено в стан очікування, а користувача повернено на роль звичайного користувача');
        } else {
            return redirect()->back()->with('error', 'Заяву не знайдено.');
        }
    }
    public function removeVerification(Request $request, $id){
        $verificationRequest = RequestForRole::find($id);
        
        if ($verificationRequest) {
            $verificationRequest->delete();
            return redirect()->route('verification-requests')->with('success', 'Заяву було видалено.');
        } else {
            return redirect()->back()->with('error', 'Заяву не знайдено');
        }
    }
    
    public function showBanForm(User $user)
    {
        return view('manager/ban-form', compact('user'));
    }

    public function processBanForm(Request $request, User $user)
    {
        $request->validate([
            'ban_expiration' => 'required|date_format:Y-m-d\TH:i|after:now',
        ]);

        $user->ban_expiration = $request->input('ban_expiration');

        $user->save();

        return redirect()->route('profile', ['userid' => $user->id])->with('success', 'Користувача заблоковано.');
    }
    public function unbanUser(User $user)
    {
        if (!$user->ban_expiration || \Carbon\Carbon::parse($user->ban_expiration)->isPast()) {
            return redirect()->back()->with('error', 'Користувач не є заблокованим.');
        }
        $user->ban_expiration = null;
        $user->save();

        return redirect()->back()->with('success', 'Користувача розблоковано.');
    }
    
}
