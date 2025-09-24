<?php
// check.php

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (!function_exists('check_session')) {
    function check_session() {
        if (!isset($_SESSION['user_id'])) {
            // User is not logged in → redirect to login
            header("Location: login.php");
            exit;
        }
    }
}
