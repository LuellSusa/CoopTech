<?php
include "conn.php"; 
include "check.php";

// Fetch current logged-in user for header
$headerUser = null;
if (isset($_SESSION['user_id'])) {
    $stmt = $conn->prepare("SELECT name, profile_image FROM users WHERE user_id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $headerUser = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Fetch users and aggregated role info for the table
try {
    $stmt = $conn->query("
        SELECT 
            u.user_id,
            u.name,
            u.email,
            u.status,
            GROUP_CONCAT(r.role_id) AS role_ids,
            GROUP_CONCAT(r.role_name SEPARATOR ', ') AS roles
        FROM users u
        LEFT JOIN user_roles ur ON u.user_id = ur.user_id
        LEFT JOIN roles r ON ur.role_id = r.role_id
        GROUP BY u.user_id
        ORDER BY u.user_id ASC
    ");
    $allUsers = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // all roles for dropdown
    $rolesStmt = $conn->query("SELECT role_id, role_name FROM roles ORDER BY role_id ASC");
    $allRoles = $rolesStmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>

<!doctype html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
    <meta name="color-scheme" content="light dark" />
    <meta name="theme-color" content="#007bff" media="(prefers-color-scheme: light)" />
    <meta name="theme-color" content="#1a1a1a" media="(prefers-color-scheme: dark)" />

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Source+Sans+3&display=swap">

    <!-- OverlayScrollbars -->
    <link rel="stylesheet" href="plugins/overlayscrollbars/css/OverlayScrollbars.min.css">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="css/adminlte.css">

    <!-- Optional Charts -->
    <link rel="stylesheet" href="plugins/apexcharts/apexcharts.css">
    <link rel="stylesheet" href="plugins/jsvectormap/jsvectormap.min.css">
  </head>
  <body class="layout-fixed sidebar-expand-lg sidebar-open bg-body-tertiary">
    <div class="app-wrapper">
      <!--begin::Header-->
      <nav class="app-header navbar navbar-expand bg-body">
        <div class="container-fluid">
          <!--begin::Start Navbar Links-->
          <ul class="navbar-nav">
            <li class="nav-item d-none d-md-block"><a href="index.php" class="nav-link">Home</a></li>
            <li class="nav-item d-none d-md-block"><a href="#" class="nav-link">Contact</a></li>
          </ul>
          <!--end::Start Navbar Links-->

          <!--begin::End Navbar Links-->
          <ul class="navbar-nav ms-auto">
            <!-- Messages Dropdown -->
            <li class="nav-item dropdown">
              <a class="nav-link" data-bs-toggle="dropdown" href="#">
                <i class="bi bi-chat-text"></i>
                <span class="navbar-badge badge text-bg-danger">3</span>
              </a>
              <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
              </div>
            </li>
            <!-- Notifications Dropdown -->
            <li class="nav-item dropdown">
              <a class="nav-link" data-bs-toggle="dropdown" href="#">
                <i class="bi bi-bell-fill"></i>
                <span class="navbar-badge badge text-bg-warning">15</span>
              </a>
              <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                <span class="dropdown-item dropdown-header">15 Notifications</span>
              </div>
            </li>
            <!-- User Menu -->
            <li class="nav-item dropdown user-menu">
              <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                <img src="<?= htmlspecialchars($headerUser['profile_image'] ?? 'pictures/default.jpg') ?>" 
                     class="user-image rounded-circle shadow" alt="User Image">
                <span class="d-none d-md-inline"><?= htmlspecialchars($headerUser['name']) ?></span>
              </a>
              <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                <li class="user-header text-bg-primary">
                  <img src="<?= htmlspecialchars($headerUser['profile_image'] ?? 'pictures/default.jpg') ?>" 
                       class="rounded-circle shadow" alt="User Image">
                  <p><?= htmlspecialchars($headerUser['name']) ?></p>
                </li>
                <li class="user-footer">
                  <form id="profileUploadForm" action="upload_profile.php" method="POST" enctype="multipart/form-data" style="display:none;">
                    <input type="file" name="profile_image" id="profileImageInput" accept="image/*" onchange="document.getElementById('profileUploadForm').submit();">
                  </form>
<a href="profile.php" class="btn btn-default btn-flat">Profile</a>
                  <a href="out.php" class="btn btn-default btn-flat float-end">Sign out</a>
                </li>
              </ul>
            </li>
          </ul>
          <!--end::End Navbar Links-->
        </div>
      </nav>
      <!--end::Header-->