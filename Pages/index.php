<?php
session_start();

if (isset($_GET["logout"])) {
    $_SESSION = array();
    
    session_destroy();
    
    header("Location: index.php");
    exit;
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="styles.css">

<style>
@import url("https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600;700&display=swap");

body {
    background-color: #f4f4f4;
        }

.clickable-area {
    cursor: pointer;
    border: 2px solid transparent; 
    transition: border 0.3s;
}

.clickable-area:hover {
    border: 2px solid #f4f4f4; 
}

.clickable-area img,
.clickable-area p {
    transition: transform 0.3s; 
}

.clickable-area:hover img,
.clickable-area:hover p {
    transform: scale(0.95);
    color: darkblue;
    font-weight: bold;
}


body {
    margin: 0;
    font-family: Arial, sans-serif;
    
}

#overlay-container {
    position: relative;
    width: 100%;
    height: 30%;
    overflow: hidden;
    margin-bottom: 100px;
    
}


#background-video {
    width: 100%;
    height: 100%;
    object-fit: cover;
}



#overlay-content {
    position: absolute;
    top: 40%;
    left: 50%;
    transform: translate(-50%, -50%);
    text-align: center;
    color: white;
    z-index: 1;
    
}

#title {
    font-size: 24px;
    font-weight: bold;
    margin-bottom: 20px;
    text-align: center;

}

#search-container {
    width: 300px;
    margin: 0 auto;
}

input[type="text"] {
    padding: 10px;
    font-size: 16px;
    width: 100%;
    border-radius: 5px;
}

input[type="submit"] {
    padding: 10px 20px;
    font-size: 16px;
    background-color: darkblue;
    color: white;
    border-radius: 15px;
    cursor: pointer;
}


p {
    font-size: 20px; 
    color: #333;
    line-height: 1.6; 
    margin-bottom: 20px; 
    font-weight: bold;
    padding-left: 10%;
    
}

h1{
    padding-left: 10%;
    font-weight: bold;

}
#content1 {
    background-color: #f0f8ff; 
}

.header {
    margin-bottom: 50px; 
}



.form-popup {
    position: fixed;
    top: 65%;
    left: 50%;
    z-index: 10;
    width: 100%;
    opacity: 1;
    max-width: 770px;
    
    background: #fff;
    
    transform: translate(-50%, -70%);
}
.show-popup .form-popup {
    opacity: 1;
    pointer-events: auto;
    transform: translate(-50%, -50%);
    transition: transform 0.3s ease, opacity 0.1s;
}

.form-popup .form-box {
    display: flex;
}

.form-box .form-details {
    width: 100%;
    color: #fff;
    max-width: 430px;
    text-align: left;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding-left: 50px;
}

.form-details p{
    color: white;
    font-weight: lighter;
}

.form-details h2{
    color: white;
    font-weight: bolder ;
}

.login .form-details {
    padding: 0 40px;
    background: url("img/login1.jpg");
    background-position: center;
    background-size: cover;
}

.signup .form-details {
    padding: 0 20px;
    background: url("img/login1.jpg");
    background-position: center;
    background-size: cover;
}

.form-box .form-content {
    width: 100%;
    padding: 35px;
    margin-bottom: 50px;
    margin-top: 30px;
}

.form-box h2 {
    text-align: center;
    margin-bottom: 29px;
    margin-bottom: 29px;
    
}

form .input-field {
    position: relative;
    height: 50px;
    width: 100%;
    margin-top: 20px;
}

.input-field input {
    height: 100%;
    width: 100%;
    background: none;
    outline: none;
    font-size: 0.95rem;
    padding: 0 15px;
    border: 1px solid #717171;
    border-radius: 3px;
}

.input-field input:focus {
    border: 1px solid blue;
}

.input-field label {
    position: absolute;
    top: 50%;
    left: 15px;
    transform: translateY(-50%);
    color: #4a4646;
    pointer-events: none;
    transition: 0.2s ease;
}

.input-field input:is(:focus, :valid) {
    padding: 16px 15px 0;
}

