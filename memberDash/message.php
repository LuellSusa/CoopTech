<?php
session_start();
$memberName = isset($_SESSION['username']) ? $_SESSION['username'] : "Member";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Messages - CoopTech</title>
  <link rel="stylesheet" href="MDashstyle.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>

  <!-- Topbar -->
  <div class="d-flex justify-content-between align-items-center p-2 topbar">

    <!-- Left side: Profile + Welcome -->
    <div class="d-flex align-items-center gap-2">

      <!-- Profile Dropdown -->
      <div class="dropdown">
        <a href="#" class="d-flex align-items-center text-decoration-none" 
           id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
          <img src="https://img.icons8.com/color/48/000000/user-male-circle--v1.png" 
               alt="Profile" class="rounded-circle me-2" width="35" height="35">
        </a>
        <ul class="dropdown-menu">
          <li><a class="dropdown-item" href="#"><i class="bi bi-person"></i> My Account</a></li>
          <li><a class="dropdown-item" href="#"><i class="bi bi-gear"></i> Settings</a></li>
          <li><hr class="dropdown-divider"></li>
          <li><a class="dropdown-item text-danger" href="?logout=1" id="logoutLink"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
        </ul>
      </div>

      <!-- Welcome Text -->
      <span>Welcome, <?php echo $memberName; ?>!</span>
    </div>

    <!-- Right side: Icons -->
    <div class="d-flex align-items-center gap-3">
      <img src="https://img.icons8.com/ios-filled/30/ffffff/new-post.png" alt="Messages">
      <img src="https://img.icons8.com/ios-filled/30/ffffff/appointment-reminders.png" alt="Notifications">
    </div>
  </div>

  <!-- Sidebar -->
  <div class="sidebar p-3">
    <a href="MDashb.php">Dashboard</a>
    <a href="#">View Loan</a>
    <a href="message.php">Message(s)</a>
    <a href="#">Transactions</a>
  </div>

  <!-- Content -->
  <div class="content">
    <h2>📩 Your Messages</h2>
    <table class="msg-table">
      <thead>
        <tr>
          <th>From</th>
          <th>Message</th>
          <th>Date</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Admin</td>
          <td>Welcome to CoopTech! 🎉</td>
          <td>2025-08-19</td>
        </tr>
        <tr>
          <td>Loan Officer</td>
          <td>Your loan request is under review.</td>
          <td>2025-08-18</td>
        </tr>
      </tbody>
    </table>

    <!-- Back Button -->
    <div class="text-end mt-4">
      <a href="MDashb.php" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Back to Dashboard
      </a>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
