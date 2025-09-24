<?php
include "conn.php";
include "check.php";
check_session();
require 'mail_config.php';

$email = "isaiahvincentbriones@gmail.com";
$code  = rand(100000, 999999);

$result = sendConfirmationMail($email, $code);

if ($result === true) {
    echo "";
} else {
    echo $result; // Show error message if failed
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
  FUCK YOU NIGGA ./.
<a href="out.php" class="text-center"> Logout </a>
</body>
</html>
