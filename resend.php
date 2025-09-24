<?php
include "conn.php";
require 'mail_config.php';
session_start();

$cooldownMinutes = 5; // Change for testing
$email = $_SESSION['user_email'];

$query = $conn->prepare("SELECT code_sent_at FROM users WHERE email=?");
$query->bind_param("s", $email);
$query->execute();
$result = $query->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    echo json_encode(['status' => 'error', 'message' => 'User not found.']);
    exit;
}

$lastSent = strtotime($user['code_sent_at']);
$now = time();
$cooldown = $cooldownMinutes * 60;

if ($now - $lastSent < $cooldown) {
    $remaining = $cooldown - ($now - $lastSent);
    echo json_encode([
        'status' => 'error',
        'message' => "Please wait " . ceil($remaining / 60) . " more minutes before resending."
    ]);
    exit;
}

// Generate new code
$newCode = rand(100000, 999999);
$update = $conn->prepare("UPDATE users SET verification_code=?, code_sent_at=NOW() WHERE email=?");
$update->bind_param("ss", $newCode, $email);
$update->execute();

// Send email
$result = sendConfirmationMail($email, $newCode);

if ($result === true) {
    echo json_encode(['status' => 'success', 'message' => 'Verification code resent!']);
} else {
    echo json_encode(['status' => 'error', 'message' => $result]);
}
?>
