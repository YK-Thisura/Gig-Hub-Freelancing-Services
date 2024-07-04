<?php
session_start();

include('database.php');

date_default_timezone_set('Asia/Colombo');


if (isset($_GET["logout"])) {
    $_SESSION = array();

    session_destroy();

    header("Location: index.php");
    exit;
}
function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );

    foreach ($string as $key => &$value) {
        if ($diff->$key) {
            $value = $diff->$key . ' ' . $value . ($diff->$key > 1 ? 's' : '');
        } else {
            unset($string[$key]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}


if (isset($_GET['gig_id'])) {
    $selectedGigId = $_GET['gig_id'];

    $gigDetailsQuery = "SELECT g.*, s.*
                    FROM giglistings g
                    JOIN sellerinformation s ON g.seller_username = s.displayName
                    WHERE g.id = $selectedGigId";
$gigDetailsResult = mysqli_query($mysqli, $gigDetailsQuery);


    if ($gigDetailsResult && $gigDetails = mysqli_fetch_assoc($gigDetailsResult)) {
        ?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title>GigHub</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
            <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,0,0">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
            
            <link rel="stylesheet" href="styles.css">
            <style>
                @import url("https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600;700&display=swap");

                body {
                    margin-left: 40px;
                    margin-right: 40px;
                    background-color: #f4f4f4;
                }

                h2 {
                    color: black;
                    font-size: 24px;
                    padding-top: 120px;
                }

                p {
                    color: #333;
                    font-size: 16px;
                }

                .rating-container {
                    display: flex;
                    flex-direction: column;
                    align-items: flex-start;
                }

                .rating {
                    font-size: 25px;
                    height: 25px;
                    cursor: pointer;
                }

                .selected:before {
                    opacity: 1;
                    color: gold;
                }

                .unselected:before {
                    opacity: 1;
                    color: #ccc;
                }

                .rating>span {
                    display: inline-block;
                    position: relative;
                    width: 1.1em;
                    unicode-bidi: bidi-override;
                }

                .rating>span:before {
                    content: '\2605';
                    position: absolute;
                }

                .comments-container {
                    margin-top: 10px;
                    width: 300px;
                }

                .comments {
                    width: 100%;
                    height: 100px;
                    resize: none;
                }

                .submit-btn {
                    margin-top: 10px;
                    padding: 8px 16px;
                    background-color: #4CAF50;
                    color: white;
                    border: none;
                    border-radius: 4px;
                    cursor: pointer;
                }

                .submit-btn:hover {
                    background-color: #45a049;
                }

                .square {
                   width: 70%;
                   background-color: white;
                   padding: 20px;
                   min-height: 200px; 
                   overflow: auto; 
                   border-radius: 10px;
                   margin-left: 15% ;
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
        .gig-container p:hover{
           cursor: pointer; 
           text-decoration: underline;
      }

      th, td {
       padding: 15px;
}


      button {
    padding: 10px;
    background-color: darkblue;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s;
}

button:hover {
    background-color: blue;
}

            </style>
        </head>

        <body style="min-height: 2000px; overflow:auto;">

            <nav class="navbar fixed-top navbar-expand-sm navbar-dark" style="background-color:white">
                <div class="container-fluid">
                    <a href="index.php" class="navbar-brand mb-0 h1">
                        <img class="d-inline-block align-center me-2" src="logo1.jpg" width="200" height="auto">
                    </a>

                    <button type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" class="navbar-toggler" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
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

            <div class="container-fluid">
                <div class="row">
                <div class="col-lg-6">
                        <h2><strong><?php echo $gigDetails['gig_title']; ?></strong></h2><br>
                        <img src="<?php echo $gigDetails['gig_cover_photo']; ?>" alt="Gig Cover Photo" style="height: auto; width: 100%;">
                        <h4 style="padding-top:30px;"><strong>About this gig</strong></h4>
                        <div style="text-align: justify;"><?php echo nl2br($gigDetails['gig_description']); ?></div> <br>
                        <hr>

                         <h4><strong>Scope & Pricing:</strong></h4>
                        <div style="margin-top: 20px;">
                            <table style="width:100%; border-collapse: collapse; margin-bottom: 20px;">
                                <thead>
                                <tr style="text-align: center; border: 1px solid #ddd;">
                                   <th style="border: 1px solid #ddd;"></th>
                                   <th style="border: 1px solid #ddd; width: 25%;">Basic</th>
                                   <th style="border: 1px solid #ddd; width: 25%;">Standard</th>
                                   <th style="border: 1px solid #ddd; width: 25%;">Premium</th>
                                </tr>
                                </thead>
                                <tbody style="text-align: center;">
                                    <tr>
                                        <td style="font-weight:bold; border: 1px solid #ddd;">Description</td>
                                        <td style="border: 1px solid #ddd; width: 25%;"><?php echo nl2br($gigDetails['basic_description']); ?></td>
                                        <td style="border: 1px solid #ddd; width: 25%;"><?php echo nl2br($gigDetails['standard_description']); ?></td>
                                        <td style="border: 1px solid #ddd; width: 25%;"><?php echo nl2br($gigDetails['premium_description']); ?></td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight:bold; border: 1px solid #ddd;">Delivery Time</td>
                                        <td style="border: 1px solid #ddd; width: 25%;"><?php echo $gigDetails['basic_delivery_time']; ?> day(s)</td>
                                        <td style="border: 1px solid #ddd; width: 25%;"><?php echo $gigDetails['standard_delivery_time']; ?> day(s)</td>
                                        <td style="border: 1px solid #ddd; width: 25%;"><?php echo $gigDetails['premium_delivery_time']; ?> day(s)</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight:bold; border: 1px solid #ddd;">Price</td>
                                        <td style="border: 1px solid #ddd; width: 25%;">$<?php echo $gigDetails['basic_price']; ?></td>
                                        <td style="border: 1px solid #ddd; width: 25%;">$<?php echo $gigDetails['standard_price']; ?></td>
                                        <td style="border: 1px solid #ddd; width: 25%;">$<?php echo $gigDetails['premium_price']; ?></td>
                                    </tr>
                                    <tr style="text-align: center; border: 1px solid #ddd;">
    <th style="border: 1px solid #ddd;"></th>
    <th style="border: 1px solid #ddd;">
        <a href="order.php?gig_id=<?php echo $selectedGigId; ?>&package=basic">
            <button id="basic">continue</button>
        </a>
    </th>
    <th style="border: 1px solid #ddd;">
        <a href="order.php?gig_id=<?php echo $selectedGigId; ?>&package=standard">
            <button id="standard">continue</button>
        </a>
    </th>
    <th style="border: 1px solid #ddd;">
        <a href="order.php?gig_id=<?php echo $selectedGigId; ?>&package=premium">
            <button id="premium">continue</button>
        </a>
    </th>
</tr>

                                </tbody>
                            </table>
                        </div> <br>
                        <hr>

                        <h4 style="padding-top:30px;"><strong>Reviews</strong></h4>
                        <?php
                        $reviewsQuery = "SELECT r.rating, r.review_text, r.created_at, u.username 
                        FROM reviews r 
                        JOIN user u ON r.username = u.username
                        WHERE r.gig_id = $selectedGigId";
                        $reviewsResult = mysqli_query($mysqli, $reviewsQuery);
       
                        if ($reviewsResult) {
                            while ($review = mysqli_fetch_assoc($reviewsResult)) {
                                $rating = $review['rating'];
                                $starRating = str_repeat('&#9733;', $rating); 
       
                                echo '<p>@' . $review['username'] . '</p>';
                                echo '<p>' . $starRating . ' | <small>' . time_elapsed_string($review['created_at']) . '</small></p>';
                                echo '<p><strong>Review:</strong> ' . nl2br($review['review_text']) . '</p>';
                                echo '<hr>';
                            }
                        } else {
                            echo 'Error fetching reviews: ' . mysqli_error($mysqli);
                        }
                        ?>

                        
                        <br><br>
                       
                    </div>
                    <div class="col-lg-6 " style="padding-top: 120px;">
                    <h5 style="margin-left: 15%;"><strong> About the seller </strong></h5>
    <div class="square">
                    <p style="text-align: center;"><br>
                    <img src="<?php echo $gigDetails['profilePicturePath']; ?>" alt="Profile Photo" style="width: 150px; height: 150px; border-radius: 50%; border: 1px solid darkblue; "></p>
                    <p style="text-align: center;"><strong>@<?php echo $gigDetails['seller_username']; ?></strong></p> <br>
                    <p ><strong> Expert In: <br><i class="fas fa-check-circle" style="color:darkblue;"></i> <?php echo $gigDetails['service']; ?></strong></p>
                    <hr>
                    <p > <?php echo $gigDetails['description']; ?></p>
                    <hr>
                    <h5><i>More of seller's gigs..</i></h5><br>
                    <?php
                      $otherGigsQuery = "SELECT * FROM giglistings WHERE seller_username = '{$gigDetails['seller_username']}' AND id != $selectedGigId AND approval_status = 'approved'";
                      $otherGigsResult = mysqli_query($mysqli, $otherGigsQuery);

                     if ($otherGigsResult) {
                       while ($otherGig = mysqli_fetch_assoc($otherGigsResult)) {
                    ?>
                    <div class="gig-container">
                    <a href="service.php?gig_id=<?php echo $otherGig['id']; ?>">
                    <p><img src="<?php echo $otherGig['gig_cover_photo']; ?>">
                    <p><i><?php echo $otherGig['gig_title']; ?></i></p>
                    </div>
                    <br>
                    <?php
                    }
                    } else {
                    echo 'Error fetching other gigs: ' . mysqli_error($mysqli);
                    }
                    ?>

                    
                    
            
                    </div>
                </div>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

          

        </body>

        </html>
        <?php
    } else {
        echo 'Error fetching gig details: ' . mysqli_error($mysqli);
    }
}
?>
