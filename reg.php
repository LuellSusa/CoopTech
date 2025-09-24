<?php
session_start();
include "conn.php";
require 'mail_config.php'; // Make sure PHPMailer is correctly set up

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email    = trim($_POST['email']);
    $password = trim($_POST['password']);



    if (empty($name) || empty($username) || empty($email) || empty($contact) || empty($password)) {
        echo "Please fill in all fields.";
        exit;
    }

    $password_hash = password_hash($password, PASSWORD_BCRYPT);
    $verification_code = rand(100000, 999999);

    try {
        $stmt = $conn->prepare("INSERT INTO users (name, username, email, contact, password_hash, created_at, verification_code, is_verified, code_sent_at)
                                VALUES (?, ?, ?, ?, ?, NOW(), ?, 0, NOW())");
        $stmt->execute([$name, $username, $email, $contact, $password_hash, $verification_code]);

        $result = sendConfirmationMail($email, $verification_code);

        if ($result === true) {
            $_SESSION['user_email'] = $email;
            header("Location: verify.php");
            exit;
        } else {
            echo "Registration successful, but failed to send email: " . $result;
        }
    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
    }
}
