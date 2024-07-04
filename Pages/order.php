<?php
session_start();

// Include the database connection
include('database.php');

$gig_cover_photo = "";
$gig_title = "";
$seller_username= "";
$profilePicturePath= "";

if (isset($_GET['gig_id']) && isset($_GET['package'])) {
    $selectedGigId = $_GET['gig_id'];
    $selectedPackage = $_GET['package'];

    // Fetch details for the selected gig and package from the database
    $gigDetailsQuery = "SELECT g.*, s.*, g.sub_category
                    FROM giglistings g
                    JOIN sellerinformation s ON g.seller_username = s.displayName
                    WHERE g.id = $selectedGigId";
$gigDetailsResult = mysqli_query($mysqli, $gigDetailsQuery);

if ($gigDetailsResult && $gigDetails = mysqli_fetch_assoc($gigDetailsResult)) {
    // Get gig details
    $gig_cover_photo = $gigDetails['gig_cover_photo'];
    $gig_title = $gigDetails['gig_title'];
    $seller_username = $gigDetails['seller_username'];
    $profilePicturePath = $gigDetails['profilePicturePath'];
    $sub_category = $gigDetails['sub_category']; 

    // Get package details
    $packageDescription = $gigDetails[$selectedPackage . '_description'];
    $packageDeliveryTime = $gigDetails[$selectedPackage . '_delivery_time'];
    $packagePrice = $gigDetails[$selectedPackage . '_price'];
}
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
            /* Adjust as needed */
            margin-right: 40px;
            /* Adjust as needed */
            background-color:#f4f4f4;
        }
        
      

        textarea{
            width: 100%;
            border:1px solid rgba(0,0,0,.3);
            border-radius: 10px;
            padding: 5px;


            
         }

         button {
    padding: 10px;
    width:50%;
    background-color: darkblue;
    color: white;
    border: none;
    border-radius: 25px;
    font-size:22px;
    cursor: pointer;
    transition: background-color 0.3s;
    margin-left:25%;
}

button:hover {
    background-color: blue;
}

@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700&display=swap');

*{
    font-family: 'Poppins', sans-serif;
    margin:0; padding:0;
    box-sizing: border-box;
    outline: none; border: none;
    text-decoration: none;
}

.container{
    min-height: 75vh;
    background: #f4f4f4;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-flow: column;
}

.container form{
    background: #fff;
    border-radius: 5px;
    box-shadow: 0 10px 15px rgba(0,0,0,.1);
    padding: 20px;
    width: 600px;
    padding-top: 160px;
}

.container form .inputBox{
    margin-top: 20px;
}

.container form .inputBox span{
    display: block;
    color:#999;
    padding-bottom: 5px;
}

.container form .inputBox input,
.container form .inputBox select,
.container form .inputBox textarea{
    width: 100%;
    padding: 10px;
    border-radius: 10px;
    border:1px solid rgba(0,0,0,.3);
    color:#444;
}

.container form .flexbox{
    display: flex;
    gap:15px;
}

.container form .flexbox .inputBox{
    flex:1 1 150px;
}

.container .card-container{
    margin-bottom: -150px;
    position: relative;
    height: 250px;
    width: 400px;
}

