<?php
session_start();
include "conn.php";
include "check.php";
check_session();

if (isset($_GET['option_id'])) {
    $option_id = $_GET['option_id'];

    $stmt = $conn->prepare("DELETE FROM loan_options WHERE option_id = ?");
    $stmt->execute([$option_id]);
}

header("Location: manageL.php");
exit;
