<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login-style.css">
     <link rel="icon" type="image/x-icon" href="CTULOGO.png">
    <title>Login</title>
</head>
<body>
    <div class="container">
        <div class="left-panel">

        </div>

        <div class="right-panel">
            <div class="form-header">
          <image src="CTULOGO.png" alt="CTU Logo" class="logo">
            <p class="title">CTU-Main Multipurpose Cooperative</p>
            </div>
            
            <div class="login-form">
                <input type="text" class="username" placeholder="Username" required>
                <input type="text" class="password" placeholder="password" required>

                <div class="form-options">
    <label class="rememberme">
        <input type="checkbox" name="remember-me" id="remember-me"> Stay Signed in
    </label>
    <a href="#" id="forgotpassword">Forgot password?</a>
</div>

                <input type="button" value="Sign In" class="btn-login">
                <p class="notmember">Not a member?<a href="#" id="signup">&nbsp;Sign up now</a></p>
            </div>
        </div>
 
    </div>
</body>
</html>