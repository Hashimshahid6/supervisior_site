<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Forgot Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <h1>Reset Forgot Password</h1>
		<p>Dear {{$user->name}}. Your request for new password is entertained and new password is generated successfully.</p>
		<p>Your new password is: <strong>{{$new_password}}</strong></p>
		<p>Use this password to login to your account.</p>
    <p>Regards</p>
    <p>{{$settings[0]->site_name}}</p>
</body>
</html>