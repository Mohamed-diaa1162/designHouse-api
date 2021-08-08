<?php

namespace App\Repositories\Eloquent;


use App\Repositories\Contracts\IComment;
use App\Models\comment;


class CommentRepository extends BaseRepository implements IComment
{

    public function model()
    {
        return comment::class;
    }
}