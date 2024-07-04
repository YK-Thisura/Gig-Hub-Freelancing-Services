<?php
session_start();

if (!isset($_SESSION["username"])) {
    header("Location: index.php");
    exit;
}

// Include the database connection
include('database.php');

$username = $_SESSION['username'];

$inProgressOrdersSql = "SELECT * FROM orders WHERE username = '$username' AND project_status = 'in progress' ORDER BY id DESC";
$inProgressOrdersResult = mysqli_query($mysqli, $inProgressOrdersSql);

$inProgressOrderCount = mysqli_num_rows($inProgressOrdersResult);

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

        .custom-button {
            background-color: darkblue; 
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .custom-button:hover {
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


                    echo '</div>';

                    if ($inProgressOrderCount > 1) {
                        echo '<hr>';
                    }

                }
                ?>
<br>
                <a href="profile.php">
                <button type="submit" name="ok" class="custom-button"> OK </button>
                <br><br>
                </a>
            </div>
        </div>
    </div>
</div>







</body>

</html>
