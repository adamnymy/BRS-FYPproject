<?php
session_start();
require_once 'config/db.php';

if (!isset($_SESSION['user_id']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: login.php");
    exit();
}

try {
    $user_id = $_SESSION['user_id'];
    $barber_id = $_POST['barber_id'];
    $service_id = $_POST['service_id'];
    $date = $_POST['date'];
    $time = $_POST['time_slot'];
    
    // Check if timeslot is available
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM BOOKING WHERE BOOK_DATE = ? AND BOOK_TIME = ? AND B_ID = ? AND BOOK_STATUS != 'cancelled'");
    $stmt->execute([$date, $time, $barber_id]);
    $exists = $stmt->fetchColumn();

    if ($exists > 0) {
        $_SESSION['error'] = "This time slot is already booked. Please choose another time.";
        header("Location: booking.php?error=slotfull");
        exit();
    }

    // Insert booking
    $stmt = $pdo->prepare("INSERT INTO BOOKING (C_ID, B_ID, S_ID, BOOK_DATE, BOOK_TIME, BOOK_STATUS, BOOK_CREATED_AT) VALUES (?, ?, ?, ?, ?, 'pending', NOW())");
    $stmt->execute([$user_id, $barber_id, $service_id, $date, $time]);

    // After booking is successfully inserted
    $booking_id = $pdo->lastInsertId();

    $_SESSION['success'] = "Appointment booked successfully!";
    header("Location: customer_dashboard/my-bookings.php?success=1");
    exit();

} catch (PDOException $e) {
    $_SESSION['error'] = "An error occurred while booking your appointment.";
    header("Location: booking.php");
    exit();
}