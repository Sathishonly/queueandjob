<!DOCTYPE html>
<html>
<head>
    <title>Your OTP Code</title>
</head>
<body>
    <p>Dear {{ $user->email }},</p>
    <p>Your OTP code is: <strong>{{ $otp }}</strong></p>
    <p>Please use this code to complete your login.</p>
    <p>Thank you,</p>
    <p>Your Application Team</p>
</body>
</html>
