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
    $absolutePath = DIR . "/pictures/"; // C:\xampp\htdocs\CoopTech-BadonDuke-patch-1\VitalCoders\pictures\

    // Path to store in database (relative for <img src>)
    $relativePath = "pictures/"; 

    // Ensure the folder exists
    if (!is_dir($absolutePath)) {
        mkdir($absolutePath, 0777, true);
    }

    $fileExt = strtolower(pathinfo($_FILES['profile_image']['name'], PATHINFOEXTENSION));
    $fileName = uniqid("user") . "." . $fileExt;
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
<?php
include "conn.php";
include "check.php";
check_session();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'] ?? null;
    $roles = $_POST['roles'] ?? [];  // roles[] comes from the modal dropdown
    $status = $_POST['status'] ?? 0;

    if (!$user_id) {
        die("Invalid user ID.");
    }

    try {
        $conn->beginTransaction();

        // Update status
        $stmt = $conn->prepare("UPDATE users SET status = ? WHERE user_id = ?");
        $stmt->execute([$status, $user_id]);

        // Clear existing roles
        $stmt = $conn->prepare("DELETE FROM user_roles WHERE user_id = ?");
        $stmt->execute([$user_id]);

        // Insert new role(s) — if not empty
        if (!empty($roles)) {
            $stmt = $conn->prepare("INSERT INTO user_roles (user_id, role_id) VALUES (?, ?)");
            foreach ($roles as $role_id) {
                if (!empty($role_id)) { // skip empty = None (Member)
                    $stmt->execute([$user_id, $role_id]);
                }
            }
        }

        $conn->commit();
        header("Location: manageA.php?updated=1");
exit;

    } catch (PDOException $e) {
        $conn->rollBack();
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request.";
}