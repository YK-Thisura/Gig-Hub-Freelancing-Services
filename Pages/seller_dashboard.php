<?php
session_start();

if (!isset($_SESSION["seller_username"])) {
    header("Location: index.php"); 
    exit;
}

include('database.php');


$sellerIdentifier = $_SESSION["seller_username"]; 
$sellerSql = "SELECT * FROM sellerinformation WHERE displayName = '$sellerIdentifier' OR email = '$sellerIdentifier'";
$sellerResult = mysqli_query($mysqli, $sellerSql);

if ($sellerResult) {
    $sellerRow = mysqli_fetch_assoc($sellerResult);

    if ($sellerRow) {
        $displayName = $sellerRow["displayName"];
        $country = $sellerRow["country"];
        $description = $sellerRow["description"];
        $service = $sellerRow["service"];
        $skills = $sellerRow["skills"];
        $education = $sellerRow["education"];
        $email = $sellerRow["email"];
        $password = $sellerRow["password"];
        $phoneNumber = $sellerRow["phoneNumber"];

    } else {
        echo "Seller not found";
    }
} else {
    echo "Error: " . $sellerSql . "<br>" . mysqli_error($mysqli);
}

$activeGigsSql = "SELECT * FROM giglistings WHERE seller_username = '$displayName' AND approval_status = 'approved'";
$activeGigsResult = mysqli_query($mysqli, $activeGigsSql);

$pendingGigsSql = "SELECT * FROM giglistings WHERE seller_username = '$displayName' AND approval_status = 'pending'";
$pendingGigsResult = mysqli_query($mysqli, $pendingGigsSql);

$declinedGigsSql = "SELECT * FROM giglistings WHERE seller_username = '$displayName' AND approval_status = 'declined'";
$declinedGigsResult = mysqli_query($mysqli, $declinedGigsSql);

$approvedGigCount = mysqli_query($mysqli, "SELECT COUNT(*) FROM giglistings WHERE seller_username = '$displayName' AND approval_status = 'approved'")->fetch_row()[0];

$pendingGigCount = mysqli_query($mysqli, "SELECT COUNT(*) FROM giglistings WHERE seller_username = '$displayName' AND approval_status = 'pending'")->fetch_row()[0];

$declinedGigCount = mysqli_query($mysqli, "SELECT COUNT(*) FROM giglistings WHERE seller_username = '$displayName' AND approval_status = 'declined'")->fetch_row()[0];


$pendingOrdersSql = "SELECT * FROM orders WHERE seller_username = '$displayName' AND project_status = 'pending'";
$pendingOrdersResult = mysqli_query($mysqli, $pendingOrdersSql);

$pendingOrderCount = mysqli_num_rows($pendingOrdersResult);

$ongoingProjectsCount = mysqli_query($mysqli, "SELECT COUNT(*) FROM orders WHERE seller_username = '$displayName' AND project_status = 'in progress'")->fetch_row()[0];
$completedProjectsCount = mysqli_query($mysqli, "SELECT COUNT(*) FROM orders WHERE seller_username = '$displayName' AND project_status = 'completed'")->fetch_row()[0];

