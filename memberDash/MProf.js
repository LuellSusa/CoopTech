// Handle profile picture upload
const imgUpload = document.getElementById("imgUpload");
const profilePic = document.getElementById("profile-pic");

imgUpload.addEventListener("change", function () {
  const file = this.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = function (e) {
      profilePic.src = e.target.result;
    };
    reader.readAsDataURL(file);
  }
});

// Confirm cancel
document.getElementById("cancelBtn").addEventListener("click", function (e) {
  if (!confirm("Are you sure you want to cancel?")) {
    e.preventDefault();
  }
});
