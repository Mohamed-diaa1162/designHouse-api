<?php

namespace App\Http\Controllers\User;

use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Rules\CheckTheSamePassword;
use App\Rules\MatchOldPassword;


class SettingController extends Controller
{


    public function updataProfile(Request $request)
    {
        $user = Auth::user();
        $this->validate($request, [
            'name' => ['required',],
            'tagline' => ['required'],
            'about' => ['required', 'string', 'min:25'],
            'formatted_address' => ['required'],
            'available_to_hire' => ['required'],
        ]);
        $user->update([
            'name' => $request->name,
            'tagline' => $request->tagline,
            'about' => $request->about,
            'formatted_address' => $request->formatted_address,
            'available_to_hire' => $request->available_to_hire
        ]);

        return new UserResource($user);
        // return $user; 

    }


    public function updataPassword(Request $request)
    {
        $this->validate($request, [
            'current_password' => ['required', new MatchOldPassword],
            'password' => ['required', 'confirmed', 'min:8', new CheckTheSamePassword]
        ]);

        $request->user()->update([
            'password' => bcrypt($request->password)
        ]);

        return response()->json(['message' => 'The Password has been Updated']);
    }
}