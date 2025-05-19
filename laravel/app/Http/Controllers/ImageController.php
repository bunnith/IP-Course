<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image as InterventionImage;

class ImageController extends Controller
{
    public function create()
    {
        return view('upload_image');
    }
    public function store(Request $request)
    {
        // Validate image
        $request->validate([
            'image' => 'required|image|max:2048',
        ]);

        $image = $request->file('image');
        $fileName = uniqid() . '.' . $image->getClientOriginalExtension();

        // Store original in MinIO
        $originalPath = "uploads/{$fileName}";
        Storage::disk('minio')->put($originalPath, file_get_contents($image));

        // Create thumbnail (200x200) with Intervention
        $thumbImage = InterventionImage::make($image->getRealPath())
            ->fit(200, 200, function ($constraint) {
                $constraint->aspectRatio();
            });

        // Save thumbnail temporarily
        $tempThumbPath = storage_path("app/thumb_{$fileName}");
        $thumbImage->save($tempThumbPath);

        // Upload thumbnail to MinIO
        $thumbnailPath = "thumbnails/{$fileName}";
        Storage::disk('minio')->put($thumbnailPath, fopen($tempThumbPath, 'r+'));

        // Clean up local temp file
        unlink($tempThumbPath);


        // Redirect to gallery
        return redirect()->route('gallery')->with('success', 'Image uploaded and thumbnail created.');
    }

    public function gallery()
    {
        $thumbnails = Storage::disk('minio')->files('thumbnails');
        return view('gallery', compact('thumbnails'));
    }
}
