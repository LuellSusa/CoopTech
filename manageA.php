<?php
// NOTE: header.php already includes conn.php and check.php and runs check_session()
include "header.php";

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
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // all roles for dropdown
    $rolesStmt = $conn->query("SELECT role_id, role_name FROM roles ORDER BY role_id ASC");
    $allRoles = $rolesStmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>

<?php include "sidebar.php"; ?>

<!--begin::App Main-->
<main class="app-main">
  <div class="app-content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Manage Accounts</h3></div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Manage Accounts</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <div class="app-content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th scope="col"><i class="bi bi-person-badge"></i> User ID</th>
                    <th scope="col"><i class="bi bi-person"></i> Name</th>
                    <th scope="col"><i class="bi bi-envelope"></i> Email</th>
                    <th scope="col"><i class="bi bi-person-gear"></i> Roles</th>
                    <th scope="col"><i class="bi bi-circle-half"></i> Status</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($users as $u): ?>
                  <tr class="user-row"
                      data-user-id="<?= htmlspecialchars($u['user_id'], ENT_QUOTES) ?>"
                      data-user-name="<?= htmlspecialchars($u['name'], ENT_QUOTES) ?>"
                      data-user-status="<?= htmlspecialchars($u['status'], ENT_QUOTES) ?>"
                      data-user-roleids="<?= htmlspecialchars($u['role_ids'] ?? '', ENT_QUOTES) ?>"
                      data-user-roles="<?= htmlspecialchars($u['roles'] ?? '', ENT_QUOTES) ?>">
                    <th scope="row"><?= htmlspecialchars($u['user_id']) ?></th>
                    <td class="user-name text-primary" style="cursor:pointer;"><?= htmlspecialchars($u['name']) ?></td>
                    <td><?= htmlspecialchars($u['email']) ?></td>
                    <td><?= htmlspecialchars($u['roles'] ?: 'Member') ?></td>
                    <td><?= $u['status'] ? 'Active' : 'Disabled' ?></td>
                  </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>

<!-- MODAL (Role dropdown + Status dropdown) -->
<div class="modal fade" id="userModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form id="updateUserForm" method="post" action="update_user.php">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit User</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="user_id" id="modalUserId">
          <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" id="modalUserName" class="form-control" disabled>
          </div>
          <div class="mb-3">
            <label class="form-label">Role</label>
            <select name="roles[]" id="modalUserRole" class="form-select">
              <option value="">None (Member)</option>
              <?php foreach ($allRoles as $role): ?>
                <option value="<?= $role['role_id'] ?>"><?= htmlspecialchars($role['role_name']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" id="modalUserStatus" class="form-select">
              <option value="1">Active</option>
              <option value="0">Disabled</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
<script src="./js/adminlte.js"></script>

<script>
  // open modal when clicking user name
  document.querySelectorAll('.user-name').forEach(el => {
    el.addEventListener('click', function () {
      const row = this.closest('.user-row');
      const uid = row.dataset.userId || '';
      const uname = row.dataset.userName || '';
      const ustatus = row.dataset.userStatus === '1' ? '1' : '0';
      const uroleids = (row.dataset.userRoleids || '').split(',').filter(Boolean);

      document.getElementById('modalUserId').value = uid;
      document.getElementById('modalUserName').value = uname;
      document.getElementById('modalUserStatus').value = ustatus;

      const roleSelect = document.getElementById('modalUserRole');
      roleSelect.value = uroleids.length > 0 ? uroleids[0] : '';
      
      new bootstrap.Modal(document.getElementById('userModal')).show();
    });
  });
</script>

</body>
</html>