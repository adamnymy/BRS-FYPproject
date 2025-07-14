<?php
session_start();
require_once '../config/db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$error = '';
$success = '';

// Get user data
try {
    $stmt = $pdo->prepare("SELECT * FROM CUSTOMER WHERE C_ID = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    $error = "Error fetching user data";
}

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $new_password = trim($_POST['new_password']);

    try {
        if (!empty($new_password)) {
            // Update with new password
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("UPDATE CUSTOMER SET C_USERNAME = ?, C_EMAIL = ?, C_PASSWORD = ? WHERE C_ID = ?");
            $stmt->execute([$username, $email, $hashed_password, $_SESSION['user_id']]);
        } else {
            // Update without changing password
            $stmt = $pdo->prepare("UPDATE CUSTOMER SET C_USERNAME = ?, C_EMAIL = ? WHERE C_ID = ?");
            $stmt->execute([$username, $email, $_SESSION['user_id']]);
        }
        
        // Update session data with new username
        $_SESSION['username'] = $username;
        
        // Refresh user data for display
        $stmt = $pdo->prepare("SELECT * FROM CUSTOMER WHERE C_ID = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $success = "Profile updated successfully";
        
        // Redirect to refresh the page and ensure session is updated
        header("Location: profile.php?updated=1");
        exit();
    } catch(PDOException $e) {
        $error = "Update failed. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - M&P Barbershop</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    
    <div class="profile-glass-bg"></div>
    <div class="profile-main">
        <div class="profile-glass-card">
            <div class="profile-avatar">
                <i class="fas fa-user-circle"></i>
            </div>
            <h2 class="profile-glass-heading">Edit Profile</h2>
            <?php if ($error): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            <?php if ($success): ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
            <?php endif; ?>
            <?php if (isset($_GET['updated']) && $_GET['updated'] == 1): ?>
                <div class="alert alert-success">Profile updated successfully!</div>
            <?php endif; ?>
            <form method="POST" action="" class="profile-glass-form">
                <div class="glass-input-group">
                    <span class="input-icon"><i class="fas fa-user"></i></span>
                    <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['C_USERNAME']); ?>" required placeholder="Username">
                </div>
                <div class="glass-input-group">
                    <span class="input-icon"><i class="fas fa-envelope"></i></span>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['C_EMAIL']); ?>" required placeholder="Email">
                </div>
                <div class="glass-input-group">
                    <span class="input-icon"><i class="fas fa-lock"></i></span>
                    <input type="password" id="new_password" name="new_password" autocomplete="new-password" placeholder="New Password (leave blank to keep current)">
                </div>
                <button type="submit" class="glass-btn-gold">Update Profile</button>
            </form>
        </div>
    </div>
    <a href="c_dashboard.php" class="back-dashboard-btn" title="Back to Dashboard">
        <i class="fas fa-arrow-left"></i> Back to Dashboard
    </a>

    <style>
    body {
        background:rgb(23, 0, 0);
        color: #333;
        margin: 0;
        font-family: 'Segoe UI', Arial, sans-serif;
        min-height: 100vh;
        position: relative;
    }
    .profile-glass-bg {
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: url('../images/bookbg.webp') center/cover no-repeat;
        filter: blur(24px) brightness(0.7);
        z-index: 0;
    }
    .profile-main {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        z-index: 1;
    }
    .profile-glass-card {
        background: rgba(255,255,255,0.18);
        box-shadow: 0 8px 32px 0 rgba(31,38,135,0.18);
        backdrop-filter: blur(16px) saturate(180%);
        -webkit-backdrop-filter: blur(16px) saturate(180%);
        border-radius: 28px;
        border: 1.5px solid rgba(255,255,255,0.25);
        padding: 48px 38px 38px 38px;
        max-width: 410px;
        width: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
    }
    .profile-avatar {
        width: 90px;
        height: 90px;
        background: rgba(255,255,255,0.45);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-top: -70px;
        margin-bottom: 18px;
        box-shadow: 0 2px 12px rgba(212,175,55,0.10);
        border: 2.5px solid #fffbe6;
        font-size: 3.2em;
        color: #d4af37;
    }
    .profile-glass-heading {
        font-size: 1.7em;
        font-weight: 700;
        color: #181818;
        margin-bottom: 28px;
        letter-spacing: 0.5px;
        text-align: center;
    }
    .profile-glass-form {
        width: 100%;
        display: flex;
        flex-direction: column;
        gap: 22px;
        margin-top: 0;
    }
    .glass-input-group {
        position: relative;
        display: flex;
        align-items: center;
        background: rgba(255,255,255,0.55);
        border-radius: 12px;
        box-shadow: 0 1px 6px rgba(212,175,55,0.04);
        border: 1.5px solid #f3e7c1;
        padding: 0 0 0 44px;
    }
    .glass-input-group input {
        border: none;
        outline: none;
        background: transparent;
        padding: 18px 14px 18px 0;
        font-size: 1.08em;
        width: 100%;
        color: #000;
        border-radius: 12px;
        font-weight: 500;
    }
    .glass-input-group input:disabled,
    .glass-input-group input[readonly] {
        color: #000;
        opacity: 0.7;
    }
    .glass-input-group input::placeholder {
        color: #888;
        opacity: 1;
        font-weight: 400;
    }
    .glass-input-group:focus-within {
        box-shadow: 0 2px 12px rgba(212,175,55,0.13);
        border-color: #d4af37;
        background: rgba(255, 255, 255, 0.85);
    }
    .input-icon {
        position: absolute;
        left: 16px;
        color: #d4af37;
        font-size: 1.18em;
        pointer-events: none;
    }
    .glass-btn-gold {
        width: 100%;
        padding: 16px;
        background: #d4af37;
        color: #fff;
        border: none;
        border-radius: 12px;
        font-size: 1.13em;
        font-weight: 700;
        cursor: pointer;
        transition: background 0.2s, box-shadow 0.2s, color 0.2s, transform 0.2s;
        margin-top: 10px;
        box-shadow: 0 2px 8px rgba(212,175,55,0.10);
        letter-spacing: 0.5px;
    }
    .glass-btn-gold:hover {
        background: #bfa133;
        color: #fff;
        transform: translateY(-2px) scale(1.03);
        box-shadow: 0 6px 18px rgba(212,175,55,0.18);
    }
    .alert {
        padding: 16px;
        border-radius: 12px;
        margin-bottom: 25px;
        font-weight: 500;
        width: 100%;
        text-align: center;
    }
    .alert-success {
        background: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }
    .alert-danger {
        background: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }
    .back-dashboard-btn {
        position: fixed;
        top: 32px;
        left: 32px;
        background: #d4af37;
        color: #222;
        padding: 14px 28px;
        border-radius: 12px;
        font-weight: 600;
        text-decoration: none;
        font-size: 1.08em;
        box-shadow: 0 2px 8px rgba(212,175,55,0.10);
        transition: background 0.2s, color 0.2s, transform 0.2s;
        display: flex;
        align-items: center;
        gap: 10px;
        z-index: 1000;
    }
    .back-dashboard-btn:hover {
        background: #bfa133;
        color: #222;
        transform: translateY(-2px) scale(1.03);
        box-shadow: 0 6px 18px rgba(212,175,55,0.18);
    }
    @media (max-width: 600px) {
        .profile-glass-card {
            padding: 28px 6px 24px 6px;
            max-width: 98vw;
        }
        .profile-avatar {
            width: 64px;
            height: 64px;
            font-size: 2em;
            margin-top: -40px;
        }
        .back-dashboard-btn {
            top: 16px;
            left: 16px;
            padding: 10px 18px;
            font-size: 0.98em;
        }
    }
    </style>
</body>
</html>