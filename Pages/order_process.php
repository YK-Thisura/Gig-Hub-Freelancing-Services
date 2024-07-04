<?php
session_start();
include('database.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data from the form
    $selectedGigId = $_POST['gig_id'];
    $selectedPackage = $_POST['package'];
    $message = mysqli_real_escape_string($mysqli, $_POST['message']);
    

   // Retrieve gig and package details from the database
    $gigDetailsQuery = "SELECT g.*, s.displayName as seller_username, g.sub_category
                        FROM giglistings g
                        JOIN sellerinformation s ON g.seller_username = s.displayName
                        WHERE g.id = ?";

    
    $stmt = mysqli_prepare($mysqli, $gigDetailsQuery);
    mysqli_stmt_bind_param($stmt, "i", $selectedGigId);
    
    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);
        if ($gigDetails = mysqli_fetch_assoc($result)) {
            // Get gig details
            $packageDescription = $gigDetails[$selectedPackage . '_description'];
            $packageDeliveryTime = $gigDetails[$selectedPackage . '_delivery_time'];
            $packagePrice = $gigDetails[$selectedPackage . '_price'];

            $projectStatus = 'pending';

            $insertOrderQuery = "INSERT INTO orders 
        (gig_id, package, message,  username, seller_username, sub_category, package_description, package_delivery_time, package_price, project_status)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($mysqli, $insertOrderQuery);
mysqli_stmt_bind_param($stmt, "isssssssss", 
    $selectedGigId, 
    $selectedPackage, 
    $message, 
    $_SESSION['username'], 
    $gigDetails['seller_username'], 
    $gigDetails['sub_category'], 
    $packageDescription, 
    $packageDeliveryTime, 
    $packagePrice, 
    $projectStatus);


            if (mysqli_stmt_execute($stmt)) {
                // Order successfully inserted
                echo '<script type="text/javascript">
                        window.onload = function() {
                            alert("Please wait until the seller accepts your order.");
                            window.location = "profile.php";
                        }
                      </script>';
                exit();
            } else {
                // Error inserting order
                echo "Error: " . mysqli_error($mysqli);
            }
        } else {
            // Unable to fetch gig details
            echo "Error: Unable to fetch gig details.";
        }
    } else {
        // Error executing query
        echo "Error: " . mysqli_error($mysqli);
    }

    // Close the statement
    mysqli_stmt_close($stmt);
} else {
    // Invalid request method
    header("Location: index.php"); // Redirect to an error page
    exit();
}
?>
