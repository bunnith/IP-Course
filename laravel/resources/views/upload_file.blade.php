<!-- resources/views/upload_file.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Upload File</title>
</head>
<body>
    <h1>Upload a File</h1>
    <form action="{{ route('upload') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="document" required>
        <button type="submit">Upload</button>
    </form>
</body>
</html>
