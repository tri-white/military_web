<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RequestForRole;

class VerificationController extends Controller
{
    public function verificationView(){
        return view('user/verification');
    }
    public function verificationSave(Request $request, $userid){
        $role_requests = RequestForRole::where('user_id', $userid)->where('approved', 'Очікування')->get();
        if(!$role_requests->isEmpty()){
            return redirect()->route('welcome')->with('error', "Ваш запит на верифікацію вже отримано. Очікуйте результатів");
        }

        $role_requests = RequestForRole::where('user_id', $userid)->where('approved', 'Відмовлено')->get();
        if(!$role_requests->isEmpty()){
            return redirect()->route('welcome')->with('error', "Ваш запит на верифікацію вже отримано. Очікуйте результатів");
        }

        $request->validate([
            'verification_photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        $data = new RequestForRole();
        $imagePath =  $request->file('verification_photo')->store('verification_documents');
        $data->user_id = $userid;
        $data->ticket_photo =$imagePath;
        $data->save();
        return redirect()->route('welcome')->with('success', "Запит на верифікацію отримано. Наш менеджер найближчим часом його перевірить та надішле повідомлення на пошту");
        
    }
}