.input-field input:is(:focus, :valid)~label {
    transform: translateY(-120%);
    color: blue;
    font-size: 0.75rem;
}

.form-box a {
    color: darkblue;
    text-decoration: none;
}

.form-box a:hover {
    text-decoration: underline;
}

form :where(.forgot-pass-link, .policy-text) {
    display: inline-flex;
    margin-top: 13px;
    font-size: 0.95rem;
}

form button {
    width: 100%;
    color: #fff;
    border: none;
    outline: none;
    padding: 14px 0;
    font-size: 1rem;
    font-weight: 500;
    border-radius: 3px;
    cursor: pointer;
    margin: 25px 0;
    background: darkblue;
    transition: 0.2s ease;
}

form button:hover {
    background: blue;
}

.form-content .bottom-link {
    text-align: center;
}

.form-popup .signup,
.form-popup .login {
    display: none;
}

.form-popup.show-signup .signup {
    display: flex;
}

.form-popup.show-login .login {
    display: flex;
}

.form-popup.show-forgot-password .forgot-password{
    display: flex;
}

.signup .policy-text {
    display: flex;
    margin-top: 14px;
    align-items: center;
}

.signup .policy-text input {
    width: 14px;
    height: 14px;
    margin-right: 7px;
}

#overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: none;
    z-index: 999;
}

.exclude-overlay {
    z-index: 1000; 
}

.custom-dropdown-item {
        color: blue; 
        font-weight: bold; 
        cursor: pointer;
    }

.form-popup .forgot-password {
    display: none;
}


    @media (max-width: 760px) {
    .form-popup {
        width: 95%;
    }
    .form-box .form-details {
        display: none;
    }
    .form-box .form-content {
        padding: 30px 20px;
    }
}

@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap');

