<?php

namespace App\Repositories\Contracts;

use Illuminate\Http\Request;



interface IDesgin
{
    public function applyTag($id, array $data);
    public function addComment($designId, array $data);
    public function like($id);
    public function search(Request $request);
}