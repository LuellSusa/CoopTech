<?php
function send_gmail($to, $subject, $message) {
    $from = "candolhannyjoypapasin@gmail.com";        // replace with your Gmail
    $password = "your-app-password";      // App Password, not normal password

    // Email headers
    $headers  = "From: $from\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

    // Use PHP's built-in mail() -> only works if your PHP server has an SMTP relay
    // Otherwise you need fsockopen() to smtp.gmail.com
    if(mail($to, $subject, $message, $headers)){
        return true;
    } else {
        return false;
    }
}
?>
