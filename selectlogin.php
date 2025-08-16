<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="select-style.css">
    <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>
    <title>Document</title>
</head>
<body>
     <div id="loader">
        <img src="spinner.gif" alt="Loading...">
    </div>
    <div class="container">

        <!-- Left Panel -->
        <div class="left-panel">
            <a href="member.php" class="panel-link">
                <img src="member.png" alt="member logo" class="member-logo">
                <p class="member-title">MEMBER</p>
            </a>
        </div>

        <!-- Right Panel -->
        <div class="right-panel">
            <a href="admin.php" class="panel-link">
                <img src="admin.png" alt="admin logo" class="admin-logo">
                <p class="admin-title">ADMIN</p>
            </a>
        </div>

    </div>
<script>
 window.addEventListener("load", function() {
  setTimeout(function() {
    document.getElementById("loader").style.display = "none";
    document.querySelector(".container").style.visibility = "visible";
  }); 
});
</script>
    
</body>
</html>