footer{
  position: relative;
  background: white;
  width: 100%;
  bottom: 0;
  left: 0;
}
footer::before{
  content: '';
  position: absolute;
  left: 0;
  top: 100px;
  height: 1px;
  width: 100%;
  background: #AFAFB6;
}
footer .content12{
  max-width: 1250px;
  margin: auto;
  padding: 30px 40px 40px 40px;
}
footer .content12 .top{
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 50px;
}
.content12 .top .logo-details{
  color: #4267B2;
  font-size: 30px;
}
.content12 .top .media-icons{
  display: flex;
}
.content12 .top .media-icons a{
  height: 40px;
  width: 40px;
  margin: 0 8px;
  border-radius: 50%;
  text-align: center;
  line-height: 40px;
  color: #fff;
  font-size: 17px;
  text-decoration: none;
  transition: all 0.4s ease;
  cursor: pointer;
}
.top .media-icons a:nth-child(1){
  background: #4267B2;
}
.top .media-icons a:nth-child(1):hover{
  color: #4267B2;
  background: #fff;
}
.top .media-icons a:nth-child(2){
  background: #1DA1F2;
}
.top .media-icons a:nth-child(2):hover{
  color: #1DA1F2;
  background: #fff;
}
.top .media-icons a:nth-child(3){
  background: #E1306C;
}
.top .media-icons a:nth-child(3):hover{
  color: #E1306C;
  background: #fff;
}
.top .media-icons a:nth-child(4){
  background: #0077B5;
}
.top .media-icons a:nth-child(4):hover{
  color: #0077B5;
  background: #fff;
}
.top .media-icons a:nth-child(5){
  background: #FF0000;
}
.top .media-icons a:nth-child(5):hover{
  color: #FF0000;
  background: #fff;
}
footer .content12 .link-boxes{
  width: 100%;
  display: flex;
  justify-content: space-between;
}
footer .content12 .link-boxes .box{
  width: calc(100% / 5 - 10px);
}
.content12 .link-boxes .box .link_name{
  color: black;
  font-size: 18px;
  font-weight: 400;
  margin-bottom: 10px;
  position: relative;
}
.link-boxes .box .link_name::before{
  content: '';
  position: absolute;
  left: 0;
  bottom: -2px;
  height: 2px;
  width: 35px;
  background: #4267B2;
}
.content12 .link-boxes .box li{
  margin: 6px 0;
  list-style: none;
}
.content12 .link-boxes .box li a{
  color: black;
  font-size: 14px;
  font-weight: 400;
  text-decoration: none;
  opacity: 0.8;
  transition: all 0.4s ease
}
.content12 .link-boxes .box li a:hover{
  opacity: 1;
  text-decoration: underline;
  cursor: pointer;
}
.content12 .link-boxes .input-box{
  margin-right: 55px;
}
.link-boxes .input-box input{
  height: 40px;
  width: calc(100% + 55px);
  outline: none;
  border: 2px solid darkblue ;
  background: white;
  border-radius: 4px;
  padding: 0 15px;
  font-size: 15px;
  color: darkblue;
  margin-top: 5px;
}
.link-boxes .input-box input::placeholder{
  color: darkblue;
  font-size: 16px;
}
.link-boxes .input-box input[type="button"]{
  background: darkblue;
  color: white;
  border: none;
  font-size: 18px;
  font-weight: 500;
  margin: 4px 0;
  opacity: 0.8;
  cursor: pointer;
  transition: all 0.4s ease;
}
.input-box input[type="button"]:hover{
  opacity: 1;
}
footer .bottom-details{
  width: 100%;
  background: #0F0844;
}
footer .bottom-details .bottom_text{
  max-width: 1250px;
  margin: auto;
  padding: 20px 40px;
  display: flex;
  justify-content: space-between;
}
.bottom-details .bottom_text span,
.bottom-details .bottom_text a{
  font-size: 14px;
  font-weight: 300;
  color: #fff;
  opacity: 0.8;
  text-decoration: none;
}
.bottom-details .bottom_text a:hover{
  opacity: 1;
  text-decoration: underline;
  cursor: pointer;
}
.bottom-details .bottom_text a{
  margin-right: 10px;
}
@media (max-width: 900px) {
  footer .content12 .link-boxes{
    flex-wrap: wrap;
  }
  footer .content12 .link-boxes .input-box{
    width: 40%;
    margin-top: 10px;
  }
}
@media (max-width: 700px){
  footer{
    position: relative;
  }
  .content12 .top .logo-details{
    font-size: 26px;
  }
  .content12 .top .media-icons a{
    height: 35px;
    width: 35px;
    font-size: 14px;
    line-height: 35px;
  }
  footer .content12 .link-boxes .box{
    width: calc(100% / 3 - 10px);
  }
  footer .content12 .link-boxes .input-box{
    width: 60%;
  }
  .bottom-details .bottom_text span,
  .bottom-details .bottom_text a{
    font-size: 12px;
  }
}
@media (max-width: 520px){
  footer::before{
    top: 145px;
  }
  footer .content12 .top{
    flex-direction: column;
  }
  .content12 .top .media-icons{
    margin-top: 16px;
  }
  footer .content12 .link-boxes .box{
    width: calc(100% / 2 - 10px);
  }
  footer .content12 .link-boxes .input-box{
    width: 100%;
  }
}






</style>
</head>


  
  <body id="body" style="height: 2000px;">

   <nav class="navbar fixed-top navbar-expand-sm navbar-dark" style="background-color:white">
        <div class="container-fluid">
        <a 
        href="#"
        class="navbar-brand mb-0 h1"> 
        <img class="d-inline-block align-center me-2" src="logo1.jpg"
             width="200" height="auto"></a>

             <button 
             type="button" 
             data-bs-toggle="collapse" 
             data-bs-target="#navbarNav" 
             class="navbar-toggler"
             aria-controls="navbarNav"
             aria-expanded="false"
             aria-label="Toggle navigation"
             
             >
              <span class="navbar-toggler-icon"></span>

             </button>

             <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto" >
                       <li class="nav-item-active" >
                        <a href="#" class="nav-link active" style="color: darkblue;">
                            <strong>&#128948;GigHub Pro </strong>
                        </a>
                        <li class="nav-item">
                            <a href="#" class="nav-link" style="color: darkblue;">
                                <strong>Blog</strong>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="sellerform.html" class="nav-link" style="color: darkblue;">
                                <strong>Become a Seller</strong>
                            </a>
                        </li>

                        <?php
