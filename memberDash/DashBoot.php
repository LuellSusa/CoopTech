<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Member Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #0d5f66;
    }
    .sidebar {
      min-height: 100vh;
      background-color: #c6e0dc;
      padding-top: 20px;
    }
    .sidebar a {
      width: 100%;
      margin: 10px 0;
    }
    .card {
      border-radius: 15px;
      box-shadow: 0px 2px 8px rgba(0,0,0,0.1);
      height: 100%; /* equal height */
    }
    .profile-dropdown {
      cursor: pointer;
    }
    /* Add black line below navbar */
    .navbar {
      border-bottom: 2px solid black;
    }
  </style>
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #0d5f66;">
    <div class="container-fluid d-flex justify-content-between">
      
      <!-- Profile + Welcome -->
      <div class="d-flex align-items-center">
        <!-- Profile first -->
        <div class="dropdown me-2">
          <img src="profile.png" class="rounded-circle profile-dropdown" id="profileMenu" 
               data-bs-toggle="dropdown" alt="Profile" width="40" height="40">
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileMenu">
            <li><a class="dropdown-item" href="#">Profile</a></li>
            <li><a class="dropdown-item" href="#">Dashboard</a></li>
            <li><a class="dropdown-item" href="#">View Loan</a></li>
            <li><a class="dropdown-item" href="#">Messages</a></li>
            <li><a class="dropdown-item" href="#">Transactions</a></li>
            <li><a class="dropdown-item" href="#">Email</a></li>
            <li><a class="dropdown-item" href="">Notifications</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-box-arrow-right"></i> Log Out</a></li>
          </ul>
        </div>
        <!-- Then Welcome text -->
        <span class="text-white fw-bold">Welcome, Member!</span>
      </div>

      <!-- Icons (right side) -->
      <div class="d-flex align-items-center">
        <a href="#" class="text-white me-3" title="Email"><i class="bi bi-envelope fs-4"></i></a>
        <a href="#" class="text-white" title="Notifications"><i class="bi bi-bell fs-4"></i></a>
      </div>

    </div>
  </nav>

  <div class="container-fluid">
    <div class="row">
      
      <!-- Sidebar -->
      <div class="col-md-2 sidebar d-flex flex-column">
        <a href="#" class="btn btn-light fw-bold text-start">Dashboard</a>
        <a href="#" class="btn btn-light fw-bold text-start">View Loan</a>
        <a href="#" class="btn btn-light fw-bold text-start">Message(s)</a>
        <a href="#" class="btn btn-light fw-bold text-start">Transactions</a>
      </div>
      
      <!-- Main Content -->
      <div class="col-md-10 p-4">
        <div class="row g-4">
          <!-- Card 1 -->
          <div class="col-md-4 d-flex">
            <div class="card p-3 w-100">
              <img src="https://img.icons8.com/color/96/money-bag.png" class="card-img-top" style="max-height:120px; object-fit:contain;">
              <div class="card-body text-center">
                <p class="card-text">Experience instant loan approval with CoopTech!</p>
                <a href="#" class="btn btn-success btn-sm px-4">Apply now</a>
              </div>
            </div>
          </div>
          <!-- Card 2 -->
          <div class="col-md-4 d-flex">
            <div class="card p-3 w-100">
              <img src="https://img.icons8.com/color/96/bank-card-back-side.png" class="card-img-top" style="max-height:120px; object-fit:contain;">
              <div class="card-body text-center">
                <p class="card-text">View loan history</p>
                <a href="#" class="btn btn-success btn-sm px-4">View History</a>
              </div>
            </div>
          </div>
          <!-- Card 3 -->
          <div class="col-md-4 d-flex">
            <div class="card p-3 w-100">
              <img src="https://img.icons8.com/color/96/handshake.png" class="card-img-top" style="max-height:120px; object-fit:contain;">
              <div class="card-body text-center">
                <p class="card-text">Click here to learn how to use the app!</p>
                <a href="#" class="btn btn-success btn-sm px-4">Learn to loan</a>
              </div>
            </div>
          </div>
        </div>
      </div>
      
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</body>
</html>
