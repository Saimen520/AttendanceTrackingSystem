<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Tracking System</title>
    <link rel="stylesheet" href="{{asset('css/home.css')}}">
    <link rel="stylesheet" href="{{asset('css/header.css')}}">
      <link rel="stylesheet" href="{{asset('css/footer.css')}}">
    <script src="{{asset('js/notication.js')}}" defer></script>
</head>
<body>
  
    @include('partials.header')

    <!-- Background Video -->
    <section class="hero">
        <video autoplay muted loop>
            <source src="{{asset('Images/home.mp4')}}" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        <h1>START YOUR JOURNEY</h1>
    </section>

    <!-- Content Section -->
    <section class="content">
        <div class="image">
            <img src="{{('Images/home.jpg')}}" alt="IT Department Image">
        </div>
        <div class="description">
            <p>Welcome to our IT Department. Learn more about our history and mission.</p>
        </div>
    </section>

    <!-- Footer -->
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