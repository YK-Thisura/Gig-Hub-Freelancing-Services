<?php
session_start();

include('database.php');

$sellerCount = mysqli_query($mysqli, "SELECT COUNT(*) FROM sellerinformation")->fetch_row()[0];
$clientCount = mysqli_query($mysqli, "SELECT COUNT(*) FROM user")->fetch_row()[0];
$gigCount = mysqli_query($mysqli, "SELECT COUNT(*) FROM giglistings WHERE approval_status = 'approved'")->fetch_row()[0];


$searchKeyword = isset($_GET['search']) ? mysqli_real_escape_string($mysqli, $_GET['search']) : '';

if (!empty($searchKeyword)) {
    // Search in user table
    $userSearchQuery = "SELECT * FROM user WHERE username LIKE '%$searchKeyword%' OR email LIKE '%$searchKeyword%'";
    $userSearchResult = mysqli_query($mysqli, $userSearchQuery);

    // Search in sellerinformation table
    $sellerSearchQuery = "SELECT * FROM sellerinformation WHERE displayName LIKE '%$searchKeyword%' OR email LIKE '%$searchKeyword%'";
    $sellerSearchResult = mysqli_query($mysqli, $sellerSearchQuery);
}

$pendingGigsResult = mysqli_query($mysqli, "SELECT * FROM giglistings WHERE approval_status = 'pending'");
$pendingGigCount = mysqli_num_rows($pendingGigsResult);
?>

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
            margin-right: 40px;
        }

        .custom-square {
            width: 250px;
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

        .square{
            width: 100%;
            background-color: white;
            padding: 20px;
            min-height: 100px;
            overflow: auto;
            margin-top: 20px; 
            border-radius: 20px;
        }

        .button {
            background-color: darkblue; 
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .button:hover {
            background-color: blue; 
            color:white;
        }
    </style>
</head>

<body style="height: 2000px; background-color: #f4f4f4;">

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
                        if ($pendingGigCount > 0) {
                            echo $pendingGigCount;
                        }
                        ?>
                    </a>
                    <?php
                    if ($pendingGigCount > 0) {
                        $pendingGigsArray = mysqli_fetch_all($pendingGigsResult, MYSQLI_ASSOC);

                        echo '<div class="dropdown-menu" aria-labelledby="navbarDropdown" style="width: 450px; overflow-y: auto;">';
                        foreach ($pendingGigsArray as $pendingGig) {
                            if (array_key_exists('gig_title', $pendingGig) && array_key_exists('gig_cover_photo', $pendingGig)) {
                                echo '<a class="dropdown-item" href="service_status.php?gig_id=' . $pendingGig['id'] . '">';
                                echo '<img src="' . $pendingGig['gig_cover_photo'] . '" alt="Gig Cover" style="width: auto; height: 100px; margin-right: 5px; border: 1px solid darkblue; border-radius: 10px;">';
                                echo '<span style="display: inline-block; max-width: 200px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis; font-weight: bold; font-size: 16px;">' . $pendingGig['gig_title'] . '</span>';
                                echo '</a>';
                            } else {
                                echo '<pre>';
                                print_r($pendingGig);
                                echo '</pre>';
                                echo '<a class="dropdown-item" href="#">Error: gig_title or gig_cover_photo not found</a>';
                            }
                        }
                        echo '</div>';
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

<div class="container custom-container" style="padding-top: 120px;">
    <h3>Welcome Back Admin!</h3>
</div>

<div class="container">
    <div class="row">
        <div class="col-lg-4">
            <div class="custom-square">
                <h5>Total Sellers <br><br> <?php echo $sellerCount; ?></h5>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="custom-square">
                <h5>Total Clients <br><br> <?php echo $clientCount; ?></h5>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="custom-square">
                <h5>Total Gig Listings <br><br> <?php echo $gigCount; ?></h5>
            </div>
        </div>
    </div>
</div>
<br>
<hr>
<br>

<div class="container mt-4">
    <form action="" method="GET">
    <h5><i>Manage Clients & Sellers In Here..</i></h5><br>
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Search by username or email" name="search" value="<?php echo $searchKeyword; ?>">
            <button class="button" type="submit">Search</button>
        </div>
    </form>
</div>

<div class="container">
    <?php
    if (!empty($searchKeyword)) {
        $hasResults = false;

        echo '<h4><i>Search Results:</i></h4>';

        echo '<div class="row">';
        echo '<div class="col-lg-6">';
        while ($userRow = mysqli_fetch_assoc($userSearchResult)) {
            $hasResults = true;
            echo '<h5 style="text-align:center;">Clients:</h5>';
            echo '<div class="square">';
            echo '<h5>Client ID: #' . $userRow['id'] . '</h5>';
            echo '<p>Username: ' . $userRow['username'] . '</p>';
            echo '<p>Email: ' . $userRow['email'] . '</p>';
            echo '<button class="btn btn-warning" onclick="temporaryHold(' . $userRow['id'] . ')">Temporary Hold</button>';
            echo '<button class="btn btn-danger" style="margin-left: 5%;" onclick="permanentDelete(' . $userRow['id'] . ')">Permanent Delete</button>';
            echo '</div>';
        }
        echo '</div>';

        echo '<div class="col-lg-6">';
        while ($sellerRow = mysqli_fetch_assoc($sellerSearchResult)) {
            $hasResults = true;            
            echo '<h5 style="text-align:center;">Sellers:</h5>';
            echo '<div class="square">';
            echo '<h5>Seller ID: #' . $sellerRow['id'] . '</h5>';
            echo '<p>Username: ' . $sellerRow['displayName'] . '</p>';
            echo '<p>Email: ' . $sellerRow['email'] . '</p>';
            echo '<button class="btn btn-warning" onclick="temporaryHold(' . $sellerRow['id'] . ')">Temporary Hold</button>';
            echo '<button class="btn btn-danger" style="margin-left: 5%;" onclick="permanentDelete(' . $sellerRow['id'] . ')">Permanent Delete</button>';
            echo '</div>';
        }
        echo '</div>';

        if (!$hasResults) {
            echo '<div class="col-lg-12">';
            echo '<p>No search results found.</p>';
            echo '</div>';
        }
    }
    ?>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

<script>
    // JavaScript functions for button actions
    function temporaryHold(id) {
        // Implement temporary hold logic here
        alert('Temporary Hold clicked for User ID: ' + id);
    }

    function permanentDelete(id) {
        // Implement permanent delete logic here
        alert('Permanent Delete clicked for User ID: ' + id);
    }
</script>

<script>
    // JavaScript function for button actions
    function permanentDelete(id) {
        // Confirm with the user before performing the delete
        if (confirm('Are you sure you want to permanently delete this user?')) {
            // Send an AJAX request to a PHP script that handles the deletion
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // Handle the response (if needed)
                    alert(xhr.responseText);
                    // Optionally, you can reload the page or perform any other actions
                    location.reload();
                }
            };

            // Replace 'your_delete_script.php' with the actual PHP script that handles the deletion
            xhr.open('GET', 'your_delete_script.php?userId=' + id, true);
            xhr.send();
        }
    }
</script>


</body>
</html>
<?php
mysqli_close($mysqli);
?>
