<?php
session_start();

// Check if the seller is logged in
if (!isset($_SESSION["seller_username"])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit;
}

include('database.php');


// Fetch seller details based on the session variable
$sellerUsername = $_SESSION["seller_username"];
$sellerSql = "SELECT * FROM sellerinformation WHERE displayName = '$sellerUsername'";
$sellerResult = mysqli_query($mysqli, $sellerSql);

if ($sellerResult) {
    $sellerRow = mysqli_fetch_assoc($sellerResult);

    if ($sellerRow) {
        // Display seller details on the page
        $service = $sellerRow["service"];
        $skills = explode(", ", $sellerRow["skills"]);
    }
}

// Process form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $gigTitle = mysqli_real_escape_string($mysqli, $_POST["gigTitle"]);
    $gigDescription = mysqli_real_escape_string($mysqli, $_POST["gigDescription"]);
    $serviceCategory = mysqli_real_escape_string($mysqli, $_POST["service"]);
    $subCategory = mysqli_real_escape_string($mysqli, $_POST["selectedSkill"]);
    $keywords = mysqli_real_escape_string($mysqli, $_POST["keywords"]);
    $basicDescription = mysqli_real_escape_string($mysqli, $_POST["basicDescription"]);
    $standardDescription = mysqli_real_escape_string($mysqli, $_POST["standardDescription"]);
    $premiumDescription = mysqli_real_escape_string($mysqli, $_POST["premiumDescription"]);
    $basicDeliveryTime = intval($_POST["basicDeliveryTime"]);
    $standardDeliveryTime = intval($_POST["standardDeliveryTime"]);
    $premiumDeliveryTime = intval($_POST["premiumDeliveryTime"]);
    $basicPrice = floatval($_POST["basicPrice"]);
    $standardPrice = floatval($_POST["standardPrice"]);
    $premiumPrice = floatval($_POST["premiumPrice"]);

    // Validate and sanitize form data as needed

    // Handle file upload for gig cover photo
    $targetDirectory = "cover_photos/"; // Set your upload directory
    $gigCoverPhoto = $targetDirectory . basename($_FILES["gigCoverPhoto"]["name"]);

    // ...

    // Move the uploaded file to the target directory
    if (move_uploaded_file($_FILES["gigCoverPhoto"]["tmp_name"], $gigCoverPhoto)) {
        // Modify your existing gig insertion query in process_gig.php
        $approvalStatus = 'pending';
        // Insert gig data into the database
        $insertSql = "INSERT INTO giglistings (
            seller_username,
            gig_title,
            gig_description,
            service_category,
            sub_category,
            keywords,
            basic_description,
            standard_description,
            premium_description,
            basic_delivery_time,
            standard_delivery_time,
            premium_delivery_time,
            basic_price,
            standard_price,
            premium_price,
            gig_cover_photo,
            approval_status
        ) VALUES (
            '$sellerUsername',
            '$gigTitle',
            '$gigDescription',
            '$serviceCategory',
            '$subCategory',
            '$keywords',
            '$basicDescription',
            '$standardDescription',
            '$premiumDescription',
            $basicDeliveryTime,
            $standardDeliveryTime,
            $premiumDeliveryTime,
            $basicPrice,
            $standardPrice,
            $premiumPrice,
            '$gigCoverPhoto',
            '$approvalStatus'
        )";

        // Execute the query and handle any errors
        $result = mysqli_query($mysqli, $insertSql);

        // Check if the query was successful and redirect accordingly
        if ($result) {
            // Gig inserted successfully
            header("Location: seller_dashboard.php"); // Redirect to success page or wherever you want
            exit;
        } else {
            // Handle errors
            echo "Error: " . mysqli_error($mysqli);
        }
    } else {
        // Handle file upload error
        echo "File upload failed.";
    }
}

// Close the database connection
mysqli_close($mysqli);
?>
