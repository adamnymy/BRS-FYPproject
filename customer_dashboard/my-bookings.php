<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

require_once '../config/db.php';

$user_id = $_SESSION['user_id'];
$error = '';

// Handle booking cancellation
if (isset($_POST['cancel_booking']) && isset($_POST['booking_id'])) {
    $booking_id = $_POST['booking_id'];
    
    // Verify the booking belongs to this user
    try {
        $check_stmt = $pdo->prepare("SELECT BOOK_ID FROM BOOKING WHERE BOOK_ID = ? AND C_ID = ?");
        $check_stmt->execute([$booking_id, $user_id]);
        
        if ($check_stmt->fetch()) {
            // Update booking status to cancelled
            $cancel_stmt = $pdo->prepare("UPDATE BOOKING SET BOOK_STATUS = 'cancelled' WHERE BOOK_ID = ?");
            $cancel_stmt->execute([$booking_id]);
            
            // Redirect to refresh the page
            header("Location: my-bookings.php?cancelled=1");
            exit();
        } else {
            $error = "Invalid booking or you don't have permission to cancel this booking.";
        }
    } catch (PDOException $e) {
        $error = "Error cancelling booking: " . $e->getMessage();
    }
}

// Handle booking removal
if (isset($_POST['remove_booking']) && isset($_POST['booking_id'])) {
    $booking_id = $_POST['booking_id'];
    
    // Verify the booking belongs to this user and is cancelled
    try {
        $check_stmt = $pdo->prepare("SELECT BOOK_ID FROM BOOKING WHERE BOOK_ID = ? AND C_ID = ? AND BOOK_STATUS = 'cancelled'");
        $check_stmt->execute([$booking_id, $user_id]);
        
        if ($check_stmt->fetch()) {
            // Delete the cancelled booking
            $remove_stmt = $pdo->prepare("DELETE FROM BOOKING WHERE BOOK_ID = ?");
            $remove_stmt->execute([$booking_id]);
            
            // Redirect to refresh the page
            header("Location: my-bookings.php?removed=1");
            exit();
        } else {
            $error = "Invalid booking or you don't have permission to remove this booking.";
        }
    } catch (PDOException $e) {
        $error = "Error removing booking: " . $e->getMessage();
    }
}

// Fetch all bookings for this user
try {
    $sql = "SELECT b.BOOK_ID, br.B_NAME AS barber_name, s.S_SERVICENAME, b.BOOK_DATE, b.BOOK_TIME, b.BOOK_STATUS
            FROM BOOKING b
            JOIN BARBER br ON b.B_ID = br.B_ID
            JOIN SERVICE s ON b.S_ID = s.S_ID
            WHERE b.C_ID = ?
            ORDER BY b.BOOK_DATE DESC, b.BOOK_TIME DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$user_id]);
    $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error = "Error fetching bookings: " . $e->getMessage();
}

