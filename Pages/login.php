<?php
//start zeon 
// Require the database connection
$mysqli = require __DIR__ . "/database.php";
//end zeon 

// Handle login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    //start zeon 
    // Check in the "user" table
    $userSql = "SELECT * FROM user WHERE email = '$email'";
    $userResult = mysqli_query($mysqli, $userSql);

    // Check in the "sellerinformation" table
    $sellerSql = "SELECT * FROM sellerinformation WHERE email = '$email'";
    $sellerResult = mysqli_query($mysqli, $sellerSql);

    $adminSql = "SELECT * FROM admins WHERE email = '$email'";
    $adminResult = mysqli_query($mysqli, $adminSql);

    if ($userResult && $sellerResult && $adminResult) {
        $userRow = mysqli_fetch_assoc($userResult);
        $sellerRow = mysqli_fetch_assoc($sellerResult);
        $adminRow = mysqli_fetch_assoc($adminResult);

        // Check if the user exists and the password is correct
        if ($userRow && password_verify($password, $userRow["password_hash"])) {
            session_start();
            // Successful login for a user
            $_SESSION["username"] = $userRow["username"];
            header("Location: index.php");
            exit;
        }
        // Check if the seller exists and the password is correct
        elseif ($sellerRow && password_verify($password, $sellerRow["password"])) {
            // Successful login for a seller
            session_start();
            $_SESSION["seller_username"] = $sellerRow["displayName"];
            header("Location: seller_dashboard.php");
            exit;
        }
        // Check if the admin exists and the password is correct
        elseif ($adminRow && password_verify($password, $adminRow["password"])) {
            // Successful login for an admin
            session_start();
            header("Location: admin.php");
            exit;
        } else {
            echo '<script type="text/javascript">
                alert("Invalid email or password");
                window.location = "index.php";
                      </script>';
        }
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($mysqli);
    }
}
?>
