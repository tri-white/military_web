<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RequestForRole;
use App\Models\User;
use App\Mail\DisapprovalEmail; 
use App\Mail\ApprovalEmail;
use Mail;

class AdminController extends Controller
{
    public function viewVerificationRequests()
    {
        $verificationRequests = RequestForRole::orderBy('created_at', 'desc')->get();
        return view('manager/verification-requests', compact('verificationRequests'));
    }
    public function viewVerification($id){
        $data = RequestForRole::where('id',$id)->first();
        return view('manager/view-verification')->with('request',$data);
    }
    public function approveVerification(Request $request, $id){
        $verificationRequest = RequestForRole::find($id);
        
        if ($verificationRequest) {
            $verificationRequest->approved = 'Підтверджено';
            $verificationRequest->save();

            $user = User::find($verificationRequest->user_id);
            if($user->role_id==1)
                $user->role_id = 2;
            Mail::to($user->email)->send(new ApprovalEmail());
            $user->save();

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
    
    
}