<!DOCTYPE html>
<html>

<head>
    <title>Register - LAB-CHECK</title>
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

        .register-card {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            width: 100%;
            max-width: 450px;
            text-align: center;
        }

        .register-card h2 {
            color: #333;
            margin-bottom: 25px;
            letter-spacing: 1px;
        }

        .form-row {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
        }

        .form-group {
            text-align: left;
            margin-bottom: 20px;
            flex: 1;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #64748b;
            font-size: 13px;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 12px;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            box-sizing: border-box;
            font-size: 15px;
        }

        .btn-register {
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

        .login-link {
            margin-top: 25px;
            font-size: 14px;
            color: #64748b;
        }

        .login-link a {
            color: #008080;
            text-decoration: none;
            font-weight: bold;
        }

        .footer-logo {
            margin-top: 20px;
            color: #008080;
            font-weight: bold;
            font-size: 18px;
            opacity: 0.8;
        }
    </style>
</head>

<body>
    <div class="register-card">
        <h2>REGISTER</h2>
        <form action="/register" method="POST">
            @csrf
            <div class="form-group">
                <label>Full Name:</label>
                <input type="text" name="name" placeholder="Enter Full Name">
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Birth Date:</label>
                    <input type="text" name="birthday" placeholder="MM/DD/YYYY">
                </div>
                <div class="form-group">
                    <label>I am a:</label>
                    <select name="role">
                        <option value="student">Student</option>
                        <option value="staff">Staff</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label>E-Mail Address:</label>
                <input type="email" name="email" placeholder="example@uic.edu.ph">
            </div>

            <div class="form-group">
                <label>Password:</label>
                <input type="password" name="password" placeholder="Create Password">
            </div>

            <button type="submit" class="btn-register">Done</button>
        </form>

        <div class="login-link">
            Already have an account? <a href="/login">Login here!</a>
        </div>

        <div class="footer-logo">LAB-CHECK</div>
    </div>
</body>

</html>