if (isset($_SESSION["username"])) {
    echo '<li class="nav-item dropdown">';
    echo '<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: darkblue; font-weight: bolder;">';
    echo 'Welcome, ' . $_SESSION["username"];
    echo '</a>';
    echo '<div class="dropdown-menu" aria-labelledby="navbarDropdown">';
    echo '<a class="dropdown-item custom-dropdown-item" href="profile.php">Profile</a>';
    echo '<div class="dropdown-divider"></div>';
    echo '<a href="index.php?logout=true" class="dropdown-item custom-dropdown-item">Logout</a>';
    echo '</div>';
    echo '</li>';
} else {
    echo '<li class="nav-item"><a href="#" onclick="toggle()" id="signInLink" class="nav-link" style="color: darkblue;"><strong>Sign In</strong></a></li>';
    echo '<li class="nav-item nav-item-join"><a href="#" onclick="toggle()" id="joinInLink" class="nav-link" style="margin-right: 100px; color: darkblue;"><strong>Join In</strong></a></li>';
}

?>


                        
                        
                    </li>
                </ul>
             </div>
             
             
            </div>
    </nav>
    
    
    

    <div id="overlay-container" style="margin-top: 90px;">
        <video id="background-video" src="video1.mp4" autoplay loop muted playsinline></video>
        <div id="overlay-content">
            <div id="title">Quickly discover the right freelancing <br>service for you..</div>
                <form action="search-result.php" method="GET">
                <input type="text" name="keywords" placeholder="Search for any services...">
                <button type="submit">Search</button>
                </form>
            </div>
        </div>
    </div>

    <div class="container-fluid  py-4" id="content1">
        <div class="row">
            <div class="col-md-8">
                <h1 style="font-size: 30px;">The best part? Everything.</h1> <br> <br>
                    <p>&#10148; Stick to your budget <br>
                    Find the right service for every price point. No hourly rates, just project-based pricing. <br><br>
                    
                    &#10148; Get quality work done quickly <br>
                    Hand your project over to a talented freelancer in minutes, get long-lasting results. <br> <br>
                    
                    &#10148; Pay when you're happy <br>
                    Upfront quotes mean no surprises. Payments only get released when you approve. <br><br>
                    
                    &#10148; Count on 24/7 support <br>
                    Our round-the-clock support team is available to help anytime, anywhere. </p>
            </div>
            <div class="col-md-4 d-flex justify-content-center align-items-center">
                <img src="img/pixel 1.jpg" alt="Image Description" class="img-fluid" style="border: 1px solid gray;">
            </div>
        </div>
    </div>
    <br> <br> <br>
    
    <div class="container-fluid">
      <div class="row mx-auto">
        <h1 class="header" style="font-size: 30px;"><strong>You need it, we've got it</strong></h1><br>

        <div class="col-12 col-md-4 col-sm-6 mb-4 clickable-area " data-service-page="graphics.php">
                <img src="img/web-design.png" class="mx-auto d-block img-fluid" alt="" width="150px" height="150px"><br>
                <p class="lead text-center"><b>Graphics & Design</b></p>
            
       </div> 
                   
            <div class="col-12 col-md-4 col-sm-6 mb-4 clickable-area" data-service-page="program.php">
                <img src="img/code.png" class="mx-auto d-block img-fluid" alt="" width="150px" height="150px"><br>
                <p class="lead text-center"><b>Programming & Tech</b></p>
            </div>        
         
            <div class="col-12 col-md-4 col-sm-6 mb-4 clickable-area" data-service-page="marketing.php">
                <img src="img/digital-marketing.png" class="mx-auto d-block img-fluid" alt="" width="150px" height="150px"><br>
                <p class="lead text-center"><b>Digital Marketing</b></p>
            </div>
  
          <div class="col-12 col-md-4 col-sm-6 mb-4 clickable-area" data-service-page="writing.php">
              <img src="img/content.png" class="mx-auto d-block img-fluid" alt="" width="150px" height="150px"><br>
              <p class="lead text-center"><b>Writing & Translation</b></p>
          </div>
  
          <div class="col-12 col-md-4 col-sm-6 mb-4 clickable-area" data-service-page="video.php">
              <img src="img/film-editing.png" class="mx-auto d-block img-fluid" alt="" width="150px" height="150px"><br>
              <p class="lead text-center"><b>Video & Animation</b></p>
          </div>
  
          <div class="col-12 col-md-4 col-sm-6 mb-4 clickable-area" data-service-page="music.php">
              <img src="img/audio-visual.png" class="mx-auto d-block img-fluid" alt="" width="150px" height="150px"><br>
              <p class="lead text-center"><b>Music & Audio</b></p>
          </div>
