<?php

namespace App\Repositories\Eloquent;


use App\Repositories\Contracts\IDesgin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Design;

class DesginRepository extends BaseRepository implements IDesgin
{

    public function model()
    {
        return Design::class;
    }

    public function applyTag($id, array $data)
    {
        $design = $this->find($id);
        $design->retag($data);
    }

    public function addComment($designId, array $data)
    {
        $design = $this->find($designId);
        $comment = $design->comments()->create($data);

        return $comment;
    }


    public function like($id)
    {
        $design = $this->model->findOrFail($id);

        if ($design->isLikedByUser(Auth::id())) {
            return  $design->unLike();
        } else {
            return $design->like();
        }
    }


    public function isLikedByUser($id)
    {
        $design = $this->model->findOrFail($id);
        return $design->isLikedByUser(Auth::id());
    }

    public function search(Request $request)
    {
        $query = (new $this->model)->newQuery();
        $query->where('is_live', true);

        // Return with commments only
        if ($request->has_comments) {
            $query->has('comments');
        }

        // Return with Team only
        if ($request->has_team) {
            $query->has('team');
        }

        if ($request->q) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->q . '%')
                    ->orWhere('description', 'like', '%' . $request->q . '%');
            });
        } else {
            $query->latest();
        }

        if ($request->orderBy == 'likes') {
            $query->withCount('likes')->orderByDesc('likes_count');
            // ->orderByDesc('likes_count');
        }

        return $query->get();
    }
}