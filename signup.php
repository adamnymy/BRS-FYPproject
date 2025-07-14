<?php
session_start();
require_once 'config/db.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    
    if (empty($username) || empty($email) || empty($password)) {
        $error = "Please fill in all fields";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid email";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters";
    } else {
        try {
            // Check if email already exists
            $stmt = $pdo->prepare("SELECT C_ID FROM CUSTOMER WHERE C_EMAIL = ?");
            $stmt->execute([$email]);
            if ($stmt->fetch()) {
                $error = "Email already exists";
            } else {
                // Create new user
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("INSERT INTO CUSTOMER (C_USERNAME, C_EMAIL, C_PASSWORD, C_ROLE) VALUES (?, ?, ?, 'user')");
                $stmt->execute([$username, $email, $hashedPassword]);
                
                $success = "Account created successfully! Please login.";
                header("Location: login.php?registered=1");
                exit();
            }
        } catch(PDOException $e) {
            $error = "Registration failed. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - M&P Barbershop</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <div class="auth-container">
        <div class="auth-box">
            <div class="auth-header">
                <h2>Create Your Account</h2>
                <p>Join M&P Barbershop today</p>
            </div>

            <?php if ($error): ?>
                <div class="alert alert-danger">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="" class="auth-form">
                <div class="form-group">
                    <label for="username"><i class="fas fa-user"></i> Username</label>
                    <input type="text" id="username" name="username" required placeholder="Choose a username">
                </div>

                <div class="form-group">
                    <label for="email"><i class="fas fa-envelope"></i> Email</label>
                    <input type="email" id="email" name="email" required placeholder="Enter your email">
                </div>

                <div class="form-group">
                    <label for="password"><i class="fas fa-lock"></i> Password</label>
                    <input type="password" id="password" name="password" required placeholder="Create a password">
                </div>

                <button type="submit" class="btn-primary">
                    <i class="fas fa-user-plus"></i> Create Account
                </button>
            </form>

            <div class="auth-footer">
                <p>Already have an account? <a href="login.php" class="signup-link">Login</a></p>
            </div>
        </div>
    </div>

    <!-- Use the same CSS styles as in login.php -->
     <style>
        body {
            background: #f8f9fa;
            min-height: 100vh;
        }
        
        .auth-container {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
        }
        
        .auth-box {
            background: #fff;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .auth-header {
            text-align: center;
            margin-bottom: 40px;
        }
        
        .auth-header h2 {
            color: #333;
            font-size: 24px;
            margin-bottom: 10px;
        }
        
        .auth-header p {
            color: #666;
            font-size: 16px;
        }
        
        .form-group {
            margin-bottom: 25px;
            position: relative;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: 500;
        }
        
        .form-group input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e1e1e1;
            border-radius: 8px;
            font-size: 15px;
            transition: all 0.3s ease;
        }
        
        .form-group input:focus {
            border-color: #d4af37;
            outline: none;
            box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.1);
        }
        
        .btn-primary {
            width: 100%;
            padding: 14px;
            background: #d4af37;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            background: #c4a032;
            transform: translateY(-1px);
        }
        
        .alert {
            padding: 15px;
            margin-bottom: 25px;
            border-radius: 8px;
        }
        
        .alert-danger {
            background: #fff2f2;
            color: #dc3545;
            border: 1px solid #ffcdd2;
        }
        
        .auth-footer {
            text-align: center;
            margin-top: 30px;
            color: #666;
        }
        
        .signup-link {
            color: #d4af37;
            text-decoration: none;
            font-weight: 600;
        }
        
        .signup-link:hover {
            text-decoration: underline;
        }
        
        .fas {
            margin-right: 8px;
            color: #666;
        }
    </style>
</body>
</html>