<?php

namespace App\Repositories\Eloquent;



use App\Repositories\Contracts\ITeam;
use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class TeamRepository extends BaseRepository implements ITeam
{

    public function model()
    {
        return Team::class;
    }


    public function fetchUserTeams()
    {
        return Auth::user()->teams()->first();
    }
}