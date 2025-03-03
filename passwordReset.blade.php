<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
</head>
<body>
    <h2>Password Reset Request</h2>
    <p>You are receiving this email because we received a password reset request for your account.</p>
    <p><a href="{{ route('reset.password.get', $token) }}">Reset Password</a></p>
    <p>If you did not request a password reset, no further action is required.</p>
</body>
</html>
