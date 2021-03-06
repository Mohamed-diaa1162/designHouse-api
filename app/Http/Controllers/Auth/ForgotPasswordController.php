<?php

namespace App\Http\Controllers\Auth;


use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;


    protected function sendResetLinkResponse(Request $request, $response)
    {
        return response()->json(['message' => trans($response)], 200) ;
    }


    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        return response()->json(['message' => trans($response)], 422);
    }


}