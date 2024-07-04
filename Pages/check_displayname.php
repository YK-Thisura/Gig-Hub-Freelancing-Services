<?php

$mysqli = require __DIR__ . "/database.php";


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $displayName = $_POST['displayName'];

    // Perform a query to check if the display name is already in use
    $query = "SELECT COUNT(*) AS count FROM sellerinformation WHERE displayName = '$displayName'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $count = $row['count'];

        if ($count > 0) {
            echo '<span style="color: red;">Display name not available. Please choose a different one.</span>';
        } else {
            echo '<span style="color: green;">Display name is available!</span>';
        }
    } else {
        echo 'Error checking display name availability.';
    }
}
?>
