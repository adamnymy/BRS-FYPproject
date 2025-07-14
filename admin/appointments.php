<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: adminlogin.php');
    exit;
}

require_once '../config/db.php';

$message = '';
$error = '';

// Handle appointment deletion
if (isset($_POST['delete_appointment'])) {
    try {
        $appointment_id = filter_var($_POST['appointment_id'], FILTER_SANITIZE_NUMBER_INT);
        $stmt = $pdo->prepare("DELETE FROM BOOKING WHERE BOOK_ID = ?");
        $stmt->execute([$appointment_id]);
        $message = "Appointment successfully deleted.";
    } catch (PDOException $e) {
        $error = "Error deleting appointment: " . $e->getMessage();
    }
}

// Handle appointment status update
if (isset($_POST['update_status'])) {
    try {
        $appointment_id = filter_var($_POST['appointment_id'], FILTER_SANITIZE_NUMBER_INT);
        $new_status = $_POST['new_status'];
        $allowed_statuses = ['pending', 'confirmed', 'completed', 'cancelled'];
        if (in_array($new_status, $allowed_statuses)) {
            // Fetch booking details
            $stmt = $pdo->prepare("SELECT C_ID, BOOK_DATE, BOOK_TIME FROM BOOKING WHERE BOOK_ID = ?");
            $stmt->execute([$appointment_id]);
            $booking = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($booking) {
                $user_id = $booking['C_ID'];
                $date = $booking['BOOK_DATE'];
                $time = $booking['BOOK_TIME'];
                $stmt = $pdo->prepare("UPDATE BOOKING SET BOOK_STATUS = ? WHERE BOOK_ID = ?");
                $stmt->execute([$new_status, $appointment_id]);
                $message = "Appointment status updated to '" . htmlspecialchars(ucfirst($new_status)) . "'.";
            }
        } else {
            $error = "Invalid status selected.";
        }
    } catch (PDOException $e) {
        $error = "Error updating status: " . $e->getMessage();
    }
}

