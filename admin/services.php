<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: adminlogin.php');
    exit;
}

require_once '../config/db.php';

$message = '';
$error = '';

// Handle service deletion
if (isset($_POST['delete_service'])) {
    try {
        $service_id = filter_var($_POST['service_id'], FILTER_SANITIZE_NUMBER_INT);
        $stmt = $pdo->prepare("DELETE FROM SERVICE WHERE S_ID = ?");
        $stmt->execute([$service_id]);
        $message = "Service successfully deleted.";
    } catch (PDOException $e) {
        $error = "Error deleting service: " . $e->getMessage();
    }
}

// Fetch all services
try {
    $stmt = $pdo->query("SELECT * FROM SERVICE ORDER BY S_ID DESC");
    $services = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error = "Error fetching services: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Services</title>
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
        .services-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: #222;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0,0,0,0.2);
        }
        .services-table th, .services-table td {
            padding: 14px 12px;
            text-align: left;
            border-bottom: 1px solid #333;
        }
        .services-table th {
            background-color: #1a1a1a;
            color: #d4af37;
            font-weight: 500;
        }
        .services-table tr:hover {
            background-color: #232323;
        }
        .delete-btn {
            background-color: #c53030;
            color: white;
            border: none;
            padding: 6px 16px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        .delete-btn:hover {
            background-color: #9b2c2c;
        }
        .alert {
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .alert-success {
            background-color: #276749;
            color: #c6f6d5;
            border: 1px solid #38a169;
        }
        .alert-error {
            background-color: #9b2c2c;
            color: #fed7d7;
            border: 1px solid #feb2b2;
        }
        @media (max-width: 900px) {
            .admin-main {
                padding: 20px 5px;
            }
            .services-table th, .services-table td {
                padding: 8px 4px;
            }
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
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="users.php">Users</a></li>
                <li><a href="appointments.php">Appointments</a></li>
                <li><a href="services.php" class="active">Services</a></li>
                <li><a href="../index.php">Return to Home page</a></li>
            </ul>
        </nav>
        <main class="admin-main">
            <h2>Services Management</h2>
            <?php if ($message): ?>
            <div class="alert alert-success">
                <?php echo htmlspecialchars($message); ?>
            </div>
            <?php endif; ?>
            <?php if ($error): ?>
            <div class="alert alert-error">
                <?php echo htmlspecialchars($error); ?>
            </div>
            <?php endif; ?>
            <?php if (!$error): ?>
            <table class="services-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Service Name</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($services as $service): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($service['S_ID']); ?></td>
                        <td><?php echo htmlspecialchars($service['S_SERVICENAME']); ?></td>
                        <td>RM <?php echo htmlspecialchars(number_format($service['S_PRICE'], 2)); ?></td>
                        <td><?php echo htmlspecialchars(ucfirst($service['S_STATUS'])); ?></td>
                        <td>
                            <form method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this service?');">
                                <input type="hidden" name="service_id" value="<?php echo $service['S_ID']; ?>">
                                <button type="submit" name="delete_service" class="delete-btn">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php endif; ?>
        </main>
    </div>
</body>
</html>