<br><br><br>
          

      </div>
    </div>  

    <div class="form-popup exclude-overlay"id="loginForm">
        <div class="form-box login">
            <div class="form-details">
                <h2>Welcome Back..</h2>
               <p> &#11166; Log in to your account securely</p>
               <p> &#11166; Stay connected with our community of talented freelancers and businesses worldwide.</p>
            </div>
            <div class="form-content">
                <h2>Sign In</h2>
                <form action="login.php" method="post">
                    <div class="input-field">
                        <input type="text" name="email" required>
                        <label>Email</label>
                    </div>
                    <div class="input-field">
                        <input type="password" name="password" required>
                        <label>Password</label>
                    </div>
                    <br>
                    <a href="#" id="forgot-password-link">Forgot Password?</a>
                    <button type="submit">Log In</button>
                </form>
                <div class="bottom-link">
                    Don't have an account?
                    <a href="#" id="signup-link">Signup</a>
                </div>
            </div>
        </div>

        <div class="form-box forgot-password">
            <div class="form-content">
                <h2>Forgot Password</h2>
                <form method="post" action="send-password-reset.php">
                <div class="input-field">
                        <input type="text" name="email" required>
                        <label>Enter your email</label>
                    </div>
                    <button type="submit">Send</button>
                </form>
                </div>
        </div> 


        <div class="form-box signup">
            <div class="form-details">
                <h2>Your success starts here!</h2>
                <p>&#11166; Join our community to unleash the power of collaboration. </p>
                 <p>&#11166; Sign up now to connect with over 600 categories. </p>
                 <p>&#11166; Work on exciting projects and access a global network.</p>
                 <p>&#11166; Connect with talented freelancers and businesses.</p>
            </div>
            <div class="form-content">
                <h2>Create An Account</h2>
                <form action="register.php" method="post">
                    <div class="input-field">
                        <input type="text" name="email" required>
                        <label>Enter your email</label>
                    </div>
                    <div class="input-field">
                        <input type="text" name="username" required>
                        <label>Enter your username</label>
                    </div>
                    <div class="input-field">
                        <input type="password" name="password" required>
                        <label>Enter your password</label>
                    </div>
                    <div class="input-field">
                        <input type="password" name="password_confirmation" required>
                        <label>Confirm password</label>
                    </div>
                    <div class="policy-text">
                        <input type="checkbox" id="policy">
                        <label for="policy">
                            I agree to the<a href="#" class="option"> Terms & Conditions</a>
                        </label>
                    </div>
                    <button type="submit">Sign Up</button>
                </form>
                <div class="bottom-link">
                    Already have an account? 
                    <a href="#" id="login-link">Login</a>
                </div>
            </div>
        </div>
       

 </div>


<div id="overlay"></div>

