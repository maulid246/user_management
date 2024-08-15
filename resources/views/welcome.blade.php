<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #6dd5ed, #2193b0);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            color: #fff;
        }
        .container {
            text-align: center;
            background-color: rgba(255, 255, 255, 0.2);
            padding: 50px;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
        }
        h1 {
            font-size: 3rem;
            margin-bottom: 20px;
        }
        p {
            font-size: 1.2rem;
            margin-bottom: 30px;
        }
        .btn-login {
            background-color: #fff;
            color: #2193b0;
            padding: 15px 30px;
            text-decoration: none;
            font-weight: bold;
            border-radius: 5px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        .btn-login:hover {
            background-color: #2193b0;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome to Our Website</h1>
        <p>Your one-stop solution for managing tasks and projects efficiently.</p>
        <a href="{{ route('login') }}" class="btn-login">Login</a>
    </div>
</body>
</html>
