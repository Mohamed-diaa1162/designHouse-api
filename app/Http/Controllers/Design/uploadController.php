<?php

namespace App\Http\Controllers\Design;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Resources\DesignResource;
use Illuminate\Http\Request;
use App\Jobs\UploadImage;
use App\Models\User;
use App\Repositories\Contracts\IDesgin;

class uploadController extends Controller
{


    protected $designs;

    public function __construct(IDesgin $designs)
    {
        $this->designs = $designs;
    }

    public function upload(Request $request)
    {
        $this->validate($request, [
            "image" => ["required", 'mimes:png,jpg,gif,bmp', 'max:2048']
        ]);

        // get the image

        $image = $request->file('image');
        $image_path = $image->getPathName();

        $fileName = time() . '_' . preg_replace('/\s+/', '_', strtolower($image->getClientOriginalName()));

        // move image to temp location

        $tmp = $image->storeAs('uploads/original', $fileName, 'tmp');

        // create record in database 
        $design = $this->designs->create([
            'user_id' => auth()->id(),
            'image' => $fileName,
            'disk' => config('site.upload_disk')
        ]);


        // UploadImage this is a job
        $this->dispatch(new UploadImage($design));


        return new DesignResource($design);
    }
}