// Fetch all services for display
try {
    $stmt = $pdo->query("SELECT S_SERVICENAME, S_PRICE FROM SERVICE WHERE S_STATUS = 'active'");
    $all_services = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $all_services = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Bookings</title>
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
        .bookings-glass-bg {
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: url('../images/bookbg.webp') center/cover no-repeat;
            filter: blur(24px) brightness(0.7);
            z-index: 0;
        }
        .bookings-main {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            z-index: 1;
        }
        .bookings-glass-card {
            background: rgba(255,255,255,0.18);
            box-shadow: 0 8px 32px 0 rgba(31,38,135,0.18);
            backdrop-filter: blur(16px) saturate(180%);
            -webkit-backdrop-filter: blur(16px) saturate(180%);
            border-radius: 28px;
            border: 1.5px solid rgba(255,255,255,0.25);
            padding: 48px 38px 38px 38px;
            max-width: 800px;
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
        }
        .bookings-avatar {
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
        .bookings-glass-heading {
            font-size: 1.7em;
            font-weight: 700;
            color: #181818;
            margin-bottom: 28px;
            letter-spacing: 0.5px;
            text-align: center;
        }
        .bookings-table-wrapper {
            width: 100%;
            background: rgba(255,255,255,0.55);
            border-radius: 12px;
            box-shadow: 0 1px 6px rgba(212,175,55,0.04);
            border: 1.5px solid #f3e7c1;
            padding: 20px;
            margin-top: 0;
        }
        .bookings-table {
            width: 100%;
            border-collapse: collapse;
            background: transparent;
            border-radius: 8px;
            overflow: hidden;
        }
        .bookings-table th, .bookings-table td {
            padding: 14px 12px;
            text-align: left;
            border-bottom: 1px solid rgba(255,255,255,0.3);
            color: #181818;
        }
        .bookings-table th {
            background-color: rgba(212,175,55,0.15);
            color:rgb(41, 39, 35);
            font-weight: 600;
        }
        .bookings-table tr:hover {
            background-color: rgba(255,255,255,0.3);
        }
        .status {
            font-weight: bold;
            text-transform: capitalize;
        }
        .status.pending { color: #f6e05e; }
        .status.confirmed { color: #38a169; }
        .status.completed { color: #3182ce; }
        .status.cancelled { color: #e53e3e; }
        .cancel-btn {
            background: #e53e3e;
            color: #fff;
            border: none;
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 0.9em;
            cursor: pointer;
            transition: background 0.2s, transform 0.2s;
            display: flex;
            align-items: center;
            gap: 4px;
        }
        .cancel-btn:hover {
            background: #c53030;
            transform: scale(1.05);
        }
        .cancel-btn i {
            font-size: 0.8em;
        }
        .remove-btn {
            background: #805ad5;
            color: #fff;
            border: none;
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 0.9em;
            cursor: pointer;
            transition: background 0.2s, transform 0.2s;
            display: flex;
            align-items: center;
            gap: 4px;
        }
        .remove-btn:hover {
            background: #6b46c1;
            transform: scale(1.05);
        }
        .remove-btn i {
            font-size: 0.8em;
        }
        .alert-danger {
            background: rgba(248,215,218,0.9);
            color: #721c24;
            border: 1px solid #f5c6cb;
            padding: 16px;
            border-radius: 12px;
            margin-bottom: 25px;
            font-weight: 500;
            width: 100%;
            text-align: center;
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
            .bookings-glass-card {
                padding: 28px 6px 24px 6px;
                max-width: 98vw;
            }
            .bookings-avatar {
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
</head>
<body>

    <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
        <div id="success-popup" style="
            position: fixed;
            top: 30px;
            left: 50%;
            transform: translateX(-50%);
            background: #38a169;
            color: #fff;
            padding: 18px 32px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.18);
            font-size: 18px;
            z-index: 9999;
            display: block;
            text-align: center;
            ">
            Booked successfully!
        </div>
        <script>
            setTimeout(function() {
                var popup = document.getElementById('success-popup');
                if (popup) popup.style.display = 'none';
            }, 2500);
        </script>
    <?php endif; ?>
    
    <?php if (isset($_GET['cancelled']) && $_GET['cancelled'] == 1): ?>
        <div id="cancelled-popup" style="
            position: fixed;
            top: 30px;
            left: 50%;
            transform: translateX(-50%);
            background: #e53e3e;
            color: #fff;
            padding: 18px 32px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.18);
            font-size: 18px;
            z-index: 9999;
            display: block;
            text-align: center;
            ">
            Booking cancelled successfully!
        </div>
        <script>
            setTimeout(function() {
                var popup = document.getElementById('cancelled-popup');
                if (popup) popup.style.display = 'none';
            }, 2500);
        </script>
    <?php endif; ?>
    
    <?php if (isset($_GET['removed']) && $_GET['removed'] == 1): ?>
        <div id="removed-popup" style="
            position: fixed;
            top: 30px;
            left: 50%;
            transform: translateX(-50%);
            background: #805ad5;
            color: #fff;
            padding: 18px 32px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.18);
            font-size: 18px;
            z-index: 9999;
            display: block;
            text-align: center;
            ">
            Booking removed successfully!
        </div>
        <script>
            setTimeout(function() {
                var popup = document.getElementById('removed-popup');
                if (popup) popup.style.display = 'none';
            }, 2500);
        </script>
    <?php endif; ?>

    <div class="bookings-glass-bg"></div>
    <div class="bookings-main">
        <div class="bookings-glass-card">
            <div class="bookings-avatar">
                <i class="fas fa-calendar-alt"></i>
            </div>
            <h2 class="bookings-glass-heading">My Bookings</h2>
            <!-- All Available Services Section -->
            <div class="all-services-section" style="width:100%;margin-bottom:28px;">
                <h3 style="color:#d4af37;text-align:left;margin-bottom:12px;">All Available Services</h3>
                <div style="display:flex;flex-wrap:wrap;gap:16px;">
                    <?php foreach ($all_services as $service): ?>
                        <div style="background:rgba(255,255,255,0.7);border-radius:8px;padding:12px 18px;min-width:180px;box-shadow:0 1px 4px rgba(212,175,55,0.08);color:#181818;">
                            <strong><?php echo htmlspecialchars($service['S_SERVICENAME']); ?></strong><br>
                            <span>RM<?php echo htmlspecialchars($service['S_PRICE']); ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <!-- End All Available Services Section -->
            <?php if ($error): ?>
                <div class="alert alert-danger"> <?php echo htmlspecialchars($error); ?> </div>
            <?php endif; ?>
            <?php if (empty($bookings)): ?>
                <div style="color:#aaa; text-align:center;">You have no bookings yet.</div>
            <?php else: ?>
            <div class="bookings-table-wrapper">
                <table class="bookings-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Barber</th>
                            <th>Service</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($bookings as $booking): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($booking['BOOK_ID']); ?></td>
                            <td><?php echo htmlspecialchars($booking['barber_name']); ?></td>
                            <td><?php echo htmlspecialchars($booking['S_SERVICENAME']); ?></td>
                            <td><?php echo htmlspecialchars($booking['BOOK_DATE']); ?></td>
                            <td><?php echo htmlspecialchars(substr($booking['BOOK_TIME'],0,5)); ?></td>
                            <td class="status <?php echo htmlspecialchars($booking['BOOK_STATUS']); ?>">
                                <?php echo htmlspecialchars($booking['BOOK_STATUS']); ?>
                            </td>
                            <td>
                                <?php if ($booking['BOOK_STATUS'] !== 'cancelled' && $booking['BOOK_STATUS'] !== 'completed'): ?>
                                    <button onclick="confirmCancel(<?php echo $booking['BOOK_ID']; ?>)" class="cancel-btn">
                                        <i class="fas fa-times"></i> Cancel
                                    </button>
                                <?php elseif ($booking['BOOK_STATUS'] === 'cancelled'): ?>
                                    <button onclick="confirmRemove(<?php echo $booking['BOOK_ID']; ?>)" class="remove-btn">
                                        <i class="fas fa-trash"></i> Remove
                                    </button>
                                <?php else: ?>
                                    <span style="color: #999; font-style: italic;">-</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <a href="c_dashboard.php" class="back-dashboard-btn" title="Back to Dashboard">
        <i class="fas fa-arrow-left"></i> Back to Dashboard
    </a>
    
    <!-- Hidden form for cancellation -->
    <form id="cancelForm" method="POST" style="display: none;">
        <input type="hidden" name="cancel_booking" value="1">
        <input type="hidden" name="booking_id" id="bookingIdToCancel">
    </form>
    
    <!-- Hidden form for removal -->
    <form id="removeForm" method="POST" style="display: none;">
        <input type="hidden" name="remove_booking" value="1">
        <input type="hidden" name="booking_id" id="bookingIdToRemove">
    </form>
    
    <script>
        function confirmCancel(bookingId) {
            if (confirm('Are you sure you want to cancel this booking?')) {
                document.getElementById('bookingIdToCancel').value = bookingId;
                document.getElementById('cancelForm').submit();
            }
        }
        
        function confirmRemove(bookingId) {
            if (confirm('Are you sure you want to remove this cancelled booking? This action cannot be undone.')) {
                document.getElementById('bookingIdToRemove').value = bookingId;
                document.getElementById('removeForm').submit();
            }
        }
    </script>
</body>
</html>
