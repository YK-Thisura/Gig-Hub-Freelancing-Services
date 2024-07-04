<?php
session_start();

// Check if the seller is logged in
if (!isset($_SESSION["seller_username"])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit;
}

include('database.php');


// Fetch the order ID from the URL parameter
if (isset($_GET['id'])) {
    $orderId = mysqli_real_escape_string($mysqli, $_GET['id']);

    // Fetch order details based on the order ID
    $orderSql = "SELECT * FROM orders WHERE id = '$orderId'";
    $orderResult = mysqli_query($mysqli, $orderSql);

    if ($orderResult) {
        $orderRow = mysqli_fetch_assoc($orderResult);

        if ($orderRow) {
            // Display relevant order details on the page
            $subcategory = $orderRow["sub_category"];
            $package = $orderRow["package"];
            $username = $orderRow["username"];
            $packageDescription = $orderRow["package_description"];
            $packageDeliveryTime = $orderRow["package_delivery_time"];
            $packagePrice = $orderRow["package_price"];
            $message = $orderRow["message"];

            // Now you can use these variables in your HTML to display the information
        } else {
            echo "Order not found";
        }
    } else {
        echo "Error: " . $orderSql . "<br>" . mysqli_error($mysqli);
    }
} else {
    echo "Order ID not provided in the URL";
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["accept_order"])) {
        // Update the project_status to "in progress" in the orders table
        $updateStatusSql = "UPDATE orders SET project_status = 'in progress', accepted_timestamp = NOW() WHERE id = '$orderId'";
        $updateStatusResult = mysqli_query($mysqli, $updateStatusSql);

        if (!$updateStatusResult) {
            echo "Error updating project status: " . mysqli_error($mysqli);
        }

        // Redirect to seller_dashboard.php
        header("Location: seller_dashboard.php");
        exit;
    } elseif (isset($_POST["decline_order"])) {
        // Update the project_status to "decline by seller" in the orders table
        $updateStatusSql = "UPDATE orders SET project_status = 'decline by the seller' WHERE id = '$orderId'";
        $updateStatusResult = mysqli_query($mysqli, $updateStatusSql);

        if (!$updateStatusResult) {
            echo "Error updating project status: " . mysqli_error($mysqli);
        }

        // Redirect to seller_dashboard.php
        header("Location: seller_dashboard.php");
        exit;
    }
}

// Close the database connection
mysqli_close($mysqli);
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GigHub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,0,0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"  />
    <link rel="stylesheet" href="styles.css">

    <style>
         body {
            margin-left: 40px;
            margin-right: 40px;
            background-color: #f4f4f4; 
        }

        .square{
            min-width: 50%;
            min-height: 50%;
            overflow: auto; 
            background-color:white;
            padding: 20px;
            border-radius: 20px;
            
        }
    </style>
</head>

<body>

<nav class="navbar fixed-top navbar-expand-sm navbar-dark" style="background-color:white">
        <div class="container-fluid">
            <a href="index.php" class="navbar-brand mb-0 h1">
                <img class="d-inline-block align-center me-2" src="logo1.jpg" width="200" height="auto">
            </a>
        </div>
    </nav>


    <div class="container" style="margin-top: 10%;">
    <div class="row">
        <div class="col-12">
            <div class="square">
                <p style="font-size:22px;"><strong><i><?php echo $subcategory; ?> -> <?php echo $package; ?> package</strong> / order from @<?php echo $username; ?> </i></p>
                <ul><p><strong>Description:</strong> <?php echo $packageDescription; ?></p>
                <p><strong>Delivery Time:</strong> <?php echo $packageDeliveryTime; ?> day(s)</p>
                <p><strong>Price:</strong> $<?php echo $packagePrice; ?></p>
                <p><strong>Client's Message:</strong> "<?php echo $message; ?>"</p></ul>
                <br>

                <form method="post">
              <button type="submit" name="accept_order" class="btn btn-success btn-approve" style="margin-left:3%;">Accept Order</button>
              <button type="submit" name="decline_order" class="btn btn-danger btn-decline" style="margin-left: 20px;">Decline Order</button>
            </form>
        </div>
        </div>
    </div>
    </div>


    <script>
    </script>
</body>

</html>
