<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: /website/login.php');
    exit();
}

require_once '../config/db.php';

$user_id = $_SESSION['user_id'];

// Fetch booking status updates as notifications
$stmt = $pdo->prepare('SELECT BOOK_ID, BOOK_DATE, BOOK_TIME, BOOK_STATUS, BOOK_CREATED_AT FROM BOOKING WHERE C_ID = ? ORDER BY BOOK_CREATED_AT DESC');
$stmt->execute([$user_id]);
$notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Notifications</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: rgb(23, 0, 0);
            color: #333;
            margin: 0;
            font-family: 'Segoe UI', Arial, sans-serif;
            min-height: 100vh;
            position: relative;
        }
        .notifications-bg {
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: url('../images/bookbg.webp') center/cover no-repeat;
            filter: blur(24px) brightness(0.7);
            z-index: 0;
        }
        .notifications-main {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            z-index: 1;
        }
        .notifications-card {
            background: rgba(255,255,255,0.18);
            box-shadow: 0 8px 32px 0 rgba(31,38,135,0.18);
            backdrop-filter: blur(16px) saturate(180%);
            -webkit-backdrop-filter: blur(16px) saturate(180%);
            border-radius: 28px;
            border: 1.5px solid rgba(255,255,255,0.25);
            padding: 48px 38px 38px 38px;
            max-width: 600px;
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
        }
        .notifications-heading {
            font-size: 1.7em;
            font-weight: 700;
            color: #d4af37;
            margin-bottom: 28px;
            letter-spacing: 0.5px;
            text-align: center;
        }
        .notification-list {
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 18px;
        }
        .notification-card {
            background: rgba(255,255,255,0.55);
            border-radius: 12px;
            box-shadow: 0 1px 6px rgba(212,175,55,0.04);
            border: 1.5px solid #f3e7c1;
            padding: 18px 20px 14px 20px;
            display: flex;
            flex-direction: column;
            position: relative;
            transition: background 0.2s;
        }
        .notification-card.unread {
            background: #fffbe6;
            border-color: #d4af37;
        }
        .notification-message {
            color: #181818;
            font-size: 1.08em;
            margin-bottom: 6px;
        }
        .notification-time {
            color: #888;
            font-size: 0.98em;
            align-self: flex-end;
        }
        .booking-id {
            background: #d4af37;
            color: #222;
            padding: 2px 6px;
            border-radius: 4px;
            font-weight: bold;
            font-size: 0.95em;
            display: inline-block;
            margin: 0 2px;
        }
        .no-notifications {
            color: #aaa;
            text-align: center;
            margin-top: 24px;
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
            .notifications-card {
                padding: 28px 6px 24px 6px;
                max-width: 98vw;
            }
        }
    </style>
</head>
<body>
    <div class="notifications-bg"></div>
    <div class="notifications-main">
        <div class="notifications-card">
            <div class="notifications-heading"><i class="fas fa-bell"></i> Notifications</div>
            <div class="notification-list">
                <?php if (empty($notifications)): ?>
                    <div class="no-notifications">No notifications yet.</div>
                <?php else: ?>
                    <?php foreach ($notifications as $booking): ?>
                        <div class="notification-card">
                            <div class="notification-message">
                                Booking #<?php echo htmlspecialchars($booking['BOOK_ID']); ?>:
                                <?php echo htmlspecialchars($booking['BOOK_STATUS']); ?> on
                                <?php echo htmlspecialchars($booking['BOOK_DATE']); ?> at
                                <?php echo htmlspecialchars($booking['BOOK_TIME']); ?>
                            </div>
                            <div class="notification-time">
                                <?php echo date('d M Y, H:i', strtotime($booking['BOOK_CREATED_AT'])); ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <a href="c_dashboard.php" class="back-dashboard-btn" title="Back to Dashboard">
        <i class="fas fa-arrow-left"></i> Back to Dashboard
    </a>
    <style>
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
