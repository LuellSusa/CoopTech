<?php
require 'conn.php';

// Fetch loan options
$stmt = $conn->query("SELECT option_id, loan_type_id, amount, duration_months, service_fee_rate, interest_rate, retention_rate, is_active 
                      FROM loan_options WHERE is_active = 1");
$loanOptions = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch loan types with requires_comaker
$stmt = $conn->query("SELECT loan_type_id, name, requires_comaker FROM loan_types WHERE is_active = 1");
$loanTypes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
  <title>Loan Application Wizard</title>
  <link rel="stylesheet" href="form_style.css">
</head>
<body class="container">

<ul class="progressbar">  
    <li class="active">1. Loan</li>
    <li>2. Co-maker</li>
    <li>3. Payslip</li>
    <li>4. Done</li>
</ul>

<!-- Step 1: Loan -->
<div class="form-step active">
  <div class="loantype">
    <h2>Choose Loan</h2>
    <div class="loan-row">
      <div class="loan-field">
        <label for="loanType">Type of Loan</label>
        <select id="loanType">
          <option value="">Select Loan Type</option>
          <?php foreach ($loanTypes as $loan): ?>
            <option value="<?= $loan['loan_type_id'] ?>"><?= htmlspecialchars($loan['name']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="loan-field">
        <label for="loanAmount">Select Amount</label>
        <select id="loanAmount">
          <option value="">Select Amount</option>
        </select>
      </div>
    </div>

    <!-- Loan details will appear here -->
    <div id="loanDetails" style="margin-top:20px;"></div>

    <button class="next-btn">Next</button>
  </div>
</div>

<!-- Step 2: Co-maker -->
<div class="form-step">
  <div class="comaker">
    <h2 style="text-align:center;">Co-Maker</h2>
    <div style="text-align:center;">
      <input type="text" placeholder="Enter Co-maker Name">
      <br><br>
      <button class="prev-btn">Back</button>
      <button class="next-btn">Next</button>
    </div>
  </div>
</div>

<!-- Step 3: Upload -->
<div class="form-step">
  <div class="dragdrop">
    <h2 style="text-align:center;">Upload Payslip</h2>

    <div id="dropZone" class="drop-zone" role="button" tabindex="0"
         aria-label="Upload payslip (click or drag files here)">
      <p>Drag & drop or click to upload</p>
      <input type="file" id="fileInput" accept=".jpg,.jpeg,.png,.pdf" style="display:none;">
    </div>

    <p id="fileName" style="text-align:center; margin-top:8px;"></p>
    <div id="ocrStatus" style="text-align:center; margin-top:10px;"></div>

    <div style="text-align:center; margin-top:16px;">
      <button class="prev-btn">Back</button>
      <button class="next-btn" id="validateBtn" disabled>Next</button>
    </div>
  </div>
</div>

<!-- Step 4: Success -->
<div class="form-step">
  <div class="success-step">
    <h2>✅ Application Submitted!</h2>
    <p>Thank you for applying. For reimbursement, please contact CoopTech admin.</p>
  </div>
</div>

<!-- ✅ Only ONE definition block -->
<script>
  const loanOptions = <?= json_encode($loanOptions) ?>;
  const loanTypes   = <?= json_encode($loanTypes) ?>;
</script>

<!-- libs (tesseract/pdf) if needed -->
<script src="https://cdn.jsdelivr.net/npm/tesseract.js@5/dist/tesseract.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.min.js"></script>

<!-- Load logic FIRST, then wizard (wizard uses loanLogic) -->
<script src="loan_logic.js"></script>
<script src="wizard.js"></script>
<script src="ocr.js"></script>

</body>
</html>
