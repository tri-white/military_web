<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RequestForRole;
use Carbon\Carbon;
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

        $threshold = Carbon::now()->subHours(24);
        
        $role_requests = RequestForRole::where('user_id', $userid)
            ->where('approved', 'Відмовлено')
            ->where('created_at', '>=', $threshold)
            ->get();
        
        if (!$role_requests->isEmpty()) {
            return redirect()->route('welcome')->with('error', "Неможливо відправити запит. Повинно пройти 24 години з останньої спроби.");
        }
        

        $request->validate([
            'verification_photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        $data = new RequestForRole();
        $imagePath =  $request->file('verification_photo')->store('public/verification_documents');
        $data->user_id = $userid;
        $data->ticket_photo = str_replace('public/', '', $imagePath);
        $data->save();
        return redirect()->route('welcome')->with('success', "Запит на верифікацію отримано. Наш менеджер найближчим часом його перевірить та надішле повідомлення на пошту");
        
    }
    
}
