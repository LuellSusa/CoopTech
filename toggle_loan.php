<?php
session_start();
include "conn.php";
include "check.php";
check_session();

if (isset($_GET['option_id'])) {
    $option_id = (int) $_GET['option_id'];

    // Get current status
    $stmt = $conn->prepare("SELECT is_active FROM loan_options WHERE option_id = ?");
    $stmt->execute([$option_id]);
    $loan = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($loan) {
        $new_status = $loan['is_active'] ? 0 : 1; // flip 1→0 or 0→1

        $update = $conn->prepare("UPDATE loan_options SET is_active = ? WHERE option_id = ?");
        $update->execute([$new_status, $option_id]);
    }
}

header("Location: manageL.php");
exit;
