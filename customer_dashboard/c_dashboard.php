<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: /website/login.php');
    exit();
}

require_once '../config/db.php';

// Fetch user info
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare('SELECT C_USERNAME, C_EMAIL FROM CUSTOMER WHERE C_ID = ?');
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    $username = $user['C_USERNAME'];
    $email = $user['C_EMAIL'];
} else {
    $username = "Unknown User";
    $email = "";
}

// Remove notifications table usage
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Dashboard</title>
    <link rel="stylesheet" href="../styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            color: #333;
            margin: 0;
            font-family: 'Segoe UI', Arial, sans-serif;
            min-height: 100vh;
            position: relative;
        }
        .dashboard-bg {
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: url('../images/bookbg.webp') center/cover no-repeat;
            filter: blur(20px) brightness(0.3) saturate(1.2);
            z-index: 0;
        }
        .dashboard-main {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            z-index: 1;
            padding: 20px;
        }
        .dashboard-container {
            background: rgba(255,255,255,0.12);
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            border-radius: 32px;
            border: 1px solid rgba(255,255,255,0.2);
            padding: 48px 40px 40px 40px;
            max-width: 900px;
            width: 100%;
            position: relative;
            box-shadow: 0 25px 50px rgba(0,0,0,0.25);
        }
        .dashboard-header-section {
            text-align: center;
            margin-bottom: 48px;
            position: relative;
        }
        .dashboard-avatar {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, #d4af37, #f4d03f);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: -80px auto 24px auto;
            box-shadow: 0 8px 32px rgba(212,175,55,0.3);
            border: 4px solid rgba(255,255,255,0.9);
            font-size: 3.5em;
            color: #fff;
        }
        .dashboard-welcome {
            color: #fff;
            font-size: 2.4em;
            font-weight: 700;
            margin-bottom: 8px;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }
        .dashboard-email {
            color: rgba(255,255,255,0.8);
            font-size: 1.1em;
            margin-bottom: 0;
        }
        .dashboard-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 24px;
            margin-top: 32px;
        }
        .dashboard-action-card {
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            border: 1px solid rgba(255,255,255,0.2);
            padding: 32px 20px 24px 20px;
            text-align: center;
            transition: all 0.3s ease;
            text-decoration: none;
            color: #fff;
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            overflow: hidden;
        }
        .dashboard-action-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
            transition: left 0.5s;
        }
        .dashboard-action-card:hover::before {
            left: 100%;
        }
        .dashboard-action-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
            background: rgba(255,255,255,0.2);
            border-color: rgba(212,175,55,0.5);
        }
        .dashboard-action-card i {
            font-size: 2.5em;
            margin-bottom: 16px;
            color: #d4af37;
            transition: all 0.3s ease;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.3));
        }
        .dashboard-action-card:hover i {
            transform: scale(1.1);
            color: #f4d03f;
        }
        .dashboard-action-card span {
            font-size: 1.1em;
            font-weight: 600;
            color: #fff;
            text-shadow: 0 1px 2px rgba(0,0,0,0.3);
        }
        .dashboard-action-card.logout-card {
            background: rgba(220,38,38,0.2);
            border-color: rgba(220,38,38,0.3);
        }
        .dashboard-action-card.logout-card:hover {
            background: rgba(220,38,38,0.3);
            border-color: rgba(220,38,38,0.5);
        }
        .dashboard-action-card.logout-card i {
            color: #fca5a5;
        }
        .dashboard-action-card.logout-card:hover i {
            color: #fecaca;
        }
        .notification-badge {
            position: absolute;
            top: 12px;
            right: 22px;
            background: #e53e3e;
            color: #fff;
            border-radius: 50%;
            min-width: 22px;
            height: 22px;
            font-size: 0.98em;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 1px 4px rgba(0,0,0,0.18);
            z-index: 2;
            border: 2px solid #fff;
        }
        .dashboard-action-card.notification-card {
            position: relative;
        }
        @media (max-width: 768px) {
            .dashboard-main { padding: 10px; }
            .dashboard-container { padding: 32px 20px 32px 20px; }
            .dashboard-avatar {
                width: 80px;
                height: 80px;
                font-size: 2.8em;
                margin-top: -60px;
            }
            .dashboard-welcome { font-size: 2em; }
            .dashboard-actions { gap: 16px; }
            .dashboard-action-card { padding: 24px 16px 20px 16px; }
        }
    </style>
</head>
<body>
    <div class="dashboard-bg"></div>
    <div class="dashboard-main">
        <div class="dashboard-container">
            <div class="dashboard-header-section">
                <div class="dashboard-avatar">
                    <i class="fas fa-user-circle"></i>
                </div>
                <h2 class="dashboard-welcome">Welcome back, <?php echo htmlspecialchars($username); ?>!</h2>
                <div class="dashboard-email"><i class="fas fa-envelope"></i> <?php echo htmlspecialchars($email); ?></div>
            </div>
            
            <div class="dashboard-actions">
                <a href="profile.php" class="dashboard-action-card">
                    <i class="fas fa-user-edit"></i>
                    <span>Edit Profile</span>
                </a>
                <a href="my-bookings.php" class="dashboard-action-card">
                    <i class="fas fa-calendar-alt"></i>
                    <span>View My Bookings</span>
                </a>
                <a href="notifications.php" class="dashboard-action-card notification-card">
                    <i class="fas fa-bell"></i>
                    <span>Notifications</span>
                    <?php // if ($unread_count > 0): ?>
                        <!-- <span class="notification-badge"><?php echo $unread_count; ?></span> -->
                    <?php // endif; ?>
                </a>
                <a href="../index.php" class="dashboard-action-card">
                    <i class="fas fa-home"></i>
                    <span>Back to Home</span>
                </a>
                <a href="#" onclick="confirmLogout()" class="dashboard-action-card logout-card">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Log Out</span>
                </a>
            </div>
            

        </div>
    </div>
    
    <script>
        function confirmLogout() {
            if (confirm('Are you sure you want to logout?')) {
                window.location.href = '../logout.php';
            }
        }
    </script>
</body>
</html>
