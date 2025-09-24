<?php
include "reg.php"; // Include your registration logic

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Create Account</title>
  <style>
   body {
  margin: 0;
  padding: 0;
  font-family: Arial, Helvetica, sans-serif;
  background: #006d77;
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
}
.signup-container {
  background: #fff;
  padding: 30px 25px;
  border-radius: 10px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.15);
  width: 350px;
  text-align: center;
}
.signup-container img {
  display: block;
  margin: 0 auto 15px auto; /* centers and adds spacing below */
  width: 60px;  /* adjust size */
  height: auto;
}
h2 {
  margin: 10px 0 20px;
  font-size: 18px;
  font-weight: 700;
}
.signup {
  margin-bottom: 15px;
  text-align: left;
}
.signup input {
  width: 93%;
  padding: 10px;
  border: 1px solid #333;
  border-radius: 5px;
  font-size: 14px;
}
.signup-form {
  display: flex;
  gap: 8px;
  align-items: center;
}
.signup-form input {
  flex: 1;
}

.btnsignin {
  width: 100%;
  padding: 12px;
  background: #a7f3d0;
  border: none;
  border-radius: 20px;
  font-weight: 600;
  font-size: 15px;
  cursor: pointer;
  margin: 15px 0;
  color: #111;
  font-family: Arial;
}
.btnsignin:hover {
  background: #81e6d9;
}
.terms {
  font-size: 11px;
  color: #555;
  margin-bottom: 15px;
  
}
.terms a { color: #111; text-decoration: underline; }
.signin {
  font-size: 13px;
}
.signin a {
  color: #2563eb;
  text-decoration: none;
}
.signin a:hover {
  text-decoration: underline;
}
  </style>
</head>
<body>
  <div class="signup-container">
  <image src="pictures/CTULOGO.png" alt="CTU Logo" class="logo"></image>
    <h2>Create Account</h2>
    <form onsubmit="POST">
      <div class="signup">
        <input type="name" id="fullname" name="fullname" placeholder="Your name" required>
      </div>
      <div class="signup">
        <input type="username" id="username" name="username" placeholder="Username" required>
      </div>
      <div class="signup">
        <input type="email" id="email" name="email" placeholder="Email" required>
      </div>
      <div class="signup">
        <input type="password" id="password" name="password" placeholder="Password" required>
      </div>
      <div class="signup">
        <input type="password" id="confirm-password" name="password" placeholder="Confirm Password" required>
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
