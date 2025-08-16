<?php
$conn = new mysqli("localhost", "root", "", "signup");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['signup'])) {
    $name     = $_POST['name'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $password   = $_POST['password'];
    $email    = $_POST['email'];
    $code     = $_POST['code'];

    // Check if email + code exists and not verified
    $stmt = $conn->prepare("SELECT * FROM email_verification WHERE email = ? AND code = ? AND verified = 0");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("ss", $email, $code);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Mark code as verified
        $update = $conn->prepare("UPDATE email_verification SET verified = 1 WHERE email = ?");
        $update->bind_param("s", $email);
        $update->execute();

        echo "✅ Code verified! Account can be created.";
        // Here you can insert user info into a users table
    } else {
        echo "❌ Invalid code or already used!";
    }
}

$conn->close();
?>


<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Create Account Form</title>
  <link rel="stylesheet" href="signup.css">
  <script src="signup.js"></script>
</head>
<body>
  <div class="container">
    <img src="ctu.png" alt="Logo">
    <h2>CREATE ACCOUNT</h2>
    
    <form method="post" action="signup.php">
      <div class="signup">
        <input type="name" name="name" placeholder="Your name" required>
      </div>
      <div class="signup">
        <input type="username" name="username" placeholder="Username" required>
      </div>
      <div class="signup">
        <input type="password" name="password" placeholder="Password" required>
      </div>
      <div class="signup">
        <input type="password" name="password" placeholder="Re-Enter Password" required>
      </div>
      <div class="signup">
        <input type="email" name="email" placeholder="Email" required>
      </div>
      <div class="signup signup-form">
        <input type="text" name="code" id="code" placeholder="Code" required>
        <button type="button" class="btn-sendcode" onclick="sendCode()">Send Code</button>
      </div>
      <br>
      <div class="terms">
        <input type="checkbox" id="terms" required>
        <label for="terms">By creating an account, you agree to CTU Multi Cooperative Conditions of Use and Privacy Notice.
      
        <button type="submit" class="btnsignin">Sign up</button>
    </form>
    <div class="signin">
      Already have an account? <a href="login.php">Sign in</a>
    </div>
  </div>
</body>
</html>
