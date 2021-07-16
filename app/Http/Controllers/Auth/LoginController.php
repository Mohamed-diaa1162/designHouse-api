<?php

namespace App\Http\Controllers\Auth;


use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;



class LoginController extends Controller
{

    use AuthenticatesUsers;

    protected function attemptLogin(Request $request)
    {
        $token  =   $this->guard()->attempt($this->credentials($request));

        if (! $token) {
            return false ;
        }

        $user = $this->guard()->user() ;

        if($user instanceof MustVerifyEmail && ! $user->hasVerifiedEmail()) {
            return false ;
        }

        $this->guard()->setToken($token);

        return true ;
    }

    protected function sendLoginResponse(Request $request)
    {
        $this->clearLoginAttempts($request);

        $token = (string)$this->guard()->getToken();

        $expration = $this->guard()->payload()->get('exp');

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' =>  $expration
        ]);

        
    }

    protected function sendFailedLoginResponse(Request $request) {
        $user = $this->guard()->user() ;
            
        if($user instanceof MustVerifyEmail && ! $user->hasVerifiedEmail()) {
            return response()->json(['errors' => [
                'Verify' => 'You Need To Verify Your Email'
            ]]) ;
        }

        throw ValidationException::withMessages([
            $this->username() => "Authentication Failed"
        ]);
    }


    public function logout()
    {
        $this->guard()->logout();

        return response()->json([
            'message' => 'You Loged Out Successfully'
        ]);
    }

}