<?php
// Include database connection
require_once 'config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get and sanitize form data
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');

    // Basic validation
    if ($name && $email && $subject && $message) {
        try {
            $stmt = $pdo->prepare('INSERT INTO messages (name, email, phone, subject, message) VALUES (?, ?, ?, ?, ?)');
            $stmt->execute([$name, $email, $phone, $subject, $message]);
            // Redirect or show success
            header('Location: contact.php?success=1');
            exit();
        } catch (PDOException $e) {
            // Handle error (log or display a user-friendly message)
            header('Location: contact.php?error=1');
            exit();
        }
    } else {
        // Missing required fields
        header('Location: contact.php?error=1');
        exit();
    }
} else {
    // Not a POST request
    header('Location: contact.php');
    exit();
} 