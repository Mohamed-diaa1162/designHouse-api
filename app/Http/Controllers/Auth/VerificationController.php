<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Request;
use App\Models\User;


class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    public function verify(Request $request , User $user ) {
        if(! URL::hasValidSignature($request)) {

            return response()->json(['errors' => [
                'message' => "Invalid verification link "
            ]], 422) ;

        }

        if($user->hasVerifiedEmail()) {

            return response()->json(['errors' => [
                'message' => "This Email is Vaild"
            ]], 422) ; 

        }

        $user-> markEmailAsVerified() ;

        event(new Verified($user));

        return response()->json(['message' => 'Email successfuly verified']);

    }


    public function resend(Request $request) {
        
    }
}