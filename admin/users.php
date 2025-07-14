<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: adminlogin.php');
    exit;
}

require_once '../config/db.php';

$message = '';
$error = '';

// Handle user deletion
if (isset($_POST['delete_user'])) {
    try {
        $user_id = filter_var($_POST['user_id'], FILTER_SANITIZE_NUMBER_INT);
        $stmt = $pdo->prepare("DELETE FROM CUSTOMER WHERE C_ID = ?");
        $stmt->execute([$user_id]);
        $message = "User successfully deleted.";
    } catch (PDOException $e) {
        $error = "Error deleting user: " . $e->getMessage();
    }
}

// Fetch users from database
try {
    $stmt = $pdo->query("SELECT * FROM CUSTOMER ORDER BY C_CREATED_AT DESC");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error = "Error fetching users: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Users</title>
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
        .users-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: #222;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0,0,0,0.2);
        }
        .users-table th, .users-table td {
            padding: 14px 12px;
            text-align: left;
            border-bottom: 1px solid #333;
        }
        .users-table th {
            background-color: #1a1a1a;
            color: #d4af37;
            font-weight: 500;
        }
        .users-table tr:hover {
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
            .users-table th, .users-table td {
                padding: 8px 4px;
            }
        }
        .search-container {
            position: relative;
            margin-bottom: 20px;
            display: flex;
            justify-content: center;
        }
        .search-input {
            width: 350px;
            max-width: 100%;
            padding: 10px 40px 10px 15px;
            border: 1.5px solid #d4af37;
            border-radius: 4px;
            background: #181818;
            color: #fff;
            font-size: 1rem;
            transition: border 0.2s, box-shadow 0.2s;
        }
        .search-input:focus {
            border: 1.5px solid #bfa133;
            box-shadow: 0 0 0 2px rgba(212,175,55,0.13);
            outline: none;
        }
        .search-icon {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #d4af37;
            font-size: 1.1rem;
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
                <li><a href="users.php" class="active">Users</a></li>
                <li><a href="appointments.php">Appointments</a></li>
                <li><a href="services.php">Services</a></li>
                <li><a href="../index.php">Return to Home page</a></li>
            </ul>
        </nav>
        <main class="admin-main">
            <h2>Users Management</h2>
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
            <!-- Search Bar -->
            <div class="search-container">
                <input type="text" id="searchInput" placeholder="Search by User ID..." class="search-input">
                <i class="fas fa-search search-icon"></i>
            </div>
            <table class="users-table" id="usersTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Registered Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['C_ID']); ?></td>
                        <td><?php echo htmlspecialchars($user['C_USERNAME']); ?></td>
                        <td><?php echo htmlspecialchars($user['C_EMAIL']); ?></td>
                        <td><?php echo htmlspecialchars($user['C_ROLE']); ?></td>
                        <td><?php echo date('Y-m-d', strtotime($user['C_CREATED_AT'])); ?></td>
                        <td>
                            <form method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                <input type="hidden" name="user_id" value="<?php echo $user['C_ID']; ?>">
                                <button type="submit" name="delete_user" class="delete-btn">Delete</button>
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
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const table = document.getElementById('usersTable');
    const rows = table.getElementsByTagName('tr');

    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase().trim();
        // Start from index 1 to skip header row
        for (let i = 1; i < rows.length; i++) {
            const row = rows[i];
            const idCell = row.cells[0]; // ID is in the first column
            if (idCell) {
                const idText = idCell.textContent.toLowerCase();
                if (idText.includes(searchTerm)) {
                    row.style.display = '';
                    // Highlight the matching ID
                    if (searchTerm) {
                        idCell.style.backgroundColor = '#d4af37';
                        idCell.style.color = '#222';
                        idCell.style.fontWeight = 'bold';
                    } else {
                        idCell.style.backgroundColor = '';
                        idCell.style.color = '';
                        idCell.style.fontWeight = '';
                    }
                } else {
                    row.style.display = 'none';
                }
            }
        }
    });
});
</script>
</html>