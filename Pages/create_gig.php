<?php
session_start();

// Check if the seller is logged in
if (!isset($_SESSION["seller_username"])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit;
}

include('database.php');


// Fetch seller details based on the session variable
$sellerUsername = $_SESSION["seller_username"];
$sellerSql = "SELECT * FROM sellerinformation WHERE displayName = '$sellerUsername'";
$sellerResult = mysqli_query($mysqli, $sellerSql);

if ($sellerResult) {
    $sellerRow = mysqli_fetch_assoc($sellerResult);

    if ($sellerRow) {
        // Display seller details on the page
        $service = $sellerRow["service"];
        $skills = explode(", ", $sellerRow["skills"]);
    }
}
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GigHub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,0,0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"  />
    <link rel="stylesheet" href="styles.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.12/css/intlTelInput.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.12/js/intlTelInput.min.js"></script>



<style>
@import url("https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600;700&display=swap");

        body {
          background-color: #f4f4f4; /* Set the background color to light blue */
        }
        
        h2 {
            color: #333;
        }

        form {
            padding: 20px;
        }

        label {
            display: block;
            margin: 10px 0 5px;
            font-weight: bold;
            font-size: 20px;
        }

        input,
        textarea,
        select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }

        .table{
            text-align: center;
            
        }
        
        button {
            background-color: darkblue;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: blue;
        }

      

    </style>
</head>

<body style="height: 2000px;" >

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
                        <a href="#" class="nav-link" style="color: darkblue;">
                        <i class="fa fa-bell"></i>
                        </a>
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
<div class="row">
    <div class="col-lg-12">
        <div class="container" style="margin-top: 120px;">

       <form action="process_gig.php" method="post" enctype="multipart/form-data">
        <!-- Gig Title -->
        <label for="gigTitle">Gig Title:</label>
        <p><i>As your Gig storefront, your title is the most important place to include keywords that buyers would likely use to search for a service like yours.</i></p>
        <input type="text" id="gigTitle" name="gigTitle" placeholder="I will do somthing I'm really good at" required>
        <br><br>

        <!-- Gig Description -->
        <label for="gigDescription">Gig Description:</label>
        <p><i>Briefly Describe Your Gig</i></p>
        <textarea id="gigDescription" name="gigDescription" rows="8" required></textarea>
        <br><br>

        <!-- Service Category -->
        <label for="service">Category:</label>
        <p><i>This category is selected based on what you select during registration.</i></p>
    <input id="service" name="service" value="<?php echo $service; ?>" readonly required>
    <br><br>

    <!-- Skills -->
    <label for="selectedSkill">Sub Category:</label>
    <p><i>Choose the sub-category most suitable for your Gig.</i></p>
    <select id="selectedSkill" name="selectedSkill" required>
        <?php
        foreach ($skills as $skill) {
            echo "<option value=\"$skill\">$skill</option>";
        }
        ?>
    </select>
    <br><br>

        <!-- Keywords -->
        <label for="keywords">Keywords (Search Tags):</label>
        <p><i>Tag your Gig with buzz words that are relevant to the services you offer. Use all 5 tags to get found.</i></p>
        <input type="text" id="keywords" name="keywords" required>
        <br><br>

        <label for="pricePackages">Scope & Pricing:</label>
        <p><i>Provide concise descriptions, set delivery times, and establish competitive prices for your Basic, Standard, and Premium packages.</i></p>
    <table style="width:100%; height:300px;">
        <thead>
            <tr style="text-align: center;">
                <th></th>
                <th>Basic</th>
                <th>Standard</th>
                <th>Premium</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="font-weight:bold;">Description</td>
                <td><textarea name="basicDescription" rows="2" required></textarea></td>
                <td><textarea name="standardDescription" rows="2" required></textarea></td>
                <td><textarea name="premiumDescription" rows="2" required></textarea></td>
            </tr>
            <tr>
    <td style="font-weight:bold;">Delivery Time</td>
    <td>
    <div class="delivery-time-selector">
    <input type="number" name="basicDeliveryTime" value="1" min="1" max="30" onkeydown="return false" required>
            
        </div>
    </td>
    <td>
    <div class="delivery-time-selector">
            <input type="number" name="standardDeliveryTime" value="1" min="1" max="30" onkeydown="return false" required>
            </div>
    </td>
    <td>
    <div class="delivery-time-selector">
            <input type="number" name="premiumDeliveryTime" value="1" min="1" max="30" onkeydown="return false" required>
            </div>
    </td>
</tr>

            <tr>
                <td style="font-weight:bold;">Price</td>
                <td><input type="number" name="basicPrice" placeholder="$" required></td>
                <td><input type="number" name="standardPrice" placeholder="$" required></td>
                <td><input type="number" name="premiumPrice" placeholder="$" required></td>
            </tr>
        </tbody>
    </table><br><br>

    <label for="gigCoverPhoto">Gig Cover Photo:</label>
    <p><i>Get noticed by the right buyers with visual examples of your services.</i></p>

    <!-- Rectangular Input for Cover Photo -->
    <div style="position: relative; overflow: hidden; display: inline-block;">
      <input
        type="file"
        id="gigCoverPhoto"
        name="gigCoverPhoto"
        accept="image/*"
        onchange="previewCoverPhoto(this); validateCoverPhotoDimensions(this);"
        style="position: absolute; opacity: 0; height: 100%; width: 100%;"
        required
      />
      <label for="gigCoverPhoto" style="cursor: pointer;">
        <div style="width: 450px; height: 200px; border: 2px solid #ddd; position: relative;">
          <i class="fas fa-camera" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);"></i>
          <img id="coverPhotoPreview" src="#" alt="Cover Photo Preview" style="max-width: 100%; max-height: auto; display: none;">
        </div>
      </label>
    </div>
    <br><br>

    <!-- Display dimensions info -->
    <div id="dimensionsInfo"></div>

      
        <!-- Submit Button -->
        <button type="submit">Submit Listing</button>
    </form>
</div>
</div>
</div>
    


  

      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

      <script>
      function previewCoverPhoto(input) {
    var preview = document.getElementById('coverPhotoPreview');
    var dimensionsInfo = document.getElementById('dimensionsInfo');
    var cameraIcon = document.querySelector('.fa-camera'); // Select the camera icon using a class

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            var img = new Image();
            img.src = e.target.result;

            img.onload = function() {
                // Display dimensions

                // Display preview
                preview.src = e.target.result;
                preview.style.display = 'block';

                // Hide camera icon
                cameraIcon.style.display = 'none';
            };
        };

        reader.readAsDataURL(input.files[0]);
    } else {
        // Reset preview and dimensions
        preview.src = '';
        preview.style.display = 'none';
        dimensionsInfo.innerHTML = '';

        // Show camera icon
        cameraIcon.style.display = 'block';
    }
}


      function validateCoverPhotoDimensions(input) {
        var img = new Image();
        img.src = window.URL.createObjectURL(input.files[0]);

        img.onload = function() {
          var width = this.width;
          var height = this.height;

          // Check dimensions (820px wide by 360px tall)
          if (width !== 820 || height !== 360) {
            alert("Please upload an image with dimensions 820px width by 360px height.");
            // Reset the file input
            input.value = "";
          }
        };
      }
    </script>


      
      </body>
      </html>