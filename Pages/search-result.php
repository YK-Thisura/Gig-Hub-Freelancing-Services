<?php
include('database.php');

session_start();

if (isset($_GET["logout"])) {
    $_SESSION = array();
    
    session_destroy();
    
    header("Location: index.php");
    exit;
}

if (isset($_GET['keywords'])) {
    $keywords = mysqli_real_escape_string($mysqli, $_GET['keywords']);
    
    $lowerKeywords = strtolower($keywords);
    $upperKeywords = strtoupper($keywords);
    
    $gigListingsQuery = "SELECT g.id, g.gig_title, g.gig_cover_photo, s.profilePicturePath, g.seller_username
    FROM giglistings g
    JOIN sellerinformation s ON g.seller_username = s.displayName
    WHERE (LOWER(g.keywords) LIKE '%$lowerKeywords%'
    OR UPPER(g.keywords) LIKE '%$upperKeywords%')
    AND g.approval_status = 'approved'";

    
    $gigListingsResult = mysqli_query($mysqli, $gigListingsQuery);

    $gigListings = [];
    if ($gigListingsResult) {
        while ($row = mysqli_fetch_assoc($gigListingsResult)) {
            $gigListings[] = $row;
        }
    } else {
        echo 'Error fetching gig listings: ' . mysqli_error($mysqli);
    }
} else {
    $gigListings = array();
}
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
            background-color: #f4f4f4; 

        }

        .card {
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 8px;
        overflow: hidden;
        transition: box-shadow 0.3s;
    }

    .card:hover {
        box-shadow: 0 0 10px rgba(0, 0, 139, 1.0); 
        cursor: pointer;
    }

    
    .card h6 {
        font-size: 18px;
        margin: 5px 0;
        text-align: center;
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
                    
                    
                    <li class="nav-item">
                        <a href="profile.php" class="nav-link" style="color: darkblue;">
                            <i class="fa fa-user"></i>
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

    <h5 style="padding-top: 10%;"><i>Search results for the <?php echo $keywords; ?>... </i></h5>

    <div class="container" style="margin-top: 3%;">
    <div class="row">
        <?php
        foreach ($gigListings as $listing) {
            echo '<div class="col-md-4" style="margin-bottom: 20px;">';
            echo '<a href="service.php?gig_id=' . $listing['id'] . '">';
            echo '<div class="card">';
            echo '<img class="card-img-top" src="' . $listing['gig_cover_photo'] . '" alt="Gig Cover">';
            echo '<div class="card-body" style="background-color: transparent;">';
            echo '<img class="card-img-top" src="' . $listing['profilePicturePath'] . '" alt="Seller Profile Picture" style="width: 35px; height: 35px; border-radius: 50%; margin-bottom: 10px;">';
            echo '<span style="margin-left: 10px; color: #888;">@' . $listing['seller_username'] . '</span>';
            echo '<i><span style="display: inline-block; font-weight: bold; font-size: 16px;">' . $listing['gig_title']. '</span></i>';
            echo '</div>';
            echo '</div>';
            echo '</a>';
            echo '</div>';
        }
        
        ?>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</body>
</html>