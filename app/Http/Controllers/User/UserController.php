<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Repositories\Contracts\IUser;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $users;
    public function __construct(IUser $users)
    {
        $this->users = $users;
    }
    public function index()
    {
        $Users = $this->users->all();
        return UserResource::collection($Users);
    }

    public function search(Request $request)
    {
        $designers = $this->users->search($request);
        return UserResource::collection($designers);
    }

    public function findByUsername($username)
    {
        $user = $this->users->findWhereFirst('username', $username);
        return new UserResource($user);
    }
}