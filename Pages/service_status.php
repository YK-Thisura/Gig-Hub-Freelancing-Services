<?php
session_start();

// Include database connection
include('database.php');

// Check for logout logic
if (isset($_GET["logout"])) {
    // Unset all session variables
    $_SESSION = array();
    
    // Destroy the session
    session_destroy();
    
    // Redirect to the home page
    header("Location: index.php");
    exit;
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if "Approve Gig" button is clicked
    if (isset($_POST['approve_gig'])) {
        // Update approval status to "approved"
        $gigId = $_POST['gig_id'];
        $updateQuery = "UPDATE giglistings SET approval_status = 'approved' WHERE id = $gigId";
        mysqli_query($mysqli, $updateQuery);

        // Redirect to admin.php
        header("Location: admin.php");
        exit;
    } elseif (isset($_POST['decline_gig'])) {
        // Update approval status to "declined"
        $gigId = $_POST['gig_id'];
        $updateQuery = "UPDATE giglistings SET approval_status = 'declined' WHERE id = $gigId";
        mysqli_query($mysqli, $updateQuery);

        // Redirect to admin.php
        header("Location: admin.php");
        exit;
    }
}

// Continue with other PHP code
// Rest of your PHP code
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GigHub - Service Status</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,0,0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"  />
    <link rel="stylesheet" href="styles.css">

    <style>
        @import url("https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600;700&display=swap");

        body {
            margin-left: 40px;
            /* Adjust as needed */
            margin-right: 40px;
            /* Adjust as needed */
            background-color: #f4f4f4;
        }

        .gig-details {
            max-width: 800px;
            margin-top: 120px;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

                .cover-photo {
            max-width: 100%;
            height: auto;
            margin-bottom: 20px;
        }

        .btn-approve, .btn-decline {
            margin-top: 20px;
        }
    </style>
</head>

<body style="height: 2000px;">

<nav class="navbar fixed-top navbar-expand-sm navbar-dark" style="background-color:white">
    <div class="container-fluid">
        <a href="index.php" class="navbar-brand mb-0 h1">
            <img class="d-inline-block align-center me-2" src="logo1.jpg" width="200" height="auto">
        </a>
    </div>
</nav>

<div class="container gig-details">
    <?php
    // Get gig details based on the gig ID passed in the URL
    if (isset($_GET['gig_id'])) {
        $gigId = $_GET['gig_id'];
        $query = "SELECT * FROM giglistings WHERE id = $gigId";
        $result = mysqli_query($mysqli, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $gigDetails = mysqli_fetch_assoc($result);

            // Display cover photo
            echo '<img class="cover-photo" src="' . $gigDetails['gig_cover_photo'] . '" alt="Cover Photo">';

            // Display gig details

            echo '<p><strong>Gig Title:</strong> ' . $gigDetails['gig_title'] . '</p><br> ';
            echo '<p><strong>Description:</strong></p>';
            echo '<div>' . nl2br($gigDetails['gig_description']) . '</div> <br>';
            echo '<p><strong>Service Category:</strong> ' . $gigDetails['service_category'] . '</p> <br>';
            echo '<p><strong>Sub Category:</strong> ' . $gigDetails['sub_category'] . '</p><br>';
            echo '<p><strong>Keywords:</strong> ' . $gigDetails['keywords'] . '</p><br>';
            
           // Table for Description, Delivery Time, and Price
           echo '<p><strong>Scope & Pricing:</strong> </p>';
           echo '<div style="margin-top: 20px;">';
           echo '<table style="width:100%; height:300px; border-collapse: collapse; margin-bottom: 20px;">';
           echo '<thead>';
           echo '<tr style="text-align: center; border: 1px solid #ddd;">';
           echo '<th style="border: 1px solid #ddd;"></th>';
           echo '<th style="border: 1px solid #ddd;">Basic</th>';
           echo '<th style="border: 1px solid #ddd;">Standard</th>';
           echo '<th style="border: 1px solid #ddd;">Premium</th>';
           echo '</tr>';
           echo '</thead>';
           echo '<tbody style="text-align: center;">';
           echo '<tr>';
           echo '<td style="font-weight:bold; border: 1px solid #ddd;">Description</td>';
           echo '<td style="border: 1px solid #ddd;">' . nl2br($gigDetails['basic_description']) . '</td>';
           echo '<td style="border: 1px solid #ddd;">' . nl2br($gigDetails['standard_description']) . '</td>';
           echo '<td style="border: 1px solid #ddd;">' . nl2br($gigDetails['premium_description']) . '</td>';
           echo '</tr>';
           echo '<tr>';
           echo '<td style="font-weight:bold; border: 1px solid #ddd;">Delivery Time</td>';
           echo '<td style="border: 1px solid #ddd;">' . $gigDetails['basic_delivery_time'] . ' day(s)</td>';
           echo '<td style="border: 1px solid #ddd;">' . $gigDetails['standard_delivery_time'] . ' day(s)</td>';
           echo '<td style="border: 1px solid #ddd;">' . $gigDetails['premium_delivery_time'] . ' day(s)</td>';
           echo '</tr>';
           echo '<tr>';
           echo '<td style="font-weight:bold; border: 1px solid #ddd;">Price</td>';
           echo '<td style="border: 1px solid #ddd;">$' . $gigDetails['basic_price'] . '</td>';
           echo '<td style="border: 1px solid #ddd;">$' . $gigDetails['standard_price'] . '</td>';
           echo '<td style="border: 1px solid #ddd;">$' . $gigDetails['premium_price'] . '</td>';
           echo '</tr>';
           echo '</tbody>';
           echo '</table>';
           echo '</div><br>';
           
          // Display the form with buttons
          echo '<form method="post">';
          echo '<input type="hidden" name="gig_id" value="' . $gigId . '">';

          // Approve and Decline buttons
          echo '<button type="submit" name="approve_gig" class="btn btn-success btn-approve">Approve Gig</button>';
          echo '<button type="submit" name="decline_gig" class="btn btn-danger btn-decline" style="margin-left: 20px;">Decline Gig</button>';
          echo '</form>';
      } else {
          echo '<p>No gig found with the specified ID.</p>';
      }
  } else {
      echo '<p>No gig ID provided in the URL.</p>';
  }
  ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</body>
</html>
