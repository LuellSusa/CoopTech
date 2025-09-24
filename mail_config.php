<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Adjusted path:
require __DIR__ . '/../vendor/autoload.php';

function sendConfirmationMail($toEmail, $code) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'isaiahvincentbriones@gmail.com';
        $mail->Password   = 'zpxg nqiu ivpe gqyw'; // App password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom('isaiahvincentbriones@gmail.com', 'CTU-Main Cooperative');
        $mail->addAddress($toEmail);

        $mail->isHTML(true);
        $mail->Subject = "Account Verification Code";
        $mail->Body    = "Your confirmation code is: <b>$code</b>";

        $mail->send();
        return true;
    } catch (Exception $e) {
        return "Mailer Error: {$mail->ErrorInfo}";
    }
}
?>
