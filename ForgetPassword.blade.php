<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forget Password  </title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
     <link rel="stylesheet" href="{{asset('css/loginpage.css')}}">
</head>
<body>
    <!-- Video Background -->
    <div class="video-container">
        <video autoplay loop muted disablepictureinpicture controlslist="nodownload noplaybackrate" playsinline>
            <source src="{{asset('Images/Loginpage.mp4')}}">
            Your browser does not support the video tag.
        </video>
    </div>

    <!-- Logo -->
    <div class="logo">
        <img src="{{asset('Images/INFINITECH.png')}}" alt="INFINITECH Logo">
    </div>

    <!-- Reset Password Box -->
    <div class="reset-container">
        <img src="{{asset('Images/avatar.png')}}" alt="User Avatar" class="avatar">
        <h2>Reset Your Password</h2>
        @if(session('success'))
            <div style="color: green; text-align: center; font-weight: bold;">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div style="color: red; text-align: center; font-weight: bold;">
                {{ session('error') }}
            </div>
        @endif


        <form id="resetForm" method="POST" action="{{ route('forget.password.post') }}">
            @csrf
            <div class="input-group">
                <input type="email" id="email" name="email" required placeholder="Enter Your Email">
            </div>
           
            <p>
                <a href="{{ route('login') }}">
                    &#8592; Back to Login
                </a>
            </p>
            <button type="submit" class="reset-btn">Check Email</button>
        </form>
    </div>
</body>
</html>
