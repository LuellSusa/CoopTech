<?php
session_start();
include "conn.php";
include "check.php";
check_session();

// Fetch loan types for dropdown
$types = $conn->query("SELECT loan_type_id, name FROM loan_types WHERE is_active = 1")->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $loan_type_id = $_POST['loan_type_id'];
    $amount = $_POST['amount'];
    $duration = $_POST['duration'];
    $service_fee_rate = $_POST['service_fee_rate'];
    $interest_rate = $_POST['interest_rate'];

    $stmt = $conn->prepare("
        INSERT INTO loan_options (loan_type_id, amount, duration_months, service_fee_rate, interest_rate, is_active)
        VALUES (?, ?, ?, ?, ?, 1)
    ");
    $stmt->execute([$loan_type_id, $amount, $duration, $service_fee_rate, $interest_rate]);

    header("Location: manageL.php");
    exit;
}
?>

<?php include "header.php"; ?>
<?php include "sidebar.php"; ?>

<main class="app-main">
  <div class="app-content p-4">
    <h3>Add Loan Option</h3>
    <form method="POST">
      <div class="mb-3">
        <label>Loan Type</label>
        <select name="loan_type_id" class="form-control" required>
          <?php foreach ($types as $type): ?>
            <option value="<?= $type['loan_type_id'] ?>"><?= htmlspecialchars($type['name']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="mb-3">
        <label>Amount</label>
        <input type="number" step="0.01" name="amount" class="form-control" required>
      </div>

      <div class="mb-3">
        <label>Duration (months)</label>
        <input type="number" name="duration" class="form-control" required>
      </div>

      <div class="mb-3">
        <label>Service Fee (%)</label>
        <input type="number" step="0.01" name="service_fee_rate" class="form-control" required>
      </div>

      <div class="mb-3">
        <label>Interest Rate (% per month)</label>
        <input type="number" step="0.01" name="interest_rate" class="form-control" required>
      </div>

      <button type="submit" class="btn btn-success">Save</button>
      <a href="manageL.php" class="btn btn-secondary">Cancel</a>
    </form>
  </div>
</main>
