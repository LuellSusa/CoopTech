function sendCode() {
  let email = document.querySelector('input[name="email"]').value;

  if (!email) {
      alert("Please enter your email first!");
      return;
  }

  fetch("send_code.php", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: "email=" + encodeURIComponent(email)
  })
  .then(res => res.text())
  .then(data => alert(data))
  .catch(err => alert("Error: " + err));
}
