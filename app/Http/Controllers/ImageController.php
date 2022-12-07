<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageRequest;
use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class ImageController extends Controller
{
    public function store(ImageRequest $imagerequest)
    {
        $imagerequest->validated();

        $uploaded = [];
        $imagesUrl = [];

        if ($imagerequest->hasFile('image')) {
            // dd($imagerequest->file('image'));
            $uploaded = [];
            foreach ($imagerequest->file('image') as $image) {
                $uploaded[] = $image;
                // dd($uploaded);
            }
        }
        for ($i = 0; $i < count($uploaded); $i++) {
            $uploadedUrl = Cloudinary::upload($uploaded[$i]->getRealPath())->getSecurePath();
            $imagesUrl[] = $uploadedUrl;
        }
        return response([
            'image_url' => $imagesUrl,
        ], 201);
    }
}
