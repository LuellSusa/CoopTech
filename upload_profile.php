<?php
session_start();
include 'conn.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_image'])) {
    // Absolute path for saving files
    $absolutePath = __DIR__ . "/pictures/"; // C:\xampp\htdocs\CoopTech-BadonDuke-patch-1\VitalCoders\pictures\
    
    // Path to store in database (relative for <img src>)
    $relativePath = "pictures/"; 

    // Ensure the folder exists
    if (!is_dir($absolutePath)) {
        mkdir($absolutePath, 0777, true);
    }

    $fileExt = strtolower(pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION));
    $fileName = uniqid("user_") . "." . $fileExt;
    $absoluteFilePath = $absolutePath . $fileName;
    $dbFilePath = $relativePath . $fileName; // this is what we store in DB

    $allowedTypes = ['jpg', 'jpeg', 'png'];
    if (!in_array($fileExt, $allowedTypes)) {
        die("Only JPG and PNG files are allowed.");
    }

    // Try to move the file
    if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $absoluteFilePath)) {
        // Save relative path into DB
        $stmt = $conn->prepare("UPDATE users SET profile_image = ? WHERE user_id = ?");
        $stmt->execute([$dbFilePath, $user_id]);

        header("Location: index.php?upload=success");
        exit;
    } else {
        echo "Failed to upload image. Check folder permissions: $absolutePath";
    }
}
?>
