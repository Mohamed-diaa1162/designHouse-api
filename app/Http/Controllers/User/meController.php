<?php

namespace App\Http\Controllers\User;
use App\Http\Resources\UserResource;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class meController extends Controller
{
    public function getMe()
    {
        
        if(auth()->check()) {
            $user = Auth::user() ;
            return new UserResource($user);
        }

        return response()->json(null , 401);

    }
}