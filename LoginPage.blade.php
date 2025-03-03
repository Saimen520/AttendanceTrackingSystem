<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/loginpage.css') }}">
</head>
<body>

    <!-- Video Background -->
    <div class="video-container">
        <video autoplay loop muted disablepictureinpicture controlslist="nodownload noplaybackrate" playsinline>
            <source src="{{ asset('Images/Loginpage.mp4') }}" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </div>

    <!-- Logo -->
    <div class="logo">
        <img src="{{ asset('Images/INFINITECH.png') }}" alt="INFINITECH Logo">
    </div>

    <!-- Login Box -->
    <div class="login-container">
        <img src="{{ asset('Images/avatar.png') }}" alt="User Avatar" class="avatar">
        <h2>Welcome Back!</h2>

        <!-- Display Validation Errors -->
        @if ($errors->any())
            <div class="alert-danger">
                    @foreach ($errors->all() as $error)
                        {{ $error }}
                    @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required placeholder="Enter Your Email" value="{{ old('email') }}">
            </div>

            <div class="input-group">
                <label for="password">Password</label>
                <div class="password-wrapper">
                    <input type="password" id="password" name="password" required placeholder="Enter Your Password">
                    <i class="fa-solid fa-eye toggle-password" id="togglePassword"></i>
                </div>
            </div>

            <div class="options">
                <label><input type="checkbox" name="remember"> Remember Me</label>
                <a href="{{ route('ForgetPassword') }}">Forgot Password?</a>
            </div>

            <button type="submit" class="login-btn">Login</button>
        </form>
    </div>

    <script src="{{ asset('js/login.js') }}"></script>
    @if(session('success'))
    <script>
        alert("{{ session('success') }}");
    </script>
    @endif


</body>
</html>
