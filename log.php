<?php
session_start();
include 'conn.php'; // Ensure this defines $conn as a PDO connection

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($email) || empty($password)) {
        echo "Please fill in all fields.";
        exit;
    }

    try {
        // Fetch user including verification status
        $stmt = $conn->prepare("SELECT user_id, email, password_hash, is_verified FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            if (password_verify($password, $user['password_hash'])) {
                if ($user['is_verified'] == 1) {
                    $_SESSION['user_id'] = $user['user_id'];
                    $_SESSION['email'] = $user['email'];

                    header("Location: index.php");
                    exit;
                } else {
                    echo "Your account is not verified. Please check your email for the code.";
                }
            } else {
                echo "Incorrect password.";
            }
        } else {
            echo "No account found with that email.";
        }
    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
    }
}
?>