// Fetch all appointments
try {
    $sql = "SELECT b.BOOK_ID, u.C_USERNAME, br.B_NAME AS barber_name, s.S_SERVICENAME, b.BOOK_DATE, b.BOOK_TIME, b.BOOK_STATUS
            FROM BOOKING b
            JOIN CUSTOMER u ON b.C_ID = u.C_ID
            JOIN BARBER br ON b.B_ID = br.B_ID
            JOIN SERVICE s ON b.S_ID = s.S_ID
            ORDER BY b.BOOK_DATE DESC, b.BOOK_TIME DESC";
    $stmt = $pdo->query($sql);
    $appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error = "Error fetching appointments: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Appointments</title>
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
        .appointments-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: #222;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0,0,0,0.2);
        }
        .appointments-table th, .appointments-table td {
            padding: 14px 12px;
            text-align: left;
            border-bottom: 1px solid #333;
        }
        .appointments-table th {
            background-color: #1a1a1a;
            color: #d4af37;
            font-weight: 500;
        }
        .appointments-table tr:hover {
            background-color: #232323;
        }
        .appointments-table td.actions-cell {
            padding-top: 8px;
            padding-bottom: 8px;
        }
        .actions-row {
            display: flex;
            flex-direction: row;
            align-items: center;
            gap: 10px;
            width: 100%;
        }
        .actions-row select[name="new_status"] {
            padding: 6px 10px;
            border-radius: 4px;
            border: 1.5px solid #d4af37;
            background: #181818;
            color: #fff;
            font-weight: 500;
            transition: border 0.2s, box-shadow 0.2s;
        }
        .actions-row select[name="new_status"]:focus {
            border: 1.5px solid #bfa133;
            box-shadow: 0 0 0 2px rgba(212,175,55,0.13);
            outline: none;
        }
        .update-btn {
            background: linear-gradient(90deg, #d4af37 0%, #bfa13a 100%);
            color: #222;
            font-weight: 700;
            border: none;
            border-radius: 4px;
            padding: 7px 18px;
            cursor: pointer;
            transition: background 0.2s, color 0.2s, transform 0.1s, box-shadow 0.2s;
            box-shadow: 0 2px 8px rgba(212,175,55,0.10);
        }
        .update-btn:hover {
            background: linear-gradient(90deg, #e6c75a 0%, #d4af37 100%);
            color: #222;
            transform: translateY(-2px) scale(1.03);
            box-shadow: 0 4px 16px rgba(212,175,55,0.18);
        }
        .delete-btn {
            background: #e53e3e;
            color: #fff;
            font-weight: 700;
            border: none;
            border-radius: 4px;
            padding: 7px 18px;
            cursor: pointer;
            margin-left: 12px;
            transition: background 0.2s, color 0.2s, transform 0.1s, box-shadow 0.2s;
            box-shadow: 0 2px 8px rgba(229,62,62,0.10);
        }
        .delete-btn:hover {
            background: #c53030;
            color: #fff;
            transform: translateY(-2px) scale(1.03);
            box-shadow: 0 4px 16px rgba(229,62,62,0.18);
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
        @media (max-width: 900px) {
            .admin-main {
                padding: 20px 5px;
            }
            .appointments-table th, .appointments-table td {
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
                <li><a href="appointments.php" class="active">Appointments</a></li>
                <li><a href="services.php">Services</a></li>
                <li><a href="../index.php" onclick="return confirm('Are you sure you want to return to home page?');">Return to Home page</a></li>
            </ul>
        </nav>
        <main class="admin-main">
            <h2>Appointments Management</h2>
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
            
            <!-- Search Bar -->
            <div class="search-container">
                <input type="text" id="searchInput" placeholder="Search by Appointment ID..." class="search-input">
                <i class="fas fa-search search-icon"></i>
            </div>
            
            <?php if (!$error): ?>
            <table class="appointments-table" id="appointmentsTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Customer</th>
                        <th>Barber</th>
                        <th>Service</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($appointments as $appt): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($appt['BOOK_ID']); ?></td>
                        <td><?php echo htmlspecialchars($appt['C_USERNAME']); ?></td>
                        <td><?php echo htmlspecialchars($appt['barber_name']); ?></td>
                        <td><?php echo htmlspecialchars($appt['S_SERVICENAME']); ?></td>
                        <td><?php echo htmlspecialchars($appt['BOOK_DATE']); ?></td>
                        <td><?php echo htmlspecialchars(substr($appt['BOOK_TIME'],0,5)); ?></td>
                        <td><?php echo htmlspecialchars(ucfirst($appt['BOOK_STATUS'])); ?></td>
                        <td class="actions-cell">
                            <div class="actions-row">
                                <form method="POST" class="update-form" style="display:flex;align-items:center;gap:8px;">
                                    <input type="hidden" name="appointment_id" value="<?php echo $appt['BOOK_ID']; ?>">
                                    <select name="new_status">
                                        <?php
                                        $statuses = ['pending', 'confirmed', 'completed', 'cancelled'];
                                        foreach ($statuses as $status) {
                                            $selected = ($appt['BOOK_STATUS'] === $status) ? 'selected' : '';
                                            echo "<option value=\"$status\" $selected>" . ucfirst($status) . "</option>";
                                        }
                                        ?>
                                    </select>
                                    <button type="submit" name="update_status" class="update-btn">Update</button>
                                </form>
                                <form method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this appointment?');">
                                    <input type="hidden" name="appointment_id" value="<?php echo $appt['BOOK_ID']; ?>">
                                    <button type="submit" name="delete_appointment" class="delete-btn">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php endif; ?>
        </main>
    </div>
    
    <!-- Search Functionality -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const table = document.getElementById('appointmentsTable');
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

        // Clear search when clicking on search input
        searchInput.addEventListener('click', function() {
            if (this.value === 'Search by Appointment ID...') {
                this.value = '';
            }
        });
    });
    </script>
</body>
</html>