<footer>
    <div class="content12">
      <div class="top">
        <div class="logo-details">
          <span class="logo_name"><img src="logo1" alt="" width="200px" height="auto"> </span>
        </div>
        <div class="media-icons">
          <a href="#"><i class="fab fa-facebook-f"></i></a>
          <a href="#"><i class="fab fa-twitter"></i></a>
          <a href="#"><i class="fab fa-instagram"></i></a>
          <a href="#"><i class="fab fa-linkedin-in"></i></a>
          <a href="#"><i class="fab fa-youtube"></i></a>
        </div>
      </div>
      <div class="link-boxes">
        <ul class="box">
          <li class="link_name">Company</li>
          <li><a href="index.php">Home</a></li>
          <li><a href="#">Contact us</a></li>
          <li><a href="#">About us</a></li>
          <li><a href="#">Get started</a></li>
        </ul>
        <ul class="box">
          <li class="link_name">Services</li>
          <li><a href="graphics.php">Graphic & Design</a></li>
          <li><a href="program.php">Programming & Tech</a></li>
          <li><a href="marketing.php">Digital Marketing</a></li>
          <li><a href="writing.php">Writing & Translation</a></li>
          <li><a href="video.php">Video & Animation</a></li>
          <li><a href="music.php">Music & Audio</a></li>
        </ul>
        <ul class="box">
          <li class="link_name">Account</li>
          <li><a href="profile.php">Profile</a></li>
          <li><a href="profile.php">My account</a></li>
          <li><a href="#">Prefrences</a></li>
          <li><a href="#">Purchase</a></li>
        </ul>
        <ul class="box input-box">
          <li class="link_name">Subscribe</li>
          <li><input type="text" placeholder="Enter your email"></li>
          <li><input type="button" value="Subscribe"></li>
        </ul>
      </div>
    </div>
    <div class="bottom-details">
      <div class="bottom_text">
        <span class="copyright_text">Copyright &#169; 2024 <a href="#">AkinduB.</a>All rights reserved</span>
        <span class="policy_terms">
          <a href="#">Privacy policy</a>
          <a href="#">Terms & condition</a>
        </span>
      </div>
    </div>
</footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

  


    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const clickableAreas = document.querySelectorAll('.clickable-area');
            const formPopup = document.querySelector(".form-popup");
            const overlay = document.getElementById("overlay");
            const joinInLink = document.getElementById("joinInLink");
            const signInLink = document.getElementById("signInLink");

            function showSignupForm() {
                formPopup.classList.add("show-signup");
                formPopup.classList.remove("show-login");
                overlay.style.display = 'block';
                document.body.classList.add("blur-bg-overlay");
                document.body.style.overflow = 'hidden';
            }

            function showLoginForm() {
                formPopup.classList.add("show-login");
                formPopup.classList.remove("show-signup");
                overlay.style.display = 'block';
                document.body.classList.add("blur-bg-overlay");
                document.body.style.overflow = 'hidden';
            }

            function hideFormPopup() {
                formPopup.classList.remove("show-signup", "show-login");
                overlay.style.display = 'none';
                document.body.classList.remove("blur-bg-overlay");
                document.body.style.overflow = 'auto';
            }

            function closePopupOnOverlayClick(event) {
                if (!event.target.closest('.exclude-overlay')) {
                    hideFormPopup();
                }
            }

            function redirectToPage(page) {
                window.location.href = page;
            }

            joinInLink.addEventListener("click", function (event) {
                event.preventDefault();
                hideFormPopup();
                showSignupForm();
            });

            signInLink.addEventListener("click", function (event) {
                event.preventDefault();
                hideFormPopup();
                showLoginForm();
            });

            const closeBtn = formPopup.querySelector(".close-btn");

            overlay.addEventListener("click", closePopupOnOverlayClick);

            const signupLink = document.getElementById("signup-link");
            const loginLink = document.getElementById("login-link");

            signupLink.addEventListener("click", function (event) {
                event.preventDefault();
                hideFormPopup();
                showSignupForm();
            });

            loginLink.addEventListener("click", function (event) {
                event.preventDefault();
                hideFormPopup();
                showLoginForm();
            });

            const isUserLoggedIn = <?php echo isset($_SESSION["username"]) ? 'true' : 'false'; ?>;

            if (isUserLoggedIn) {
                if (joinInLink) {
                    joinInLink.style.display = "none";
                }

                if (signInLink) {
                    signInLink.style.display = "none";
                }
            }

            clickableAreas.forEach(function (area) {
                area.addEventListener('click', function (event) {
                    const isUserLoggedIn = <?php echo isset($_SESSION["username"]) ? 'true' : 'false'; ?>;

                    if (!isUserLoggedIn) {
                        event.preventDefault();
                        showLoginForm();
                    } else {
                        const servicePage = area.getAttribute('data-service-page');
                        redirectToPage(servicePage);
                    }
                });

            });
            overlay.addEventListener("click", function (event) {
                if (!event.target.closest('.exclude-overlay')) {
                    hideFormPopup();
                }
            });

            function redirectToPage(page) {
                window.location.href = page;
            }
        });
    </script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const clickableAreas = document.querySelectorAll('.clickable-area');
        const formPopup = document.querySelector(".form-popup");
        const overlay = document.getElementById("overlay");
        const forgotPasswordLink = document.getElementById("forgot-password-link");

        function showLoginForm() {
            formPopup.classList.add("show-login");
            formPopup.classList.remove("show-signup", "show-forgot-password");
            overlay.style.display = 'block';
            document.body.classList.add("blur-bg-overlay");
            document.body.style.overflow = 'hidden';
        }

        function showForgotPasswordForm() {
            formPopup.classList.add("show-forgot-password");
            formPopup.classList.remove("show-login", "show-signup");
            overlay.style.display = 'block';
            document.body.classList.add("blur-bg-overlay");
            document.body.style.overflow = 'hidden';
        }

        function hideFormPopup() {
            formPopup.classList.remove("show-login", "show-signup", "show-forgot-password");
            overlay.style.display = 'none';
            document.body.classList.remove("blur-bg-overlay");
            document.body.style.overflow = 'auto';
        }

        clickableAreas.forEach(function (area) {
            area.addEventListener('click', function (event) {
                const isUserLoggedIn = <?php echo isset($_SESSION["username"]) ? 'true' : 'false'; ?>;

                if (!isUserLoggedIn) {
                    event.preventDefault();
                    showLoginForm();
                } else {
                    const servicePage = area.getAttribute('data-service-page');
                    redirectToPage(servicePage);
                }
            });
        });

        overlay.addEventListener("click", function (event) {
            if (!event.target.closest('.exclude-overlay')) {
                hideFormPopup();
            }
        });

        forgotPasswordLink.addEventListener("click", function (event) {
            event.preventDefault();
            hideFormPopup();
            showForgotPasswordForm();
        });

        function redirectToPage(page) {
            window.location.href = page;
        }
    });
</script>


<script>
    document.addEventListener("DOMContentLoaded", function () {
        const clickableAreas = document.querySelectorAll('.clickable-area');
        const formPopup = document.querySelector(".form-popup");
        const overlay = document.getElementById("overlay");

        function showLoginForm() {
            formPopup.classList.add("show-login");
            overlay.style.display = 'block';
            document.body.classList.add("blur-bg-overlay");
            document.body.style.overflow = 'hidden';
        }

        function hideFormPopup() {
            formPopup.classList.remove("show-login");
            overlay.style.display = 'none';
            document.body.classList.remove("blur-bg-overlay");
            document.body.style.overflow = 'auto';
        }

        clickableAreas.forEach(function (area) {
            area.addEventListener('click', function (event) {
    
                const isUserLoggedIn = <?php echo isset($_SESSION["username"]) ? 'true' : 'false'; ?>;

                if (!isUserLoggedIn) {
                    event.preventDefault();
                    showLoginForm();
                } else {
                    const servicePage = area.getAttribute('data-service-page');
                    redirectToPage(servicePage);
                }
            });
        });

        overlay.addEventListener("click", function (event) {
            if (!event.target.closest('.exclude-overlay')) {
                hideFormPopup();
            }
        });

        function redirectToPage(page) {
            window.location.href = page;
        }
    });
</script>



   

</body>
</html>