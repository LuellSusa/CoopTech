<?php
$memberName = "Member"; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CoopTech Dashboard</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="MDashstyle.css">
</head>
<body>

  <!-- Topbar -->
  <div class="topbar d-flex justify-content-between align-items-center">
    <span>Welcome, <?php echo $memberName; ?>!</span>
    <div class="icons d-flex">
      <a href="message.php" title="Messages" class="ms-3">
        <img src="https://img.icons8.com/ios-filled/50/ffffff/new-post.png" alt="Messages">
      </a>
      <a href="notifications.php" title="Notifications" class="ms-3">
        <img src="https://img.icons8.com/ios-filled/50/ffffff/appointment-reminders.png" alt="Notifications">
      </a>
    </div>
  </div>

  <div class="d-flex">
    <!-- Sidebar -->
    <div class="sidebar d-flex flex-column p-2">
      <a href="" class="mb-2">Dashboard</a>
      <a href="#" class="mb-2">View Loan</a>
      <a href="#" class="mb-2">Loan History</a>
      <a href="#" class="mb-2">Message(s)</a>
      <a href="#" class="mb-2">Transactions</a>
    </div>

    <!-- Main Content -->
    <div class="content flex-grow-1 p-3">
      <div class="row g-3">
        <!-- Card 1 -->
        <div class="col-md-4">
          <div class="card h-100 text-center p-3">
            <img src="https://img.icons8.com/fluency/96/money-bag.png" alt="Loan" class="mx-auto">
            <p class="mt-2">Experience instant loan approval with CoopTech!</p>
            <button id="applyBtn" class="btn btn-light btn-sm mt-2">Apply now</button>
          </div>
        </div>

        <!-- Card 2 -->
        <div class="col-md-4">
          <div class="card h-100 text-center p-3">
            <img src="https://img.icons8.com/color/96/loan.png" alt="Loan History" class="mx-auto">
            <p class="mt-2">View loan history</p>
            <a href="#" class="btn btn-light btn-sm mt-2">View History</a>
          </div>
        </div>

        <!-- Card 3 -->
        <div class="col-md-4">
          <div class="card h-100 text-center p-3">
            <img src="https://img.icons8.com/color/96/training.png" alt="Learn" class="mx-auto">
            <p class="mt-2">Click here to learn how to use the app!</p>
            <a href="#" class="btn btn-light btn-sm mt-2">Learn to loan</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="MDash.js"></script>
</body>
</html>
