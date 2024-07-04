<?php
session_start();

if (!isset($_SESSION["username"])) {
    header("Location: index.php");
    exit;
}

include('database.php');


if (isset($_GET['id'])) {
    $orderID = $_GET['id'];

    $orderDetailsQuery = "SELECT * FROM orders WHERE id = $orderID";
    $orderDetailsResult = mysqli_query($mysqli, $orderDetailsQuery);

    if ($orderDetailsResult && $orderDetails = mysqli_fetch_assoc($orderDetailsResult)) {
        $orderStatus = $orderDetails['project_status'];
        $orderSubCategory = $orderDetails['sub_category'];
        $orderPackage = $orderDetails['package'];
        $orderPackageDescription = $orderDetails['package_description'];
        $orderPackagePrice = $orderDetails['package_price'];
        $orderPackageDeliveryTime = $orderDetails['package_delivery_time'];
        $orderMessage = $orderDetails['message'];
        $orderSellerUsername = $orderDetails['seller_username'];


        
    } else {
        echo 'Error fetching order details: ' . mysqli_error($mysqli);
    }
} else {
    echo 'Order ID not provided in the URL.';
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

        .square button {
            background-color: darkblue; 
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .square button:hover {
            background-color: blue; 
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
            color: darkblue; 
        }

    
        .unselected:before {
            opacity: 1;
            color: lightgray; 
        }

        .rating > span {
            display: inline-block;
            position: relative;
            width: 1.1em;
            unicode-bidi: bidi-override;
        }

        .rating > span:before {
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



<?php
    echo '<div class="square" style="margin-top:10%;">';
        echo '<p style="font-weight: bolder;">Order ID: #' . $orderID . '</p>';
        echo '<p style="font-style: italic; font-weight: bolder; font-size:18px;">' . $orderSubCategory . '->' . $orderPackage . ' package</p>';
        echo '<ul><p><strong>Package Description:</strong> ' . $orderPackageDescription . '</p>';
        echo '<p><strong>Package Price:</strong> $'  . $orderPackagePrice . '</p>';
        echo '<p><strong>Package Delivery Time:</strong> ' . $orderPackageDeliveryTime . ' day(s)</p>';
        echo '<p><strong>Requirement:</strong> "' . $orderMessage . '"</p></ul>';

        if ($orderStatus === 'in progress') {
            echo '<ul><p><strong>Project Status:</strong> In Progress</p></ul>';
            echo '<br><ul><button type="button" class="custom-button" onclick="redirectToProfile()">OK</button></ul>';

        } elseif ($orderStatus === 'completed') {
            echo '<ul><p><strong>Project Status:</strong> Completed</p></ul>';

            $fileName = $orderDetails['file_path']; 
    $filePath = $fileName; 

    if (file_exists($filePath)) {
        echo '<uL><p ><i><strong>Click here to download the project file</strong></i> <a href="' . $filePath . '" download style="color:blue; text-decoration: underline; pointer:cursor;">Download File <i class="fa fa-download" aria-hidden="true"></i></ul>
        </a></p>';
        echo '<br><ul><button type="button" id="projectDoneButton">Project Done</button></ul>';


    } else {
        echo "File not found. Path: $filePath";
            }
            echo '<br>';


            echo '<hr>';

            echo '<br>';
        echo '<p style="font-style: italic; font-weight: bolder; font-size:18px;"> Share Your Thoughts and Reviews on Exceptional Service!</p>';
        echo '<div class="rating-container">';
        echo '<div class="rating" onclick="toggleStar(event)">';
        echo '<span class="unselected" data-rating="1">&#9733;</span>';
        echo '<span class="unselected" data-rating="2">&#9733;</span>';
        echo '<span class="unselected" data-rating="3">&#9733;</span>';
        echo '<span class="unselected" data-rating="4">&#9733;</span>';
        echo '<span class="unselected" data-rating="5">&#9733;</span>';
        echo '</div>';
        echo '</div>';

        echo '<div class="comments-container">';
        echo '<textarea name="review_text" rows="4" required style="width: 150%; border-radius:10px; padding:10px;"></textarea>';
        echo '<button type="button" onclick="submitReview()" class="submit-btn">Submit Review</button>';
        echo '</div>';

        echo '<br><br>';


        }

        ?>




<script>
function redirectToProfile() {
    window.location.href = 'profile.php';
}
</script>

<script>
function toggleStar(event) {
        const selectedStar = event.target;
        const rating = selectedStar.getAttribute('data-rating');

        const stars = document.querySelectorAll('.rating span');
        stars.forEach(star => star.classList.remove('selected'));

        for (let i = 1; i <= rating; i++) {
            stars[i - 1].classList.add('selected');
            stars[i - 1].classList.remove('unselected');
        }

        for (let i = rating; i < stars.length; i++) {
            stars[i].classList.add('unselected');
            stars[i].classList.remove('selected');
        }

        const ratingInput = document.querySelector('input[name="rating"]');
        ratingInput.value = rating;
    }


    function submitReview() {
    const selectedStars = document.querySelectorAll('.rating span.selected');
    
    if (selectedStars.length > 0) {
        const rating = selectedStars.length;
        const reviewText = document.querySelector('.comments-container textarea').value;

        fetch('review_submit.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `gig_id=<?php echo $orderDetails['gig_id']; ?>&rating=${rating}&review_text=${encodeURIComponent(reviewText)}`,
        })
        .then(response => response.text())
        .then(data => {
            alert(data);
            redirectToProfile();
        })
        .catch(error => {
            console.error(error);
        });
    } else {
        alert('Please select a rating before submitting the review.');
    }
}

</script>

<script>
document.getElementById('projectDoneButton').addEventListener('click', function() {
    fetch('update_client_status.php?id=<?php echo $orderID; ?>', {
        method: 'GET',
    })
    .then(response => response.text())
    .then(data => {
        alert(data);  
        document.getElementById('projectDoneButton').style.display = 'none';
    })
    .catch(error => {
        console.error(error);
    });
});
</script>




</body>

</html>
