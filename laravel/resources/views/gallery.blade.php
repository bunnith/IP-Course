<!DOCTYPE html>
<html>
<head>
    <title>Gallery</title>
</head>
<body>
    <h2>Image Gallery (Thumbnails from MinIO)</h2>

    @foreach ($thumbnails as $thumb)
        <div style="margin-bottom: 20px;">
        <img src="{{ Storage::disk('minio')->url($thumb) }}" width="200">
        </div>
    @endforeach

    <p><a href="{{ url('/upload-image') }}">Upload More</a></p>
</body>
</html>
