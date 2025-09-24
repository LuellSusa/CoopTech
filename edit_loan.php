<?php
session_start();
include "conn.php";
include "check.php";
check_session();

if (!isset($_GET['option_id'])) {
    header("Location: manageL.php");
    exit;
}

$option_id = $_GET['option_id'];

// Fetch loan option
$stmt = $conn->prepare("
    SELECT lo.*, lt.name AS loan_type
    FROM loan_options lo
    JOIN loan_types lt ON lo.loan_type_id = lt.loan_type_id
    WHERE lo.option_id = ?
");
$stmt->execute([$option_id]);
$loan = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$loan) {
    header("Location: manageL.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amount = $_POST['amount'];
    $duration = $_POST['duration'];
    $service_fee_rate = $_POST['service_fee_rate'];
    $interest_rate = $_POST['interest_rate'];

    $stmt = $conn->prepare("
        UPDATE loan_options
        SET amount = ?, duration_months = ?, service_fee_rate = ?, interest_rate = ?
        WHERE option_id = ?
    ");
    $stmt->execute([$amount, $duration, $service_fee_rate, $interest_rate, $option_id]);

    header("Location: manageL.php");
    exit;
}
?>

<?php include "header.php"; ?>
<?php include "sidebar.php"; ?>

<main class="app-main">
  <div class="app-content p-4">
    <h3>Edit Loan Option</h3>
    <form method="POST">
      <div class="mb-3">
        <label>Loan Type</label>
        <input type="text" class="form-control" value="<?= htmlspecialchars($loan['loan_type']) ?>" disabled>
      </div>

      <div class="mb-3">
        <label>Amount</label>
        <input type="number" step="0.01" name="amount" class="form-control" value="<?= htmlspecialchars($loan['amount']) ?>" required>
      </div>

      <div class="mb-3">
        <label>Duration (months)</label>
        <input type="number" name="duration" class="form-control" value="<?= htmlspecialchars($loan['duration_months']) ?>" required>
      </div>

      <div class="mb-3">
        <label>Service Fee (%)</label>
        <input type="number" step="0.01" name="service_fee_rate" class="form-control" value="<?= htmlspecialchars($loan['service_fee_rate']) ?>" required>
      </div>

      <div class="mb-3">
        <label>Interest Rate (% per month)</label>
        <input type="number" step="0.01" name="interest_rate" class="form-control" value="<?= htmlspecialchars($loan['interest_rate']) ?>" required>
      </div>

      <button type="submit" class="btn btn-primary">Update</button>
      <a href="manageL.php" class="btn btn-secondary">Cancel</a>
    </form>
  </div>
</main>
