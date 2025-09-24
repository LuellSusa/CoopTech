document.addEventListener("DOMContentLoaded", () => {
  const dropZone = document.getElementById("dropZone");
  const fileInput = document.getElementById("fileInput");
  const fileName = document.getElementById("fileName");
  const ocrStatus = document.getElementById("ocrStatus");
  const validateBtn = document.getElementById("validateBtn");

  // wizard elements
  const steps = document.querySelectorAll(".form-step");
  const progress = document.querySelectorAll(".progressbar li");
  let currentStep = 2; // Step 3 (index starts from 0)

  function goToStep(stepIndex) {
    steps.forEach((step, i) => {
      step.classList.toggle("active", i === stepIndex);
      progress[i].classList.toggle("active", i <= stepIndex);
    });
    currentStep = stepIndex;
  }

  const allowedTypes = ['image/png', 'image/jpeg', 'image/jpg', 'application/pdf'];

  if (!dropZone || !fileInput) return;

  // Click to open file picker
  dropZone.addEventListener("click", () => fileInput.click());

  // Drag & drop
  dropZone.addEventListener("dragover", (e) => {
    e.preventDefault();
    dropZone.classList.add("dragover");
  });
  dropZone.addEventListener("dragleave", () => {
    dropZone.classList.remove("dragover");
  });
  dropZone.addEventListener("drop", (e) => {
    e.preventDefault();
    dropZone.classList.remove("dragover");
    if (e.dataTransfer.files.length > 0) {
      handleFile(e.dataTransfer.files[0]);
    }
  });

  // File select
  fileInput.addEventListener("change", () => {
    if (fileInput.files.length > 0) {
      handleFile(fileInput.files[0]);
    }
  });

  async function handleFile(file) {
    if (!file) return;

    if (!allowedTypes.includes(file.type)) {
      ocrStatus.innerHTML = `<span style="color:red;">❌ Invalid file type</span>`;
      return;
    }

    fileName.textContent = `Uploaded: ${file.name}`;
    ocrStatus.innerHTML = `<strong>Analyzing... ⏳</strong>`;
    validateBtn.disabled = true;

    const fd = new FormData();
    fd.append("payslip", file);

    try {
      const resp = await fetch("ocr_api.php", { method: "POST", body: fd });
      const data = await resp.json();

      if (data.success) {
        if (data.eligible) {
          // ✅ Auto jump to Step 4
          ocrStatus.innerHTML =
            `<h3>✅ Successful!</h3>
             <p>Your Net Pay: ₱${data.netPay}</p>
             <p>Status: Eligible</p>`;
          setTimeout(() => goToStep(3), 1500); // jump to Step 4 after short delay
        } else {
          ocrStatus.innerHTML =
            `<h3>❌ Not Eligible</h3>
             <p>Your Net Pay: ₱${data.netPay}</p>
             <p>Minimum required is ₱5000</p>`;
        }
      } else {
        ocrStatus.innerHTML = `<h3>⚠️ Error! please upload again.</h3><p>${data.message}</p>`;
      }
    } catch (err) {
      ocrStatus.innerHTML = `<span style="color:red;">Error: ${err.message}</span>`;
    }
  }
});
