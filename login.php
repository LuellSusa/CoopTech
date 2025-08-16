<?php
include 'connect.php';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Here you would typically check the credentials against a database
    // For demonstration, we will assume a successful login
    if ($username === 'admin' && $password === '123') {
        echo "<script>
                alert('✅ Login successful!');
                window.location.href = 'selectlogin.php'; // redirect after alert
              </script>";
        
    } else {
        echo "<script>
                alert('❌ Invalid username or password.');
                window.location.href = 'login.php'; // reload login page
              </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login-style.css">
     <link rel="icon" type="image/x-icon" href="CTULOGO.png">
     <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>
    <title>Login</title>
</head>
<body>
    <div id="loader">
        <img src="spinner.gif" alt="Loading...">
    </div>
    <div class="container">
        <div class="left-panel">

        </div>

        <div class="right-panel">
            <div class="form-header">
          <image src="CTULOGO.png" alt="CTU Logo" class="logo">
            <p class="title">CTU-Main Multipurpose Cooperative</p>
            </div>
            <form action="login.php" method="POST">
            <div class="login-form">
                <input type="text" name="username" class="username" placeholder="Username" required>
                <input type="password" name="password" class="password" placeholder="password" required>

             <div class="form-options">
              <label class="rememberme">
             <input type="checkbox" name="remember-me" id="remember-me"> Stay Signed in
              </label>
             <a href="#" id="forgotpassword">Forgot password?</a>
             </div> 

                <input type="submit" value="Sign In" class="btn-login">
                <p class="notmember">Not a member?<a href="#" id="signup">&nbsp;Sign up now</a></p>
            </div>
            </form>
        </div>
 
    </div>

     <script>
    // Hide loader when page is fully loaded
   window.addEventListener("load", function() {
  setTimeout(function() {
    document.getElementById("loader").style.display = "none";
    document.querySelector(".container").style.visibility = "visible";
  }); // 2 seconds delay
});

   
  </script>
</body>
</html>