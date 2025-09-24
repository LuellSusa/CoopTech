<?php
session_start();
include 'conn.php';

$logfile = __DIR__ . '/profile_update_debug.log';
function dbg($msg) {
    global $logfile;
    file_put_contents($logfile, '['.date('Y-m-d H:i:s').'] '.$msg.PHP_EOL, FILE_APPEND);
}

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = (int) $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: profile.php");
    exit;
}

try {
    dbg("=== Update attempt start ===");
    dbg("POST: " . print_r($_POST, true));
    dbg("FILES: " . print_r($_FILES, true));

    // Fetch current DB row
    $stmt = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $current = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$current) {
        dbg("User not found (user_id={$user_id})");
        header("Location: profile.php?update=notfound");
        exit;
    }
    dbg("CURRENT DB ROW: " . print_r($current, true));

    // Use posted value if provided (non-empty), otherwise use current DB value
    $name    = isset($_POST['name']) ? trim($_POST['name']) : $current['name'];
    $address = isset($_POST['address']) ? trim($_POST['address']) : $current['address'];
    $contact = isset($_POST['contact']) ? trim($_POST['contact']) : $current['contact'];
    $dob     = isset($_POST['dob']) ? trim($_POST['dob']) : $current['dob'];
    $email   = isset($_POST['email']) ? trim($_POST['email']) : $current['email'];

    // If user cleared a field intentionally and you want to allow clearing,
    // remove the following "empty => keep old" behavior. Right now, empty = keep old.
    if ($name === '')    $name = $current['name'];
    if ($address === '') $address = $current['address'];
    if ($contact === '') $contact = $current['contact'];
    if ($dob === '')     $dob = $current['dob'];
    if ($email === '')   $email = $current['email'];

    // Validate email if present
    if ($email !== null && $email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        dbg("Invalid email provided: $email");
        header("Location: profile.php?update=invalid_email");
        exit;
    }

    // Handle profile image upload (keep current if none uploaded)
    $profilePath = $current['profile_image'];
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
        $allowed = ['jpg','jpeg','png'];
        $ext = strtolower(pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION));
        if (in_array($ext, $allowed)) {
            $uploadDir = __DIR__ . '/pictures/';
            if (!is_dir($uploadDir)) @mkdir($uploadDir, 0777, true);
            $fileName = uniqid('user_') . '.' . $ext;
            $absFile  = $uploadDir . $fileName;
            if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $absFile)) {
                $profilePath = 'pictures/' . $fileName;
                dbg("Profile image saved -> $profilePath");
            } else {
                dbg("move_uploaded_file failed for tmp: " . $_FILES['profile_image']['tmp_name']);
            }
        } else {
            dbg("Rejected image ext: $ext");
        }
    } else {
        dbg("No new profile image uploaded or upload error code: " . ($_FILES['profile_image']['error'] ?? 'no-file'));
    }

    // Final update
    $sql = "UPDATE users SET name = ?, address = ?, contact = ?, dob = ?, email = ?, profile_image = ? WHERE user_id = ?";
    $stmt2 = $conn->prepare($sql);
    $stmt2->execute([$name, $address, $contact, ($dob === '' ? null : $dob), $email, $profilePath, $user_id]);

    dbg("UPDATE executed. Params: " . json_encode([$name, $address, $contact, $dob, $email, $profilePath, $user_id]));
    dbg("=== Update attempt end ===\n");

    header("Location: profile.php?update=success");
    exit;

} catch (Exception $e) {
    dbg("Exception: " . $e->getMessage());
    header("Location: profile.php?update=error");
    exit;
}
