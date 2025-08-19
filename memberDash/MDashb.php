<?php
session_start();

// Example: kung wala pa naka-login, default nga pangalan
// Sa actual login system, dapat ni gi-set sa login script
// $_SESSION['username'] = 'USERNAME';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CoopTech Dashboard</title>
  <link rel="stylesheet" href="MDashstyle.css">
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>
<body>

  <!-- Topbar -->
  <div class="topbar d-flex justify-content-between align-items-center px-3 py-2" style="background:#0d5f66; color:white;">
    <div class="d-flex align-items-center gap-3">
      <!-- Profile Dropdown -->
      <div class="dropdown">
        <img src="https://img.icons8.com/ios-filled/50/ffffff/user-male-circle.png" 
             alt="Profile" class="rounded-circle dropdown-toggle" 
             id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" 
             width="40" height="40" style="cursor:pointer;">
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
          <li><a class="dropdown-item" href="#"><i class="bi bi-person-circle me-2"></i> Profile</a></li>
          <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i> Settings</a></li>
          <li><hr class="dropdown-divider"></li>
          <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-box-arrow-right me-2"></i> Log Out</a></li>
        </ul>
      </div>

      <!-- Welcome text with dynamic username -->
      <span class="fw-bold">Welcome, <?php echo isset($_SESSION['username']) ? $_SESSION['username'] : 'Member'; ?>!</span>
    </div>

    <!-- Right side icons -->
    <div class="icons d-flex gap-3">
      <a href="" title="Email">
        <img src="https://img.icons8.com/ios-filled/50/ffffff/new-post.png" alt="Email" width="28" style="cursor:pointer;">
      </a>
      <a href="notif.php" title="Notifications">
        <img src="https://img.icons8.com/ios-filled/50/ffffff/appointment-reminders.png" alt="Notifications" width="28" style="cursor:pointer;">
      </a>
    </div>
  </div>

  <!-- Sidebar -->
  <div class="sidebar">
    <a href="MDashb.php">Dashboard</a>
    <a href="#">View Loan</a>
    <a href="message.php">Message(s)</a>
    <a href="#">Transactions</a>
  </div>

  <!-- Main Content -->
  <div class="content">
    <div class="cards">
      <div class="card">
        <img src="https://img.icons8.com/fluency/96/money-bag.png" alt="Loan">
        <p>Experience instant loan approval with CoopTech!</p>
        <button id="applyBtn">Apply now</button>
      </div>

      <div class="card">
        <img src="https://img.icons8.com/color/96/loan.png" alt="Loan History">
        <p>View loan history</p>
        <a href="#">View History</a>
      </div>

      <div class="card">
        <img src="https://img.icons8.com/color/96/training.png" alt="Learn">
        <p>Click here to learn how to use the app!</p>
        <a href="#">Learn to loan</a>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="MDash.js"></script>
</body>
</html>
