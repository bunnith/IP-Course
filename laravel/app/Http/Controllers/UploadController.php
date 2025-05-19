<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    /**
     * Display the file upload form.
     */
    public function showForm()
    {
        return view('upload_file');
    }

    /**
     * Handle the file upload.
     */
    public function upload(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'document' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Store file on the 'public' disk (local storage)
        $path = $request->file('document')->store('uploads', 'public');

        // Generate the public URL for the local file
        $publicUrl = Storage::disk('public')->url($path);

        // Store file in MinIO (configured as 'minio' disk in config/filesystems.php)
        $minioPath = $request->file('document')->store('uploads', 'minio');

        // Generate MinIO access URL
        $minioUrl = rtrim(env('MINIO_ENDPOINT'), '/') . '/' . env('MINIO_BUCKET') . '/' . $minioPath;

        dd([
    'endpoint' => env('MINIO_ENDPOINT'),
    'bucket' => env('MINIO_BUCKET'),
    'minioPath' => $minioPath,
                    ]);


        // Return response (can be JSON or a redirect, depending on frontend)
        return response()->json([
            'path' => $path,
            'public_url' => $publicUrl,
            'minio_url' => $minioUrl,
        ], 200);
    }
}
