<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RequestForRole;

class AdminController extends Controller
{
    public function viewVerificationRequests()
    {
        $verificationRequests = RequestForRole::all();
        return view('manager/verification-requests', compact('verificationRequests'));
    }
}
