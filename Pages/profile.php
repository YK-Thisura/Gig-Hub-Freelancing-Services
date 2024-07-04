<?php
session_start();

// Include the database connection
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

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    $userDetailsQuery = "SELECT * FROM user WHERE username = '$username'";
    $userDetailsResult = mysqli_query($mysqli, $userDetailsQuery);

    if ($userDetailsResult && $userDetails = mysqli_fetch_assoc($userDetailsResult)) {
        $email = $userDetails['email'];

        // Display user details
        echo '<h2>Welcome, ' . $username . '!</h2>';
        echo '<p>' . $email . '</p>';
    } else {
        // Handle database query error or no results
        echo 'Error fetching user details: ' . mysqli_error($mysqli);
    }
}

$pendingOrdersSql = "SELECT * FROM orders WHERE username = '$username' AND project_status = 'in progress' AND notification_status = 0";
$pendingOrdersResult = mysqli_query($mysqli, $pendingOrdersSql);

$completedOrdersSql = "SELECT * FROM orders WHERE username = '$username' AND project_status = 'completed' AND notification_status = 0";
$completedOrdersResult = mysqli_query($mysqli, $completedOrdersSql);

$inProgressOrderCount = mysqli_query($mysqli, "SELECT COUNT(*) FROM orders WHERE username = '$username' AND project_status = 'in progress'")->fetch_row()[0];
$completedProjectsCount = mysqli_query($mysqli, "SELECT COUNT(*) FROM orders WHERE username = '$username' AND project_status = 'completed'")->fetch_row()[0];


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
@import url("https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600;700&display=swap");

        body {
            margin-left: 40px;
            /* Adjust as needed */
            margin-right: 40px;
            /* Adjust as needed */
            background-color:#f4f4f4;
        }

        h2{
            padding-top: 120px;
        }

        .custom-square {
            width: 250px;
            background-color: white;
            padding: 20px;
            min-height: 100px;
            overflow: auto;
            text-align: center;
            margin-top: 20px; /* Add margin-top to space out the squares */
            border-radius: 20px;
        }

        .custom-square:hover {
            box-shadow: 0 0 10px rgba(0, 0, 139, 0.5); /* Dark blue box-shadow */
            cursor: pointer;
        }

        .dropdown-menu {
            right: -50px !important; /* Increase this value for more adjustment to the left */
            left: auto !important;
        }
       
       
    </style>
</head>

<body style="height: 2000px;">

<nav class="navbar fixed-top navbar-expand-sm navbar-dark" style="background-color:white">
        <div class="container-fluid">
            <a href="index.php" class="navbar-brand mb-0 h1">
                <img class="d-inline-block align-center me-2" src="logo1.jpg" width="200" height="auto">
            </a>

            <button type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" class="navbar-toggler"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    
                    
                <li class="nav-item dropdown">
    <a href="#" class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="color: darkblue;">
        <?php
        $totalNotifications = mysqli_num_rows($pendingOrdersResult) + mysqli_num_rows($completedOrdersResult);

        if ($totalNotifications > 0) {
            echo '<i class="fa fa-bell"></i> ' . $totalNotifications;
        } else {
            echo '<i class="fa fa-bell"></i>';
        }
        ?>
    </a>
    <?php
    $totalNotifications = mysqli_num_rows($pendingOrdersResult) + mysqli_num_rows($completedOrdersResult);

    if ($totalNotifications > 0) {
        // Display notifications if there are any
        $pendingOrdersArray = mysqli_fetch_all($pendingOrdersResult, MYSQLI_ASSOC);
        $completedOrdersArray = mysqli_fetch_all($completedOrdersResult, MYSQLI_ASSOC);

        echo '<div class="dropdown-menu" aria-labelledby="navbarDropdown" style="width: 450px; overflow-y: auto;">';

        foreach ($pendingOrdersArray as $pendingOrder) {
            echo '<div class="dropdown-item">';
            if (array_key_exists('id', $pendingOrder)) {
                echo '<span>Order ID: #' . $pendingOrder['id'] . ' <a href="project_client.php?id=' . $pendingOrder['id'] . '"><ul>Your order has been accepted, the seller is working on it</ul></a> </span>';
                // Set notification_status to 1 after displaying
                mysqli_query($mysqli, "UPDATE orders SET notification_status = 1 WHERE id = " . $pendingOrder['id']);
            } else {
                echo '<span>Your order has been accepted, the seller is working on it</span>';
            }
            echo '</div>';
        }
        
        // Display "Completed" notifications
        foreach ($completedOrdersArray as $completedOrder) {
            echo '<div class="dropdown-item">';
            if (array_key_exists('id', $completedOrder)) {
                echo '<span>Order ID: #' . $completedOrder['id'] . ' <a href="project_client.php?id=' . $completedOrder['id'] . '"><ul>Your order is completed</ul></a> </span>';
                // Set notification_status to 1 after displaying
                mysqli_query($mysqli, "UPDATE orders SET notification_status = 1 WHERE id = " . $completedOrder['id']);
            } else {
                echo '<span>Your order is completed</span>';
            }
            echo '</div>';
        }

    }
    ?>
</li>



                    

                    <li class="nav-item">
                        <a href="index.php?logout=true" class="nav-link" style="color: darkblue;">
                            <i class="fa fa-sign-out"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


    <div class="container">
    <div class="row">
            <div class="col-lg-4">
                <a href="project_clientProgress.php">
                <div class="custom-square">
                    <h5>Ongoing Projects <br><br> <?php echo $inProgressOrderCount; ?></h5>
                </div>
                </a>
            </div>

        <div class="col-lg-4">
            <div class="custom-square">
                <a href="project_clientCompleted.php" style="cursor:pointer;">
                <h5>Completed Orders <br><br> <?php echo $completedProjectsCount; ?> </h5>
                </a>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="custom-square">
                <a href="index.php" style="cursor:pointer;"> <h5>Make Orders <br><br></h5></a>
            </div>
        </div>
    </div>
</div>


    







    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
   

</body>
</html>