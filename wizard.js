// wizard.js
document.addEventListener("DOMContentLoaded", () => {
  const steps = document.querySelectorAll(".form-step");
  const progress = document.querySelectorAll(".progressbar li");
  const nextBtns = document.querySelectorAll(".next-btn");
  const prevBtns = document.querySelectorAll(".prev-btn");
  const loanType = document.getElementById("loanType");
  const loanAmount = document.getElementById("loanAmount");
  const loanDetails = document.getElementById("loanDetails");

  let currentStep = 0;

  function updateStep() {
    steps.forEach((step, i) => {
      step.classList.toggle("active", i === currentStep);
      progress[i].classList.toggle("active", i <= currentStep);
    });
  }

  // Populate loan amounts dynamically
  loanType.addEventListener("change", () => {
    loanAmount.innerHTML = "<option value=''>Select Amount</option>";
    loanDetails.innerHTML = "";

    if (!loanType.value) return;

    const options = loanOptions.filter(opt => String(opt.loan_type_id) === String(loanType.value));

    if (options.length === 0) {
      const option = document.createElement("option");
      option.value = "";
      option.textContent = "No options available";
      loanAmount.appendChild(option);
    } else {
      options.forEach(opt => {
        const option = document.createElement("option");
        option.value = opt.option_id;
        option.textContent = `₱${opt.amount} (${opt.duration_months} months)`;
        loanAmount.appendChild(option);
      });
    }
  });

  // Show loan details when an amount is selected
  loanAmount.addEventListener("change", () => {
    const selected = loanOptions.find(opt => String(opt.option_id) === String(loanAmount.value));
    if (!selected) {
      loanDetails.innerHTML = "";
      return;
    }

    let detailsHtml = "";

    // Petty Cash = loan_type_id 1
    if (String(selected.loan_type_id) === "1") {
      const result = loanLogic.calculatePettyCash(
        parseFloat(selected.amount),
        parseInt(selected.duration_months),
        parseFloat(selected.service_fee_rate) / 100,
        parseFloat(selected.interest_rate) / 100
      );

      detailsHtml = `
        <div class="loan-card">
          <h4>Petty Cash Details</h4>
          <p><strong>Service Fee:</strong> ₱${result.serviceFee.toFixed(2)}</p>
          <p><strong>Monthly Fee (total interest):</strong> ₱${result.advanceInterest.toFixed(2)}</p>
          <p><strong>Amount to Receive:</strong> ₱${result.netProceeds.toFixed(2)}</p>
          <p><strong>Monthly Payment:</strong> ₱${result.monthlyPayment.toFixed(2)}</p>
        </div>
      `;
    }

    // Bonanza = loan_type_id 2 or 4
    else if (String(selected.loan_type_id) === "4" || String(selected.loan_type_id) === "2") {
      const result = loanLogic.calculateBonanza(
        parseFloat(selected.amount),
        parseInt(selected.duration_months),
        parseFloat(selected.interest_rate),
        parseFloat(selected.service_fee_rate),
        parseFloat(selected.retention_rate) || 0
      );

      detailsHtml = `
        <div class="loan-card">
          <h4>Bonanza Details</h4>
          <p><strong>Processing Fee:</strong> ₱${result.serviceFee.toFixed(2)}</p>
          <p><strong>Retention Fee:</strong> ₱${result.retentionFee.toFixed(2)}</p>
          <p><strong>Monthly Interest (per month):</strong> ₱${result.monthlyInterest.toFixed(2)}</p>
          <p><strong>Total Interest:</strong> ₱${result.totalInterest.toFixed(2)}</p>
          <p><strong>Net Proceeds:</strong> ₱${result.netProceeds.toFixed(2)}</p>
          <p><strong>Monthly Payment:</strong> ₱${result.monthlyPayment.toFixed(2)}</p>
          <p><strong>Total Payable:</strong> ₱${result.totalPayable.toFixed(2)}</p>
        </div>
      `;
    }

    // MPL (loan_type_id 3)
    else {
      const result = loanLogic.calculateMPL(
        parseFloat(selected.amount),
        parseInt(selected.duration_months),
        parseFloat(selected.interest_rate)
      );

      detailsHtml = `
        <div class="loan-card">
          <h4>MPL Details</h4>
          <p><strong>Total Interest:</strong> ₱${result.totalInterest.toFixed(2)}</p>
          <p><strong>Total Payable:</strong> ₱${result.totalPayable.toFixed(2)}</p>
        </div>
      `;
    }

    loanDetails.innerHTML = detailsHtml;
  });

  // Navigation buttons
nextBtns.forEach(btn => {
  btn.addEventListener("click", () => {
    if (currentStep === 0) {
      if (!loanType.value || !loanAmount.value) {
        alert("⚠️ Please select both loan type and amount before proceeding.");
        return;
      }

      // ✅ Check if selected loan type requires co-maker
      const selectedType = loanTypes.find(t => String(t.loan_type_id) === String(loanType.value));
      if (selectedType && parseInt(selectedType.requires_comaker) === 0) {
        // Skip Step 2 (Co-maker), jump directly to Step 3 (Payslip)
        currentStep = 2;
        updateStep();
        return;
      }
    }

    if (currentStep < steps.length - 1) {
      currentStep++;
      updateStep();
    }
  });
});

prevBtns.forEach(btn => {
  btn.addEventListener("click", () => {
    if (currentStep > 0) {
      // ✅ If current step is 2 (Payslip) and loan doesn’t need co-maker → jump to Step 0 (Loan)
      const selectedType = loanTypes.find(t => String(t.loan_type_id) === String(loanType.value));
      if (currentStep === 2 && selectedType && parseInt(selectedType.requires_comaker) === 0) {
        currentStep = 0; // jump straight back to Loan step
      } else {
        currentStep--;
      }
      updateStep();
    }
  });
});

});
