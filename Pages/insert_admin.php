<?php

include('database.php');


$hashedPassword = password_hash('admin', PASSWORD_DEFAULT);

$sql = "INSERT INTO `admins` (`email`, `password`) VALUES ('admin@gighub.com', '$hashedPassword')";

$result = mysqli_query($mysqli, $sql);

if (!$result) {
    echo "Error: " . mysqli_error($mysqli);
} else {
    echo "Admin account inserted successfully!";
}

mysqli_close($mysqli);
?>
