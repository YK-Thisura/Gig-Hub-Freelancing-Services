<?php
session_start();

if (!isset($_SESSION["seller_username"])) {
    header("Location: index.php"); 
    exit;
}

include('database.php');


$sellerIdentifier = $_SESSION["seller_username"]; 
$sellerSql = "SELECT * FROM sellerinformation WHERE displayName = '$sellerIdentifier'";
$sellerResult = mysqli_query($mysqli, $sellerSql);

if ($sellerResult) {
    $sellerRow = mysqli_fetch_assoc($sellerResult);

    if ($sellerRow) {
        $displayName = $sellerRow["displayName"];
    } else {
        echo "Seller not found";
        exit;
    }
} else {
    echo "Error: " . $sellerSql . "<br>" . mysqli_error($mysqli);
    exit;
}

$inProgressOrdersSql = "SELECT * FROM orders WHERE seller_username = '$displayName' AND project_status = 'in progress'";
$inProgressOrdersResult = mysqli_query($mysqli, $inProgressOrdersSql);

$inProgressOrderCount = mysqli_num_rows($inProgressOrdersResult);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["upload"])) {
    $orderId = $_POST['order_id'];

    $uploadDirectory = "Files/"; 

    if (!file_exists($uploadDirectory)) {
        mkdir($uploadDirectory, 0777, true);
    }

    $fileName = basename($_FILES["file_upload"]["name"]);
    $targetFilePath = $uploadDirectory . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    $allowTypes = array('jpg', 'png', 'jpeg', 'gif', 'pdf', 'rar', 'zip'); 
    if (in_array($fileType, $allowTypes)) {
        
        if (move_uploaded_file($_FILES["file_upload"]["tmp_name"], $targetFilePath)) {
            $currentTimestamp = date('Y-m-d H:i:s');
            $updateOrderSql = "UPDATE orders 
                               SET file_path = '$targetFilePath', 
                                   project_status = 'completed', 
                                   completed_timestamp = NOW(),
                                   notification_status= 0 
                               WHERE id = $orderId";
            $updateOrderResult = mysqli_query($mysqli, $updateOrderSql);

            if (!$updateOrderResult) {
                echo "Error updating order: " . mysqli_error($mysqli);
            } else {
                echo '<script type="text/javascript">
                alert("Project Uploaded successfully!\nPlease wait until the client accepts your project");
                window.location = "seller_dashboard.php";
                      </script>';
                exit; 
            }
        } else {
            echo "Error uploading file.";
        }
    } else {
        echo "Invalid file type. Allowed types are: " . implode(', ', $allowTypes);
    }
}

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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <link rel="stylesheet" href="styles.css">

    <style>
         body {
            margin-left: 40px;
            margin-right: 40px;
            background-color: #f4f4f4; 
        }

        .square{
            width: 100%;
            height: 43%;
            overflow: auto; 
            background-color:white;
            padding: 20px;
            border-radius: 20px;
        }

        .square1{
            width: 100%;
            height: 7%;
            background-color:white;
            padding: 20px;
            border-radius: 20px;
        }

        .countdown {
            font-size: 18px;
            font-weight: bold;
            color: #007bff; 
        }

        .custom-form {
            margin-top: 20px;
        }

        .custom-form input[type="file"] {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background-color: #f9f9f9;
        }

        .custom-form .form-text {
            font-size: 14px;
            color: #777;
        }

        .custom-form button {
            background-color: darkblue; 
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .custom-form button:hover {
            background-color: blue; 
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
            <div class="custom-square">
                <h5 class="square1">In Progress Orders : <?php echo $inProgressOrderCount; ?></h5>
                <?php
                while ($row = mysqli_fetch_assoc($inProgressOrdersResult)) {
                    // Display order details here
                    echo '<div class="square">';
                    echo '<p style="font-weight: bolder;">Order ID: #' . $row['id'] . '</p>';
                    echo '<p style="font-style: italic; font-weight: bolder; font-size:18px;">' . $row['sub_category'] .' -> '. $row['package'] . ' package</p>';
                    echo '<p><strong>Package Description:</strong> ' . $row['package_description'] . '</p>';
                    echo '<p><strong>Package Price:</strong> $' . $row['package_price'] . '</p>';
                    echo '<p><strong>Requirement:</strong> "'  . $row['message'] . '"</p>';
                    echo '<strong>Package Delivery Remaining Time:</strong> <span id="countdown_' . $row['id'] . '" class="countdown"></span></p>';

                    echo '<form action="" method="post" enctype="multipart/form-data" class="custom-form">';
                    echo '<input type="hidden" name="order_id" value="' . $row['id'] . '">'; 
                    echo '<input type="file" name="file_upload" accept=".rar, .zip" aria-describedby="fileHelp" required><br><br>';
                    echo '<small id="fileHelp" class="form-text text-muted">Max file size: 1GB. Allowed types: .rar, .zip</small><br>';
                    echo '<button type="submit" name="upload" class="custom-button">Complete Project</button>';
                    echo '</form>';

                    echo '</div>';

                    if ($inProgressOrderCount > 1) {
                        echo '<hr>';
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>



<script>
    <?php
    // Reset the result set to the beginning for the JavaScript code
    mysqli_data_seek($inProgressOrdersResult, 0);
    ?>

    const countdownData = [
        <?php
        while ($row = mysqli_fetch_assoc($inProgressOrdersResult)) {
            // Output JavaScript code for countdown
            $acceptedTimestamp = strtotime($row['accepted_timestamp']); // Get timestamp
            $packageDeliveryTime = strtotime("+{$row['package_delivery_time']} days", $acceptedTimestamp); // Calculate delivery time
            $currentTime = time(); // Get current time

            // Calculate remaining time (make sure it's not negative)
            $remainingTime = max(0, $packageDeliveryTime - $currentTime);

            echo "{ id: " . $row['id'] . ", remainingTime: " . $remainingTime . " },";
        }
        ?>
    ];

    function updateCountdown() {
        countdownData.forEach(data => {
            const countdownElement = document.getElementById(`countdown_${data.id}`);
            const days = Math.floor(data.remainingTime / (24 * 60 * 60));
            const hours = Math.floor((data.remainingTime % (24 * 60 * 60)) / (60 * 60));

            // Format the output with days and hours only
            countdownElement.innerHTML = days + " days, " + hours + " hours";
            data.remainingTime -= 1; // Subtract one second
        });
    }

    // Initial call to set up countdowns
    updateCountdown();

    // Update countdown every second
    setInterval(updateCountdown, 1000);
</script>





</body>

</html>
