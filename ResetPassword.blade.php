<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the values of the form fields
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];

    // Initialize error and success messages
    $errorMessage = "";
    $successMessage = "";

    // Check if the passwords match
    if ($newPassword !== $confirmPassword) {
        $errorMessage = "Passwords do not match";
    } else {
        // You can add your password update logic here
        // For example, update the password in the database using the token

        // Assuming password change was successful
        $successMessage = "Password Change Successful!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="{{asset('css/loginpage.css')}}">
   
    </style>
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
        <h2>Set New Password</h2>

        <form method="POST" action="{{ route('reset.password.post') }}" id="resetForm">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <div class="input-group">
                <input type="email" name="email" id="email" placeholder="Enter Your Email" required>
            </div>

            <div class="input-group">
                <input type="password" name="password" id="newPassword" placeholder="New Password" required>
            </div>

            <div class="input-group">
                <input type="password" name="password_confirmation" id="confirmPassword" placeholder="Confirm Password" required>
            </div>
            @if ($errors->any())
                <div style="color: red; text-align: center; font-weight: bold;">
                    
                        @foreach ($errors->all() as $error)
                            {{ $error }}
                        @endforeach
                    
                </div>
            @endif
            <button type="submit" class="reset-btn">Update Password</button>
        </form>
    </div>
</body>
</html>
