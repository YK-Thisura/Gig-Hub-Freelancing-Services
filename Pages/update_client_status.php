<?php
session_start();

if (!isset($_SESSION["username"])) {
    header("HTTP/1.1 401 Unauthorized");
    exit;
}

include('database.php');

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['id'])) {
    $orderID = $_GET['id'];

    // Update the client_status in the database
    $updateStatusQuery = "UPDATE orders SET client_status = 'done' WHERE id = ?";
    $stmt = $mysqli->prepare($updateStatusQuery);

    if ($stmt) {
        $stmt->bind_param("i", $orderID);
        if ($stmt->execute()) {
            echo 'Thank You For Trusting GigHub.' . "\nWe Always Try To Give Our Best." . "\nPlease Share Your Thoughts And Reviews On Exceptional Service!";
        } else {
            echo 'Error updating status: ' . $stmt->error;
        }
        $stmt->close();
    } else {
        echo 'Error preparing statement: ' . $mysqli->error;
    }
} else {
    header("HTTP/1.1 400 Bad Request");
    echo 'Invalid request parameters';
}

$mysqli->close();
?>