$totalEarningsSql = "SELECT SUM(package_price) AS total_earnings FROM orders WHERE seller_username = '$displayName' AND client_status = 'done'";
$totalEarningsResult = mysqli_query($mysqli, $totalEarningsSql);
$totalEarnings = mysqli_fetch_assoc($totalEarningsResult)['total_earnings'];



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["new_description"])) {
        $newDescription = mysqli_real_escape_string($mysqli, $_POST["new_description"]);

        $updateDescriptionSql = "UPDATE sellerinformation SET description = '$newDescription' WHERE displayName = '$sellerUsername'";
        $updateDescriptionResult = mysqli_query($mysqli, $updateDescriptionSql);

        if (!$updateDescriptionResult) {
            echo "Error updating description: " . mysqli_error($mysqli);
        }
    }

    if (isset($_POST["new_email"])) {
        $newEmail = mysqli_real_escape_string($mysqli, $_POST["new_email"]);

        $updateEmailSql = "UPDATE sellerinformation SET email = '$newEmail' WHERE displayName = '$sellerUsername'";
        $updateEmailResult = mysqli_query($mysqli, $updateEmailSql);

        if (!$updateEmailResult) {
            echo "Error updating email: " . mysqli_error($mysqli);
        }
    }

    if (isset($_POST["new_password"])) {
        $newPassword = mysqli_real_escape_string($mysqli, $_POST["new_password"]);

        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        $updatePasswordSql = "UPDATE sellerinformation SET password = '$hashedPassword' WHERE displayName = '$sellerUsername'";
        $updatePasswordResult = mysqli_query($mysqli, $updatePasswordSql);

        if (!$updatePasswordResult) {
            echo "Error updating password: " . mysqli_error($mysqli);
        }
    }

    if (isset($_POST["new_phone_number"])) {
        $newPhoneNumber = mysqli_real_escape_string($mysqli, $_POST["new_phone_number"]);

        $updatePhoneNumberSql = "UPDATE sellerinformation SET phoneNumber = '$newPhoneNumber' WHERE displayName = '$sellerUsername'";
        $updatePhoneNumberResult = mysqli_query($mysqli, $updatePhoneNumberSql);

        if (!$updatePhoneNumberResult) {
            echo "Error updating phone number: " . mysqli_error($mysqli);
        }
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
    <link rel="stylesheet" href="styles.css">

<style>
@import url("https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600;700&display=swap");

        body {
           
            background-color: #f2f2f2;
        }

        .square {
    width: 450px;
    background-color: white;
    padding: 20px;
    min-height: 200px;
    overflow: auto; 
    border-radius: 10px;

}

.square1 {
    width: 450px;
    background-color: white;
    padding: 50px;
    height: 200px;
    text-align: center;
    border-radius: 10px;
    margin-left: 10px;

}

.square1 h5, .square1 button {
    margin: 0; 
}

.square1 button {
    background-color: darkblue;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s; 
}

.square1 button:hover {
    background-color: blue; 
}

.square * {
    box-sizing: border-box;
}

        .welcome-container {
            text-align: left;
            margin-top: 120px;
            margin-bottom: none;
        }

        .welcome-message {
            color: darkblue;
            font-size: 24px;
        }

        .gig-container {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .gig-container img {
            width: 200px;
            height: auto;
            border-radius: 10px;
            border: 1px solid darkblue;
            margin-right: 10px;
        }

        .gig-container p {
            margin: 0;
        }

        .custom-square {
            width: 60%;
            background-color: white;
            padding: 20px;
            min-height: 100px;
            overflow: auto;
            text-align: center;
            margin-top: 20px; 
            border-radius: 20px;
        }

        .custom-square:hover {
            box-shadow: 0 0 10px rgba(0, 0, 139, 0.5); 
            cursor: pointer;
        }

        .dropdown-menu {
            right: -50px !important; 
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
        <i class="fa fa-bell"></i>
        <?php
        if ($pendingOrderCount > 0) {
            echo $pendingOrderCount;
        }
        ?>
    </a>
    <?php
    if ($pendingOrderCount > 0) {
        $pendingOrdersArray = mysqli_fetch_all($pendingOrdersResult, MYSQLI_ASSOC);

        echo '<div class="dropdown-menu" aria-labelledby="navbarDropdown" style="width: 450px; overflow-y: auto;">';
        foreach ($pendingOrdersArray as $pendingOrder) {
            if (array_key_exists('id', $pendingOrder) && array_key_exists('package_description', $pendingOrder)) {
                echo '<div class="dropdown-item">';
                echo '<a href="project_status.php?id=' . $pendingOrder['id'] . '">';
                echo '<span style="display: inline-block; max-width: 400px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis; font-weight: bold; font-size: 16px;">' . $pendingOrder['package_description'] . '</h6>';
                echo '</a>';
                echo '</div>';
            } else {
                echo '<pre>';
                print_r($pendingOrder);
                echo '</pre>';
                echo '<div class="dropdown-item">Error: id or package_description not found</div>';
            }
        }

        echo '</div>';
    }
    ?>
</li>


                    <li class="nav-item">
                        <a href="#" class="nav-link" style="color: darkblue;">
                            <i class="fa-solid fa-message"></i>
                        </a>
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
    <?php
    if (isset($_SESSION["seller_username"])) {
        echo '<div class="welcome-container">';
        echo '<h3 class="welcome-message"> How’s it going, ' . $_SESSION["seller_username"] . '?</h3>';
        echo '</div>';
    }
    ?>

<div class="container">
    <div class="row">
        <div class="col-lg-4">
            <a href="project.php">
                <div class="custom-square">
                    <h5>Ongoing Projects <br><br> <?php echo $ongoingProjectsCount; ?></h5>
                </div>
            </a>
        </div>


        <div class="col-lg-4">
        <a href="project_completed.php">
            <div class="custom-square">
                <h5>Completed Projects <br><br> <?php echo $completedProjectsCount; ?></h5>
            </div>
            </a>
        </div>

        <div class="col-lg-4">
            <div class="custom-square">
            <h5>Total Earning <br><br> $<?php echo number_format($totalEarnings, 2); ?></h5>
            </div>
        </div>
    </div>
</div>
<br>
<hr>


<div class="row">
    <div class="col-lg-6">
        <div class="square" style="margin-top: 60px;">
            <?php if (isset($_GET['edit']) && isset($_GET['field'])): ?>
                <?php $editField = $_GET['field']; ?>
                <form method="post" action="seller_dashboard.php">
                    <?php if ($editField === 'description'): ?>
                        <label for="new_description"><h5>Description:</h5></label>
                        <textarea id="new_description" name="new_description" style="margin-left: 70px;"><?php echo $description; ?></textarea>
                    <?php elseif ($editField === 'email'): ?>
                        <label for="new_email"><h5>Email:</h5></label>
                        <input type="text" id="new_email" name="new_email" value="<?php echo $email; ?>" style="margin-left: 105px;">
                    <?php elseif ($editField === 'password'): ?>
                        <label for="new_password"><h5>Password: </h5></label>
                        <input type="password" id="new_password" name="new_password" value="<?php echo $password; ?>" style="margin-left: 70px;">
                    <?php elseif ($editField === 'phone'): ?>
                        <label for="new_phone_number"><h5>Phone Number:</h5></label>
                        <input type="text" id="new_phone_number" name="new_phone_number" value="<?php echo $phoneNumber; ?>" style="margin-left: 20px;">
                    <?php else: ?>
                        <p>Error: Invalid field specified for editing.</p>
                    <?php endif; ?>
                    <br><br><br>
                    <input type="submit" value="Save Changes" style="background-color: darkblue; color: white; padding: 10px 10px; border: none; border-radius: 5px; cursor: pointer; font-size: 16px;">
                </form>
            <?php else: ?>
                <p style="text-align: center;">
  <img src="<?php echo $sellerRow['profilePicturePath']; ?>" alt="Profile Photo" style="width: 150px; height: 150px; border-radius: 50%; border: 1px solid darkblue;">
  <br></p>
                  <p><h5><i class="fa fa-globe" style="color: darkblue;"></i> Country: </h5><?php echo $country; ?></p><br>
                <p><h5><i class="fa fa-file-text" style="color: darkblue;"></i> Description: </h5><?php echo $description; ?> <i class="fa fa-edit" onclick="location.href='seller_dashboard.php?edit&field=description';" style="cursor: pointer;"></i></p><br>
                <p><h5><i class="fa fa-wrench" style="color: darkblue;"></i> Service: </h5><?php echo $service; ?></p><br>
                <p><h5><i class="fa fa-cogs" style="color: darkblue;"></i> Skills: </h5><?php echo $skills; ?></p><br>
                <p><h5><i class="fa-solid fa-user-graduate" style="color: darkblue;"></i> Education: </h5><?php echo $education; ?></p><br>
                <p><h5><i class="fa fa-envelope" style="color: darkblue;"></i> Email: </h5><?php echo $email; ?> <i class="fa fa-edit" onclick="location.href='seller_dashboard.php?edit&field=email';" style="cursor: pointer;"></i></p><br>
                <p><h5><i class="fa fa-key" style="color: darkblue;"></i> Password: </h5>****** <i class="fa fa-edit" onclick="location.href='seller_dashboard.php?edit&field=password';" style="cursor: pointer;"></i></p><br>
                <p><h5><i class="fa fa-phone" style="color: darkblue;"></i> Phone Number: </h5><?php echo $phoneNumber; ?> <i class="fa fa-edit" onclick="location.href='seller_dashboard.php?edit&field=phone';" style="cursor: pointer;"></i></p><br>
            <?php endif; ?>
        </div>
    </div>
  
    <div class="col-lg-6">
            <div class="row">

                <div class="square1" style="margin-top: 60px;">
                    <h5>Create your Gig here <i class="fa fa-angle-double-down" aria-hidden="true"
                                                style="color: darkblue;"></i></h5><br>
                    <button onclick="redirectToCreateGig()">Create a Gig</button>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="square" style="margin-top: 20px;">
                <h5>Active Gigs <br><br> <?php echo $approvedGigCount; ?></h5>
                    <?php
                    while ($row = mysqli_fetch_assoc($activeGigsResult)) {
                        echo '<div class="gig-container">';
                        echo '<img src="' . $row['gig_cover_photo'] . '" alt="Gig Cover">';
                        echo '<p>' . $row['gig_title'] . '</p>';
                        echo '</div>';
                    }
                    ?>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="square" style="margin-top: 20px;">
                <h5>Pending Gigs <br><br> <?php echo $pendingGigCount; ?></h5>
                    <?php
                    while ($row = mysqli_fetch_assoc($pendingGigsResult)) {
                        echo '<div class="gig-container">';
                        echo '<img src="' . $row['gig_cover_photo'] . '" alt="Gig Cover">';
                        echo '<p>' . $row['gig_title'] . '</p>';
                        echo '</div>';
                    }
                    ?>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="square" style="margin-top: 20px;">
                <h5>Declined Gigs <br><br> <?php echo $declinedGigCount; ?></h5>
                    <?php
                    while ($row = mysqli_fetch_assoc($declinedGigsResult)) {
                        echo '<div class="gig-container">';
                        echo '<img src="' . $row['gig_cover_photo'] . '" alt="Gig Cover">';
                        echo '<p>' . $row['gig_title'] . '</p>';
                        echo '</div>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

    




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    
<script>
    function togglePasswordForm() {
        var passwordForm = document.getElementById('passwordForm');
        passwordForm.style.display = (passwordForm.style.display == 'none') ? 'block' : 'none';
    }

    function updatePassword() {
                alert('Password updated successfully!');
    }
</script>

<script>
    function redirectToCreateGig() {
        window.location.href = 'create_gig.php';
    }
</script>

  
</body>
</html>