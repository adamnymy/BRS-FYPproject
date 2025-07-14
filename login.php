<?php
session_start();
require_once 'config/db.php';

$error = '';
$success = '';

// Check if user is already logged in
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        $error = "Please fill in all fields";
    } else {
        try {
            $stmt = $pdo->prepare("SELECT * FROM CUSTOMER WHERE C_EMAIL = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['C_PASSWORD'])) {
                // Login successful
                $_SESSION['user_id'] = $user['C_ID'];
                $_SESSION['username'] = $user['C_USERNAME'];
                $_SESSION['role'] = $user['C_ROLE'];
                
                header("Location: customer_dashboard/c_dashboard.php");
                exit();
            } else {
                $error = "Invalid email or password";
            }
        } catch(PDOException $e) {
            $error = "Login failed. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - M&P Barbershop</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <div class="auth-container">
        <div class="auth-box">
            <div class="auth-header">
                <h2>Welcome to M&P Barbershop</h2>
                <p>Sign in to book your appointment</p>
            </div>

            <?php if ($error): ?>
                <div class="alert alert-danger">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="" class="auth-form">
                <div class="form-group">
                    <label for="email"><i class="fas fa-envelope"></i> Email</label>
                    <input type="email" id="email" name="email" required placeholder="Enter your email">
                </div>

                <div class="form-group">
                    <label for="password"><i class="fas fa-lock"></i> Password</label>
                    <input type="password" id="password" name="password" required placeholder="Enter your password">
                </div>

                <button type="submit" class="btn-primary">
                    <i class="fas fa-sign-in-alt"></i> Login
                </button>
            </form>

            <div class="auth-footer">
                <p>Don't have an account? <a href="signup.php" class="signup-link">Sign up</a></p>
                <!-- Hidden admin link -->
                <span class="hidden-admin" onclick="window.location.href='admin/adminlogin.php'">©</span>
            </div>
        </div>
    </div>

    <style>
        
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