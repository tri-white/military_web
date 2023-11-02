<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RequestForRole;

class AdminController extends Controller
{
    public function viewVerificationRequests()
    {
        $verificationRequests = RequestForRole::orderBy('created_at', 'desc')->get();
        return view('manager/verification-requests', compact('verificationRequests'));
    }

}
