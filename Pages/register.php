<?php

//start zeon
$mysqli = require __DIR__ . "/database.php";


// Handle registration form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $username = $_POST["username"];
    //$password = password_hash($_POST["password"], PASSWORD_BCRYPT);
    $password = $_POST["password"];
    $password_confirmation = $_POST["password_confirmation"];

    // Validate inputs
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die('<script type="text/javascript">
            alert("Valid email is required");
            window.location = "index.php";
            </script>');}

    if (empty($username)) {
        die("Username is required");
    }

    // if (empty($password) || strlen($password) < 8) {
    //     die("Password must be at least 8 characters");
    // }

    // if (!preg_match("/[a-z]/i", $password)) {
    //     die("Password must contain at least one letter");
    // }

    // if (!preg_match("/[0-9]/", $password)) {
    //     die("Password must contain at least one number");
    }

    if ($password !== $password_confirmation) {
        die('<script type="text/javascript">
                alert("Password must match");
                window.location = "index.php";
              </script>');
    }

    // Hash the password
    $password_hash = password_hash($password, PASSWORD_BCRYPT);

    $activation_token = bin2hex(random_bytes(16));

    $activation_token_hash = hash("sha256", $activation_token);

    $sql = "INSERT INTO user (username, email, password_hash, account_activation_hash)
        VALUES (?, ?, ?, ?)";
        
    $stmt = $mysqli->stmt_init();

    if ( ! $stmt->prepare($sql)) {
        die("SQL error: " . $mysqli->error);
    }

$stmt->bind_param("ssss",
                  $_POST["username"],
                  $_POST["email"],
                  $password_hash,
                  $activation_token_hash);
                  
if ($stmt->execute()) {

    $mail = require __DIR__ . "/mailer.php";

    $mail->setFrom("GigHubPvt@gmail.com");
    $mail->addAddress($_POST["email"]);
    $mail->Subject = "Account Activation";
    $mail->Body = <<<END
    <p>Hello {$_POST["username"]},</p>

    <p>Welcome to GigHub! You're one step away from activating your account.</p>

    <p>Please click the following link to activate your account:</p>

    <a href="http://localhost/finalProjectGighub/activate-account.php?token=$activation_token">Activate Your Account</a>

    <p>If you did not create an account on GigHub, you can safely ignore this email.</p>

    <p>Thank you,<br>GigHub Team</p>
    END;


    try {

        $mail->send();

    } catch (Exception $e) {

        echo "Message could not be sent. Mailer error: {$mail->ErrorInfo}";
        exit;

    }

    header("Location: signup-success.html");
    exit;
    
} else {
    
    if ($mysqli->errno === 1062) {
        die('<script type="text/javascript">
                alert("Email already taken");
                window.location = "index.php";
              </script>');
    } else {
        die($mysqli->error . " " . $mysqli->errno);
    }
    
}

    if (mysqli_query($mysqli, $sql)) {
        // Registration successful, set user information in the session
        session_start();
        $_SESSION["username"] = $username;

        // Redirect the user to the home page
        header("Location: index.php");
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($mysqli);
    }

//end zeon

?>
