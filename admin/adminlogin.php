<?php
session_start();

// Example hardcoded admin credentials
$admin_username = 'admin';
$admin_password = 'password123'; // Change this!

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($username === $admin_username && $password === $admin_password) {
        $_SESSION['admin_logged_in'] = true;
        header('Location: dashboard.php');
        exit;
    } else {
        $error = 'Invalid admin credentials.';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', Arial, sans-serif;
            min-height: 100vh;
            margin: 0;
            background: linear-gradient(135deg, #232526 0%, #414345 100%);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-container {
            width: 100%;
            max-width: 370px;
            margin: 40px auto;
            background: rgba(34, 34, 34, 0.98);
            padding: 38px 32px 32px 32px;
            border-radius: 18px;
            box-shadow: 0 8px 32px 0 rgba(0,0,0,0.25);
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .login-logo {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            background: #d4af37;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.2rem;
            color: #222;
            margin-bottom: 18px;
            box-shadow: 0 2px 8px rgba(212,175,55,0.15);
            font-weight: bold;
            letter-spacing: 1px;
        }
        h2 {
            color: #d4af37;
            text-align: center;
            margin-bottom: 24px;
            font-size: 1.7rem;
            font-weight: 600;
        }
        form {
            width: 100%;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 12px 14px;
            margin: 0 0 18px 0;
            border: 1.5px solid #444;
            border-radius: 6px;
            background: #232526;
            color: #fff;
            font-size: 1rem;
            transition: border 0.2s, box-shadow 0.2s;
            outline: none;
            box-sizing: border-box;
        }
        input[type="text"]:focus, input[type="password"]:focus {
            border: 1.5px solid #d4af37;
            box-shadow: 0 0 0 2px rgba(212,175,55,0.15);
        }
        input[type="submit"] {
            width: 100%;
            padding: 12px;
            background: linear-gradient(90deg, #d4af37 0%, #bfa13a 100%);
            color: #222;
            border: none;
            border-radius: 6px;
            font-weight: 600;
            font-size: 1.08rem;
            cursor: pointer;
            margin-top: 0;
            box-sizing: border-box;
            display: block;
            transition: background 0.2s, transform 0.1s;
        }
        input[type="submit"]:hover {
            background: linear-gradient(90deg, #e6c75a 0%, #d4af37 100%);
            transform: translateY(-2px) scale(1.03);
        }
        .error {
            color: #ff6666;
            text-align: center;
            margin-bottom: 18px;
            font-size: 1rem;
        }
        .exit-btn {
            display: block;
            width: 100%;
            padding: 12px;
            background: linear-gradient(90deg, #f44336 0%, #d32f2f 100%);
            color: #fff;
            text-align: center;
            border: none;
            border-radius: 6px;
            margin-top: 18px;
            text-decoration: none;
            font-weight: 600;
            font-size: 1.05rem;
            box-sizing: border-box;
            transition: background 0.2s, transform 0.1s;
        }
        .exit-btn:hover {
            background: linear-gradient(90deg, #ff6659 0%, #f44336 100%);
            transform: translateY(-2px) scale(1.03);
        }
        @media (max-width: 480px) {
            .login-container {
                padding: 24px 8px 18px 8px;
                max-width: 98vw;
            }
            h2 {
                font-size: 1.2rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-logo">A</div>
        <h2>Admin Login</h2>
        <?php if ($error): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form method="post" autocomplete="off">
            <input type="text" name="username" placeholder="Admin Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="submit" value="Login">
        </form>
        <a href="../index.php" class="exit-btn">Exit to Home Page</a>
    </div>
</body>
</html>