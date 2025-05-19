<!DOCTYPE html>
<html>
<head>
    <title>Upload Image</title>
</head>
<body>
    <h2>Upload Image</h2>
    <form action="{{ url('/upload-image') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="image">Select an image:</label>
        <input type="file" name="image" accept="image/*" required>
        <button type="submit">Upload</button>
    </form>


    @if(session('success'))
        <p style="color:green">{{ session('success') }}</p>
    @endif
</body>
</html>
