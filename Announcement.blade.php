<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Announcement</title>
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
   
    <link rel="stylesheet" href="{{ asset('css/announcement.css') }}">
</head>
<body>
    @include('partials.header')
    <div class="container">
        <h2>Create Announcement</h2>
        @if(session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif
        <form action="{{ route('announcement.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" id="title" name="title" required>
            </div>
            <div class="form-group">
                <label for="message">Message</label>
                <textarea id="message" name="message" rows="5" required></textarea>
            </div>
            <div class="form-group">
                <label for="document">Attach Document</label>
                <input type="file" id="document" name="document">
            </div>
            <button type="submit" class="btn-primary">Submit</button>
        </form>
    </div>
    <footer>
        <p>&copy; 2024 Company IT, All rights reserved</p>
        <div class="links">
            <a href="#">Privacy</a>
            <a href="#">Terms of Service</a>
            <a href="#">Contact Us</a>
        </div>
        <div class="social-media">
            <span>Follow us:</span>
            <a href="#">🔵</a>
            <a href="#">🟠</a>
            <a href="#">🟢</a>
        </div>
    </footer>
</body>
</html>