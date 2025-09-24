<?php
session_start();
include "conn.php";
include "check.php";
check_session();

// Fetch loan types and options
$stmt = $conn->query("
    SELECT lt.loan_type_id, lt.name AS loan_type, lt.is_active AS type_active,
           lo.option_id, lo.amount, lo.duration_months, lo.service_fee_rate, lo.interest_rate, lo.is_active AS option_active
    FROM loan_types lt
    LEFT JOIN loan_options lo ON lt.loan_type_id = lo.loan_type_id
    ORDER BY lt.loan_type_id, lo.amount
");
$loans = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include "header.php"; ?>
<?php include "sidebar.php"; ?>

<main class="app-main">
  <div class="app-content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Manage Loan</h3></div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item active">Manage Loan</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <div class="app-content">
    <div class="container-fluid">

      <!-- Add Loan Option Button -->
      <div class="mb-3">
        <a href="add_loan.php" class="btn btn-primary">
          <i class="fas fa-plus"></i> Add Loan Option
        </a>
      </div>

      <!-- Loan Management Table -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Loan Types & Options</h3>
        </div>
        <div class="card-body table-responsive">
          <table class="table table-bordered table-striped align-middle">
            <thead>
              <tr>
                <th>Loan Type</th>
                <th>Amount</th>
                <th>Duration (months)</th>
                <th>Service Fee (%)</th>
                <th>Interest (%)</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
            <?php if ($loans): ?>
              <?php foreach ($loans as $loan): ?>
                <tr>
                  <td>
                    <?= htmlspecialchars($loan['loan_type']) ?>
                    <?php if (!$loan['type_active']): ?>
                      <span class="badge bg-danger ms-2">Type Disabled</span>
                    <?php endif; ?>
                  </td>

                  <td><?= $loan['option_id'] ? number_format($loan['amount'], 2) : '-' ?></td>
                  <td><?= $loan['option_id'] ? htmlspecialchars($loan['duration_months']) : '-' ?></td>
                  <td><?= $loan['option_id'] ? htmlspecialchars($loan['service_fee_rate']) . "%" : '-' ?></td>
                  <td><?= $loan['option_id'] ? htmlspecialchars($loan['interest_rate']) . "%" : '-' ?></td>

                  <td>
                    <?php if ($loan['option_id']): ?>
                      <?php if ($loan['option_active']): ?>
                        <span class="badge bg-success">Active</span>
                      <?php else: ?>
                        <span class="badge bg-danger">Disabled</span>
                      <?php endif; ?>
                    <?php else: ?>
                      <span class="text-muted">No Options</span>
                    <?php endif; ?>
                  </td>

                  <td>
                    <?php if ($loan['option_id']): ?>
                      <a href="edit_loan.php?option_id=<?= $loan['option_id'] ?>" class="btn btn-sm btn-warning">
                        <i class="fas fa-edit"></i> Edit
                      </a>
                      <a href="toggle_loan.php?option_id=<?= $loan['option_id'] ?>" class="btn btn-sm btn-secondary">
                        <i class="fas fa-toggle-on"></i> Toggle
                      </a>
                      <a href="delete_loan.php?option_id=<?= $loan['option_id'] ?>" class="btn btn-sm btn-danger"
                         onclick="return confirm('Are you sure you want to delete this option?');">
                        <i class="fas fa-trash"></i> Delete
                      </a>
                    <?php else: ?>
                      <span class="text-muted">No actions</span>
                    <?php endif; ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="7" class="text-center text-muted">No loan types or options found</td>
              </tr>
            <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>x
    </div>
  </div>
</main>

<!-- your existing JS scripts go here -->
<script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js"></script>
<!-- OverlayScrollbars -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css">
<script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js"></script>

<!-- ApexCharts -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts/dist/apexcharts.css">
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<!-- jsVectorMap -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jsvectormap/dist/css/jsvectormap.min.css">
<script src="https://cdn.jsdelivr.net/npm/jsvectormap"></script>

<!-- AdminLTE -->
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

