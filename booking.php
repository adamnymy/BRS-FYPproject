<?php
session_start();
require_once 'config/db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch barbers from database
$stmt = $pdo->query("SELECT B_ID, B_NAME FROM BARBER WHERE B_STATUS = 'active'");
$barbers = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch services from database
$stmt = $pdo->query("SELECT S_ID, S_SERVICENAME, S_PRICE FROM SERVICE WHERE S_STATUS = 'active'");
$services = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Appointment - M&P Barbershop</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="booking-container">
        <h1>BOOK AN APPOINTMENT</h1>
        <form method="POST" action="/website/process_booking.php" class="booking-form">
            <div class="form-group">
                <label><i class="fa-solid fa-user-scissors"></i> CHOOSE YOUR BARBER</label>
                <select name="barber_id" required>
                    <option value="">Select a barber</option>
                    <?php foreach ($barbers as $barber): ?>
                        <option value="<?php echo htmlspecialchars($barber['B_ID']); ?>">
                            <?php echo htmlspecialchars($barber['B_NAME']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label><i class="fa-solid fa-scissors"></i> SERVICE</label>
                <select name="service_id" required>
                    <option value="">Select a service</option>
                    <?php foreach ($services as $service): ?>
                        <option value="<?php echo htmlspecialchars($service['S_ID']); ?>">
                            <?php echo htmlspecialchars($service['S_SERVICENAME']); ?> - 
                            RM<?php echo htmlspecialchars($service['S_PRICE']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label><i class="fa-solid fa-calendar-days"></i> DATE</label>
                <input type="date" name="date" required min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>">
            </div>
            <div class="form-group">
                <label><i class="fa-solid fa-clock"></i> TIME</label>
                <select name="time_slot" required>
                    <option value="">Select time</option>
                    <option value="10:00">10:00 AM</option>
                    <option value="11:00">11:00 AM</option>
                    <option value="12:00">12:00 PM</option>
                    <option value="14:00">2:00 PM</option>
                    <option value="15:00">3:00 PM</option>
                    <option value="16:00">4:00 PM</option>
                    <option value="17:00">5:00 PM</option>
                </select>
            </div>
            <button type="submit" class="btn-book"><i class="fa-solid fa-calendar-check"></i> Book Appointment</button>
        </form>
    </div>
    <!-- Toast Notification -->
    <div id="toast-notification" style="display:none; position:fixed; top:30px; right:30px; z-index:9999; min-width:220px; padding:16px 28px; border-radius:8px; font-size:1.1em; box-shadow:0 2px 8px rgba(0,0,0,0.18);"></div>
    <script>
    function showNotification(message, type = 'error') {
        const toast = document.getElementById('toast-notification');
        toast.innerText = message;
        toast.style.display = 'block';
        toast.style.background = type === 'success' ? '#38a169' : (type === 'error' ? '#e53e3e' : '#3182ce');
        toast.style.color = '#fff';
        setTimeout(() => { toast.style.display = 'none'; }, 2500);
    }
    window.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('error') === 'slotfull') {
            showNotification('Slot full, please choose another time.', 'error');
        }
    });
    </script>
    <!-- Loading Overlay -->
    <div id="loading-overlay" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(0,0,0,0.5); z-index:9999; align-items:center; justify-content:center;">
        <div class="spinner"></div>
    </div>
    <style>
        body {
            font-family: 'Inter', Arial, sans-serif;
            position: relative;
            background-color: #000;
        }
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: linear-gradient(rgba(24,24,24,0.7), rgba(24,24,24,0.7)), url('images/bookbg.webp');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            filter: blur(10px) brightness(0.7);
            z-index: -1;
        }
        .booking-container {
            position: relative;
            max-width: 900px;
            margin: 60px auto;
            padding: 0 10px;
            z-index: 1;
        }
        .booking-container h1 {
            color: #d4af37;
            text-align: center;
            font-size: 2.1rem;
            font-weight: 600;
            letter-spacing: 1px;
            margin-bottom: 32px;
            text-shadow: 2px 2px 8px rgba(0,0,0,0.25);
        }
        .booking-form {
            display: flex;
            flex-direction: column;
            gap: 22px;
            background: rgba(255,255,255,0.18);
            padding: 56px 80px 48px 80px;
            border-radius: 18px;
            box-shadow: 0 8px 32px 0 rgba(0,0,0,0.25);
            backdrop-filter: blur(12px);
            border: 1.5px solid rgba(212,175,55,0.18);
        }
        .form-group {
            display: flex;
            flex-direction: column;
            gap: 7px;
        }
        .form-group label {
            font-weight: 600;
            color: #fff;
            letter-spacing: 0.5px;
            margin-bottom: 2px;
            display: flex;
            align-items: center;
            gap: 7px;
            font-size: 1.05rem;
        }
        .form-group select,
        .form-group input {
            color: #fff;
            background-color: rgba(24,24,24,0.7);
            border: 1.5px solid #d4af37;
            padding: 13px 14px;
            border-radius: 7px;
            font-size: 1rem;
            transition: border 0.2s, box-shadow 0.2s;
            outline: none;
        }
        .form-group select:focus,
        .form-group input:focus {
            border: 1.5px solid #bfa13a;
            box-shadow: 0 0 0 2px rgba(212,175,55,0.13);
            color: #fff;
        }
        .btn-book {
            background: linear-gradient(90deg, #d4af37 0%, #bfa13a 100%);
            color: #222;
            padding: 14px;
            border: none;
            border-radius: 7px;
            cursor: pointer;
            font-size: 1.08rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            transition: background 0.2s, transform 0.1s, box-shadow 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            box-shadow: 0 2px 8px rgba(212,175,55,0.10);
        }
        .btn-book:hover {
            background: linear-gradient(90deg, #e6c75a 0%, #d4af37 100%);
            color: #222;
            transform: translateY(-2px) scale(1.03);
            box-shadow: 0 4px 16px rgba(212,175,55,0.18);
        }
        @media (max-width: 1200px) {
            .booking-container {
                max-width: 98vw;
                margin: 24px auto;
                padding: 0 2vw;
            }
            .booking-form {
                padding: 32px 4vw 32px 4vw;
            }
        }
        .spinner {
            border: 8px solid #f3f3f3;
            border-top: 8px solid #d4af37;
            border-radius: 50%;
            width: 64px;
            height: 64px;
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg);}
            100% { transform: rotate(360deg);}
        }
    </style>
    <script>
    document.querySelector('.booking-form').addEventListener('submit', function(e) {
        e.preventDefault();
        document.getElementById('loading-overlay').style.display = 'flex';
        setTimeout(() => {
            e.target.submit();
        }, 2000);
    });
    </script>
</body>
</html>