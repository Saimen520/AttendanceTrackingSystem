<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="{{ asset('css/Profile.css') }}">
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
    <script src="{{ asset('js/header.js') }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">   
</head>
<body>
    @include('partials.header')
    <section class="profile-container">
        <div class="profile-card">
            <div class="profile-image">
                <img src="{{ asset('Images/avatar.png') }}" alt="Profile Image">
            </div>
            <h2>Profile Detail</h2>

      

           <table>
                <tr><td><b>Name:</b></td><td>{{ Auth::user()->name }}</td></tr>
                <tr><td><b>IC/Passport:</b></td><td>{{ Auth::user()->ic_passport }}</td></tr>
                <tr><td><b>Date of Birth:</b></td><td>{{ Auth::user()->dob }}</td></tr>
                <tr><td><b>Contact No:</b></td><td>{{ Auth::user()->contact_no }}</td></tr>
                <tr><td><b>Address:</b></td><td>{{ Auth::user()->address }}</td></tr>
                <tr><td><b>Email:</b></td><td>{{ Auth::user()->email }}</td></tr>
                <tr><td><b>Role:</b></td><td>{{ Auth::user()->role->name ?? 'Unknown Role' }}</td></tr>
            </table>

             <!-- Logout Form -->
            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-btn">Log Out</button>
            </form>
        </div>
        <script src="{{ asset('js/logout.js') }}"></script>
    </section>
    
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
