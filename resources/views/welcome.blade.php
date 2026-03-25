<!DOCTYPE html>
<html>

<head>
    <title>Welcome to LAB-CHECK</title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #004d4d 0%, #008080 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .hero-container {
            display: flex;
            max-width: 1000px;
            width: 90%;
            align-items: center;
            gap: 50px;
        }

        .content {
            flex: 1;
        }

        .logo-text {
            font-size: 48px;
            font-weight: bold;
            margin-bottom: 20px;
            letter-spacing: 2px;
        }

        .description {
            font-size: 18px;
            line-height: 1.6;
            opacity: 0.9;
            margin-bottom: 40px;
        }

        .btn-group {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .btn {
            display: inline-block;
            padding: 15px 35px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: bold;
            text-align: center;
            width: 200px;
            transition: 0.3s;
        }

        .btn-white {
            background: white;
            color: #004d4d;
        }

        .btn-outline {
            border: 2px solid white;
            color: white;
        }

        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .image-placeholder {
            flex: 1;
            background: rgba(255, 255, 255, 0.1);
            height: 400px;
            border-radius: 20px;
            border: 2px dashed rgba(255, 255, 255, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>

<body>
    <div class="hero-container">
        <div class="content">
            <div class="logo-text">LAB-CHECK</div>
            <p class="description">
                Step into a smarter, safer, and more efficient laboratory. From real-time chemical tracking to seamless
                equipment booking, we provide the tools you need.
            </p>
            <div class="btn-group">
                <a href="/login" class="btn btn-white">Get Started ></a>
                <a href="#" class="btn btn-outline">Staff Features</a>
            </div>
        </div>
        <div class="image-placeholder">
            <span style="opacity: 0.5;">[ Lab Image Asset ]</span>
        </div>
    </div>
</body>

</html>
