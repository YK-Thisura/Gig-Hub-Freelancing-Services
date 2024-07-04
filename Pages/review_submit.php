<?php
session_start();

// Include the database connection
include('database.php');

mysqli_query($mysqli, "SET time_zone = 'Asia/Colombo'");


// Retrieve the username of the current user (you may need to adjust this based on your authentication mechanism)
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    // Retrieve values from the form
    $gigId = $_POST['gig_id'];
    $rating = $_POST['rating'];
    $reviewText = $_POST['review_text'];

    // Validate and sanitize input if necessary

    // Insert the review into the database
    $insertReviewQuery = "INSERT INTO reviews (gig_id, username, rating, review_text) 
                          VALUES ($gigId, '$username', $rating, '$reviewText')";
    $result = mysqli_query($mysqli, $insertReviewQuery);

    if ($result) {
        echo "Review submitted successfully!";
        // Redirect to the gig details page or another appropriate location
    } else {
        echo "Error submitting review: " . mysqli_error($mysqli);
    }
} else {
    // Redirect to an error page or another appropriate location
}

?>
