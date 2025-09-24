<?php
session_start();
include 'conn.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("
    SELECT u.user_id, u.name, u.email, u.contact, u.profile_image, 
           u.address, u.dob, r.role_name
    FROM users u
    LEFT JOIN user_roles ur ON u.user_id = ur.user_id
    LEFT JOIN roles r ON ur.role_id = r.role_id
    WHERE u.user_id = ?
");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
$role = $user['role_name'] ?? 'Member';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>User Profile</title>
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <style>
    .profile-user-img {
      width: 120px;
      height: 120px;
      object-fit: cover;
      border: 3px solid #adb5bd;
    }
    .btn-edit {
      background-color: #ffc107;
      color: #000;
    }
    .btn-save {
      background-color: #28a745;
      color: #fff;
    }
    .btn-cancel {
      background-color: #6c757d;
      color: #fff;
    }
  </style>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <?php include 'header.php'; ?>
  <?php include 'sidebar.php'; ?>

  <!-- Content Wrapper -->
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <h1>User Profile</h1>
      </div>
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          
          <!-- Profile Sidebar -->
          <div class="col-md-3">
            <div class="card card-primary card-outline">
              <div class="card-body box-profile text-center">
                <img class="profile-user-img img-circle"
                     src="<?= htmlspecialchars($user['profile_image'] ?? '/pictures/default.jpg') ?>"
                     alt="User profile picture">
                <h3 class="profile-username"><?= htmlspecialchars($user['name'] ?? 'N/A') ?></h3>
                <p class="text-muted"><?= htmlspecialchars($role) ?></p>
              </div>
            </div>
          </div>

          <!-- Profile Content -->
          <div class="col-md-9">
            <div class="card">
              <div class="card-header p-2">
                <h3 class="card-title">Profile Information</h3>
              </div>
              <div class="card-body">

                <!-- View Mode -->
                <div id="viewProfile">
                  <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item"><b>ID Number:</b> <span class="float-right"><?= htmlspecialchars($user['user_id'] ?? 'N/A') ?></span></li>
                    <li class="list-group-item"><b>Full Name:</b> <span class="float-right"><?= htmlspecialchars($user['name'] ?? 'N/A') ?></span></li>
                    <li class="list-group-item"><b>Address:</b> <span class="float-right"><?= htmlspecialchars($user['address'] ?? 'N/A') ?></span></li>
                    <li class="list-group-item"><b>Contact:</b> <span class="float-right"><?= htmlspecialchars($user['contact'] ?? 'N/A') ?></span></li>
                    <li class="list-group-item"><b>Date of Birth:</b> <span class="float-right"><?= htmlspecialchars($user['dob'] ?? 'N/A') ?></span></li>
                    <li class="list-group-item"><b>Email:</b> <span class="float-right"><?= htmlspecialchars($user['email'] ?? 'N/A') ?></span></li>
                  </ul>
                  <div class="text-center">
                    <button class="btn btn-edit" onclick="toggleEdit(true)">
                      <i class="fas fa-edit"></i> Edit Profile
                    </button>
                  </div>
                </div>

                <!-- Edit Mode -->
                <form id="editProfile" action="update_profile.php" method="POST" enctype="multipart/form-data" style="display:none;">
                  <input type="hidden" name="user_id" value="<?= htmlspecialchars($user['user_id'] ?? '') ?>">

                  <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" class="form-control" name="name" value="<?= htmlspecialchars($user['name'] ?? '') ?>">
                  </div>

                  <div class="form-group">
                    <label>Address</label>
                    <input type="text" class="form-control" name="address" value="<?= htmlspecialchars($user['address'] ?? '') ?>">
                  </div>

                  <div class="form-group">
                    <label>Contact</label>
                    <input type="text" class="form-control" name="contact" value="<?= htmlspecialchars($user['contact'] ?? '') ?>">
                  </div>

                  <div class="form-group">
                    <label>Date of Birth</label>
                    <input type="date" class="form-control" name="dob" value="<?= htmlspecialchars($user['dob'] ?? '') ?>">
                  </div>

                  <div class="form-group">
                    <label>Email</label>
                    <input type="email" class="form-control" name="email" value="<?= htmlspecialchars($user['email'] ?? '') ?>">
                  </div>

                  <div class="form-group">
                    <label>Profile Picture</label>
                    <input type="file" class="form-control-file" name="profile_image">
                  </div>

                  <div class="text-center">
                    <button type="submit" class="btn btn-save"><i class="fas fa-check"></i> Save</button>
                    <button type="button" class="btn btn-cancel" onclick="toggleEdit(false)"><i class="fas fa-times"></i> Cancel</button>
                  </div>
                </form>

              </div>
            </div>
          </div>

        </div>
      </div>
    </section>
  </div>
</div>

<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>
<script>
function toggleEdit(editMode) {
  document.getElementById('viewProfile').style.display = editMode ? 'none' : 'block';
  document.getElementById('editProfile').style.display = editMode ? 'block' : 'none';
}
</script>
</body>
</html>