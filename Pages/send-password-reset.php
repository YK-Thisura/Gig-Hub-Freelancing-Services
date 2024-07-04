<?php

$email = $_POST["email"];
$token = bin2hex(random_bytes(16)); 
$token_hash = hash("sha256", $token); //hashes the value
$expiry = date("Y-m-d H:i:s", time() + 60 * 30); 
$mysqli = require __DIR__ . "/database.php";

$sql = "UPDATE user
        SET reset_token_hash = ?,
            reset_token_expires_at = ?
        WHERE email = ?";

$stmt = $mysqli->prepare($sql);

$stmt->bind_param("sss", $token_hash, $expiry, $email);

$stmt->execute();

if ($mysqli->affected_rows) {

    $mail = require __DIR__ . "/mailer.php";

    $mail->setFrom("GigHubPvt@gmail.com");
    $mail->addAddress($email);
    $mail->Subject = "Password Reset";

  // Additional content for the email body
    $additionalContent = <<<BODY

    <p>We received a request to reset your account password. To proceed with the password reset, please click on the link below:</p>

    <p>
        <a href="http://localhost/finalProjectGighub/reset-password.php?token={$token}">
            Reset Your Password
        </a>
    </p>

    <p>
        If you did not initiate this request, you can safely ignore this email. However, if you have any concerns or didn't expect this email,
        please <a href="contact.php">contact our support team</a>.
    </p>

    <p>Thank you,<br>GigHub Team</p>
BODY;

    // Complete email body
    $mail->Body = <<<END
    PASSWORD RESET 

    {$additionalContent}
END;

    // $mail->Body = <<<END

    // Click <a href="http://localhost/finalP/try3/php-password-reset-main/reset-password.php?token=$token">here</a> 
    // to reset your password.

    // END;

    try {

        $mail->send();

  // Display HTML message after the mail is sent
        echo <<<HTML
        <!DOCTYPE html>
        <html>
        <head>
            <title>Password Reset Email Sent</title>
            <meta charset="UTF-8">
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
        </head>
        <body>
        <h1>Password Reset</h1>

    <p>
        We've sent an email to your registered email address with instructions to reset your password.
        Please follow the steps below:
    </p>

    <ol>
        <li>Check your email inbox for a message titled "Password Reset."</li>
        <li>Click on the link provided in the email. This will take you to a page where you can reset your password.</li>
        <li>Enter your new password and confirm it by typing it again.</li>
        <li>Click the "Reset Password" button to complete the process.</li>
    </ol>

    <p>
        If you did not receive the email, please check your spam folder. If you still encounter issues,
        <a href="contact.php">contact our support team</a> for assistance.
    </p>
        </body>
        </html>
HTML;




    } catch (Exception $e) {

        echo "Message could not be sent. Mailer error: {$mail->ErrorInfo}";

    }

}
else {
    // Handle the case where the database update was not successful
    echo "Failed to update the database.";
}