<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

require_once '../config/db.php';

// Count total users
$users_count = $pdo->query("SELECT COUNT(*) FROM CUSTOMER")->fetchColumn();

// Count upcoming appointments (today or later, status not cancelled)
$appointments_count = $pdo->query("SELECT COUNT(*) FROM BOOKING WHERE BOOK_DATE >= CURDATE() AND BOOK_STATUS != 'cancelled'")->fetchColumn();

// Count active services
$services_count = $pdo->query("SELECT COUNT(*) FROM SERVICE WHERE S_STATUS = 'active'")->fetchColumn();

// Get 5 most recent upcoming appointments
$sql = "SELECT b.BOOK_DATE, b.BOOK_TIME, u.C_USERNAME, s.S_SERVICENAME, br.B_NAME AS barber_name
        FROM BOOKING b
        JOIN CUSTOMER u ON b.C_ID = u.C_ID
        JOIN SERVICE s ON b.S_ID = s.S_ID
        JOIN BARBER br ON b.B_ID = br.B_ID
        WHERE b.BOOK_DATE >= CURDATE() AND b.BOOK_STATUS != 'cancelled'
        ORDER BY b.BOOK_DATE, b.BOOK_TIME
        LIMIT 5";
$stmt = $pdo->query($sql);
$recent_appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            background: #181818;
            color: #fff;
            margin: 0;
            font-family: 'Segoe UI', Arial, sans-serif;
        }
        .admin-header {
            background: #1a1a1a;
            padding: 20px 40px;
            font-size: 1.5rem;
            font-weight: bold;
            color: #d4af37;
            letter-spacing: 1px;
            border-bottom: 1px solid #222;
        }
        .admin-container {
            display: flex;
            min-height: 100vh;
        }
        .admin-sidebar {
            width: 220px;
            background: #222;
            padding: 30px 0;
            min-height: 100vh;
        }
        .admin-sidebar ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .admin-sidebar li {
            margin-bottom: 18px;
        }
        .admin-sidebar a {
            color: #fff;
            text-decoration: none;
            font-weight: 500;
            padding: 10px 32px;
            display: block;
            border-left: 4px solid transparent;
            transition: background 0.2s, border-color 0.2s;
        }
        .admin-sidebar a.active,
        .admin-sidebar a:hover {
            background: #1a1a1a;
            border-left: 4px solid #d4af37;
            color: #d4af37;
        }
        .admin-main {
            flex: 1;
            padding: 40px;
        }
        .admin-main h2 {
            color: #d4af37;
            margin-top: 0;
        }
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }
        .stat-card {
            background: #222;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            border: 1px solid #333;
            transition: transform 0.2s;
        }
        .stat-card:hover {
            transform: translateY(-5px);
        }
        .stat-icon {
            font-size: 2rem;
            margin-bottom: 10px;
        }
        .stat-number {
            font-size: 2.5rem;
            font-weight: bold;
            color: #d4af37;
            margin-bottom: 5px;
        }
        .stat-label {
            color: #888;
            font-size: 0.9rem;
        }
        .recent-activity {
            background: #222;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #333;
        }
        .recent-activity h3 {
            color: #d4af37;
            margin-top: 0;
            margin-bottom: 20px;
            font-size: 1.2rem;
        }
        .activity-item {
            padding: 15px;
            border-bottom: 1px solid #333;
        }
        .activity-item:last-child {
            border-bottom: none;
        }
        .activity-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .activity-date {
            color: #888;
            font-size: 0.9rem;
        }
        .activity-user {
            color: #d4af37;
            font-weight: 500;
        }
        .activity-message {
            margin-top: 10px;
            color: #888;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <div class="admin-header">
        <span>Barbershop Admin Dashboard</span>
    </div>
    <div class="admin-container">
        <nav class="admin-sidebar">
            <ul>
                <li><a href="dashboard.php" class="active">Dashboard</a></li>
                <li><a href="users.php">Users</a></li>
                <li><a href="appointments.php">Appointments</a></li>
                <li><a href="services.php">Services</a></li>
                <li><a href="../index.php">Return to Home page</a></li>
            </ul>
        </nav>
        <main class="admin-main">
            <h2>Welcome, Admin!</h2>
            <div class="stats-container">
                <div class="stat-card">
                    <div class="stat-icon">👥</div>
                    <div class="stat-number"><?php echo $users_count; ?></div>
                    <div class="stat-label">Total Users</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">📅</div>
                    <div class="stat-number"><?php echo $appointments_count; ?></div>
                    <div class="stat-label">Upcoming Appointments</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">✂️</div>
                    <div class="stat-number"><?php echo $services_count; ?></div>
                    <div class="stat-label">Active Services</div>
                </div>
            </div>

            <div class="recent-activity">
                <h3>Upcoming Appointments</h3>
                <div class="activity-list">
                    <?php if (count($recent_appointments) === 0): ?>
                        <div class="activity-item">No upcoming appointments.</div>
                    <?php else: ?>
                        <?php foreach ($recent_appointments as $appointment): ?>
                            <div class="activity-item">
                                <div class="activity-info">
                                    <span>
                                        <strong><?php echo htmlspecialchars($appointment['C_USERNAME']); ?></strong>
                                        booked <strong><?php echo htmlspecialchars($appointment['S_SERVICENAME']); ?></strong>
                                        with <strong><?php echo htmlspecialchars($appointment['barber_name']); ?></strong>
                                    </span>
                                    <span class="activity-date">
                                        <?php echo date('M d, Y', strtotime($appointment['BOOK_DATE'])); ?> at 
                                        <?php echo date('H:i', strtotime($appointment['BOOK_TIME'])); ?>
                                    </span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>
</body>
</html>