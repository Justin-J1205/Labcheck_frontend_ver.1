<!DOCTYPE html>
<html>

<head>
    <title>Login - LAB-CHECK</title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: #f0f4f8;
            display: flex;
            height: 100vh;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        .login-card h2 {
            color: #333;
            margin-bottom: 30px;
            letter-spacing: 1px;
        }

        .form-group {
            text-align: left;
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #64748b;
            font-size: 14px;
        }

        .form-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            box-sizing: border-box;
            font-size: 16px;
        }

        .btn-login {
            width: 100%;
            padding: 14px;
            background: #008080;
            color: white;
            border: none;
            border-radius: 10px;
            font-weight: bold;
            font-size: 16px;
            cursor: pointer;
            margin-top: 10px;
        }

        .signup-link {
            margin-top: 25px;
            font-size: 14px;
            color: #64748b;
        }

        .signup-link a {
            color: #008080;
            text-decoration: none;
            font-weight: bold;
        }

        .footer-logo {
            margin-top: 30px;
            color: #008080;
            font-weight: bold;
            font-size: 20px;
        }
    </style>
</head>

<body>
    <div class="login-card">
        <h2>LOGIN</h2>
        <form action="/login" method="POST">
            @csrf
            <div class="form-group">
                <label>Enter Full Name:</label>
                <input type="text" name="name" placeholder="John Doe">
            </div>
            <div class="form-group">
                <label>Enter E-Mail:</label>
                <input type="email" name="email" placeholder="email@uic.edu.ph">
            </div>
            <div class="form-group">
                <label>Enter Password:</label>
                <input type="password" name="password" placeholder="••••••••">
            </div>
            <button type="submit" class="btn-login">Login</button>
        </form>

        <div class="signup-link">
            Don't have an account? <br>
            <a href="/register">Sign up here!</a>
        </div>

        <div class="footer-logo">LAB-CHECK</div>
    </div>
</body>

</html>