.container .card-container .front{
    position: absolute;
    height: 100%;
    width: 100%;
    top: 0; left: 0;
    background:linear-gradient(45deg, darkblue, #04bade);
    border-radius: 5px;
    backface-visibility: hidden;
    box-shadow: 0 15px 25px rgba(0,0,0,.2);
    padding:20px;
    transform:perspective(1000px) rotateY(0deg);
    transition:transform .4s ease-out;
}

.container .card-container .front .image{
    display: flex;
    align-items:center;
    justify-content: space-between;
    padding-top: 10px;
}

.container .card-container .front .image img{
    height: 50px;
}

.container .card-container .front .card-number-box{
    padding:30px 0;
    font-size: 22px;
    color:#fff;
}

.container .card-container .front .flexbox{
    display: flex;
}

.container .card-container .front .flexbox .box:nth-child(1){
    margin-right: auto;
}

.container .card-container .front .flexbox .box{
    font-size: 15px;
    color:#fff;
}

.container .card-container .back{
    position: absolute;
    top:0; left: 0;
    height: 100%;
    width: 100%;
    background:linear-gradient(45deg, darkblue, #04bade);
    border-radius: 5px;
    padding: 20px 0;
    text-align: right;
    backface-visibility: hidden;
    box-shadow: 0 15px 25px rgba(0,0,0,.2);
    transform:perspective(1000px) rotateY(180deg);
    transition:transform .4s ease-out;
}

.container .card-container .back .stripe{
    background: #000;
    width: 100%;
    margin: 10px 0;
    height: 50px;
}

.container .card-container .back .box{
    padding: 0 20px;
}

.container .card-container .back .box span{
    color:#fff;
    font-size: 15px;
}

.container .card-container .back .box .cvv-box{
    height: 50px;
    padding: 10px;
    margin-top: 5px;
    color:#333;
    background: #fff;
    border-radius: 5px;
    width: 100%;
}

.container .card-container .back .box img{
    margin-top: 30px;
    height: 30px;
}

        </style>
</head>

<body style="height: 1000px;">

    <nav class="navbar fixed-top navbar-expand-sm navbar-dark" style="background-color:white">
        <div class="container-fluid">
            <a href="index.php" class="navbar-brand mb-0 h1">
                <img class="d-inline-block align-center me-2" src="logo1.jpg" width="200" height="auto">
            </a>
        </div>
    </nav>


    <div class="container-fluid" style="padding-top: 120px;">
        <div class="row">
            <div class="col-lg-6">
                <!-- Display gig details -->
                <h5><strong>Order Information</strong></h5><br>
                <div class="d-flex align-items-center"> 
                <img src="<?php echo $gig_cover_photo; ?>" alt="Gig Cover Photo" style="max-width: 50%; height: auto; border: 1px solid darkblue;">
                <p class="ms-3 mb-0"><strong><?php echo $gig_title; ?></strong><br><i style="color:gray">@<?php echo $seller_username; ?></i>
                <img src="<?php echo $gigDetails['profilePicturePath']; ?>" alt="Profile Photo" style="width: 40px; height: 40px; border-radius: 50%; border: 1px solid darkblue; "></p>
            </p> 
                </div>
                <hr>
                <br>

                <h5> <strong>Package Details: </strong></h5>
                <ul><h5><strong> <i><?php echo $sub_category; ?> / <?php echo ucfirst($selectedPackage); ?> Package</i></strong></h5>

                <p><strong>Description:</strong> <i><?php echo nl2br($packageDescription); ?></i></p>
                <p><strong>Delivery Time:</strong><i> <?php echo $packageDeliveryTime; ?> day(s)</i></p>
                <p><strong>Price:</strong><i> $<?php echo $packagePrice; ?></i></p></ul>
                <hr>
                <br>

                
             </div>

            <div class="col-lg-6">
                <h5 style="margin-left:21%;"> <strong>Enter your payment details.. </strong></h5>

                <div class="container">

    <div class="card-container">

        <div class="front">
            <div class="image">
                <img src="img/chip.png" alt="">
                <img src="img/visa.png" alt="">
            </div>
            <div class="card-number-box">#### #### #### ####</div>
            <div class="flexbox">
                <div class="box">
                    <span>CARD HOLDER</span>
                    <div class="card-holder-name">FULL NAME</div>
                </div>
                <div class="box">
                    <span>EXPIRES</span>
                    <div class="expiration">
                        <span class="exp-month">MM</span>
                        <span class="exp-year">YY</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="back">
            <div class="stripe"></div>
            <div class="box">
                <span>CVV</span>
                <div class="cvv-box"></div>
                <img src="img/visa.png" alt="">
            </div>
        </div>

    </div>

    <form action="order_process.php" method="post">
    <input type="hidden" name="gig_id" value="<?php echo $selectedGigId; ?>">
    <input type="hidden" name="package" value="<?php echo $selectedPackage; ?>">
    
    <div class="inputBox">
            <span>CARD NUMBER</span>
            <input type="text" name="" maxlength="16" class="card-number-input" require>
        </div>
        <div class="inputBox">
            <span>CARD HOLDER</span>
            <input type="text" name="" class="card-holder-input" require>
        </div>
        <div class="flexbox">
            <div class="inputBox">
                <span>EXPIRATION MM</span>
                <select name="" id="" class="month-input" require>
                    <option value="month" selected disabled>month</option>
                    <option value="01">01</option>
                    <option value="02">02</option>
                    <option value="03">03</option>
                    <option value="04">04</option>
                    <option value="05">05</option>
                    <option value="06">06</option>
                    <option value="07">07</option>
                    <option value="08">08</option>
                    <option value="09">09</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                </select>
            </div>
            <div class="inputBox">
                <span>EXPIRATION YY</span>
                <select name="" id="" class="year-input" require>
                    <option value="year" selected disabled>year</option>
                    <option value="2021">2021</option>
                    <option value="2022">2022</option>
                    <option value="2023">2023</option>
                    <option value="2024">2024</option>
                    <option value="2025">2025</option>
                    <option value="2026">2026</option>
                    <option value="2027">2027</option>
                    <option value="2028">2028</option>
                    <option value="2029">2029</option>
                    <option value="2030">2030</option>
                </select>
            </div>
            <div class="inputBox">
                <span>CVV</span>
                <input type="text" name="" maxlength="4" class="cvv-input">
            </div>
        </div>
        
        <div class="inputBox">
        <span>TYPE YOUR NEED..</span>
        <textarea class="message" name="message" rows="4" placeholder="I want to do something like this..." required></textarea><br><br>
        </div>

        <button type="submit">Continue To Process</button>

    </form>

</div>            
            </div>
        </div>

    </div>
    <br><br><br><br>





    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
   
    <script>
document.querySelector('.card-number-input').oninput = () =>{
    document.querySelector('.card-number-box').innerText = document.querySelector('.card-number-input').value;
}

document.querySelector('.card-holder-input').oninput = () =>{
    document.querySelector('.card-holder-name').innerText = document.querySelector('.card-holder-input').value;
}

document.querySelector('.month-input').oninput = () =>{
    document.querySelector('.exp-month').innerText = document.querySelector('.month-input').value;
}

document.querySelector('.year-input').oninput = () =>{
    document.querySelector('.exp-year').innerText = document.querySelector('.year-input').value;
}

document.querySelector('.cvv-input').onmouseenter = () =>{
    document.querySelector('.front').style.transform = 'perspective(1000px) rotateY(-180deg)';
    document.querySelector('.back').style.transform = 'perspective(1000px) rotateY(0deg)';
}

document.querySelector('.cvv-input').onmouseleave = () =>{
    document.querySelector('.front').style.transform = 'perspective(1000px) rotateY(0deg)';
    document.querySelector('.back').style.transform = 'perspective(1000px) rotateY(180deg)';
}

document.querySelector('.cvv-input').oninput = () =>{
    document.querySelector('.cvv-box').innerText = document.querySelector('.cvv-input').value;
}

</script>


</body>
</html>