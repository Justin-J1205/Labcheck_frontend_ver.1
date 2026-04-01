<!DOCTYPE html>
<html>
<head>
    <title>Register - LAB-CHECK</title>
    <style>
        body { margin: 0; font-family: 'Segoe UI', sans-serif; background: #f0f4f8; display: flex; height: 100vh; align-items: center; justify-content: center; }
        .register-card { background: white; padding: 40px; border-radius: 20px; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05); width: 100%; max-width: 450px; text-align: center; }
        .register-card h2 { color: #333; margin-bottom: 25px; letter-spacing: 1px; }
        .form-row { display: flex; gap: 15px; margin-bottom: 20px; }
        .form-group { text-align: left; margin-bottom: 20px; flex: 1; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #64748b; font-size: 13px; }
        .form-group input, .form-group select { width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 10px; box-sizing: border-box; font-size: 15px; }
        .btn-register { width: 100%; padding: 14px; background: #008080; color: white; border: none; border-radius: 10px; font-weight: bold; font-size: 16px; cursor: pointer; margin-top: 10px; }
        .login-link { margin-top: 25px; font-size: 14px; color: #64748b; }
        .login-link a { color: #008080; text-decoration: none; font-weight: bold; }
        .footer-logo { margin-top: 20px; color: #008080; font-weight: bold; font-size: 18px; opacity: 0.8; }
        .error-list { color: #dc3545; background: #f8d7da; padding: 10px; border-radius: 10px; margin-bottom: 20px; text-align: left; font-size: 13px; }
    </style>
</head>
<body>
    <div class="register-card">
        <h2>REGISTER</h2>

        @if ($errors->any())
            <div class="error-list">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST">
            @csrf

            <div class="form-group">
                <label>Full Name:</label>
                <input type="text" name="full_name" value="{{ old('full_name') }}" placeholder="Enter Full Name" required>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Birth Date:</label>
                    <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}" required>
                </div>
                <div class="form-group">
                    <label>I am a:</label>
                    <select name="role">
                        <option value="student" {{ old('role') == 'student' ? 'selected' : '' }}>Student</option>
                        <option value="staff" {{ old('role') == 'staff' ? 'selected' : '' }}>Staff</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label>E-Mail Address:</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="example@uic.edu.ph" required>
            </div>

            <div class="form-group">
                <label>Password:</label>
                <input type="password" name="password" placeholder="Min. 8 characters" required>
            </div>

            <div class="form-group">
                <label>Confirm Password:</label>
                <input type="password" name="password_confirmation" placeholder="Repeat Password" required>
            </div>

            <button type="submit" class="btn-register">Done</button>
        </form>

        <div class="login-link">
            Already have an account? <a href="{{ route('login') }}">Login here!</a>
        </div>

        <div class="footer-logo">LAB-CHECK</div>
    </div>
</body>
</html>