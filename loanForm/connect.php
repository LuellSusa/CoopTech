<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "signup");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['email'])) {
    $email = $_POST['email'];
    $code  = rand(100000, 999999); // 6-digit code

    // Save code in DB (or update if email exists)
    $stmt = $conn->prepare("INSERT INTO email_verification (email, code, verified) VALUES (?, ?, 0)
                            ON DUPLICATE KEY UPDATE code = ?, verified = 0");
    $stmt->bind_param("sss", $email, $code, $code);
    $stmt->execute();
    $stmt->close();

    // For now, just show the code (since sending email without SMTP is tricky)
    echo "✅ Your verification code is: $code";

    // TODO: Replace above echo with real email sending when SMTP is configured
}
$conn->close();
?>
