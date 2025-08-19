<?php
// notification.php
session_start();
// Example: Check if user is logged in (optional)
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Notifications</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
  <style>
    body {
      background-color: #f8f9fa;
    }
    .notification-card {
      border-radius: 12px;
      margin-bottom: 15px;
      box-shadow: 0px 2px 6px rgba(0,0,0,0.1);
    }
    .notification-card.unread {
      background-color: #e9f7ef;
    }
  </style>
</head>
<body>
  
  <!-- Navbar -->
  <nav class="navbar navbar-dark" style="background-color:#0d5f66;">
    <div class="container-fluid">
      <a class="navbar-brand fw-bold" href="dashboard.php">🏦 CoopTech</a>
      <a href="logout.php" class="btn btn-danger btn-sm fw-bold">Logout</a>
    </div>
  </nav>

  <div class="container my-4">
    <h3 class="mb-4"><i class="bi bi-bell"></i> Notifications</h3>

    <!-- Sample Notifications -->
    <div class="card notification-card unread p-3">
      <div class="d-flex justify-content-between">
        <div>
          <strong>Loan Approved</strong>
          <p class="mb-0 text-muted">Your loan request has been approved.</p>
        </div>
        <small class="text-muted">2 mins ago</small>
      </div>
    </div>

    <div class="card notification-card p-3">
      <div class="d-flex justify-content-between">
        <div>
          <strong>Payment Reminder</strong>
          <p class="mb-0 text-muted">Your monthly payment is due on Aug 25, 2025.</p>
        </div>
        <small class="text-muted">1 hour ago</small>
      </div>
    </div>

    <div class="card notification-card p-3">
      <div class="d-flex justify-content-between">
        <div>
          <strong>New Message</strong>
          <p class="mb-0 text-muted">You received a new message from the admin.</p>
        </div>
        <small class="text-muted">Yesterday</small>
      </div>
    </div>

    <!-- No Notifications -->
    <!--
    <div class="alert alert-info">No new notifications.</div>
    -->

  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
