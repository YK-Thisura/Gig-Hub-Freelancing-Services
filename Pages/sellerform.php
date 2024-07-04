<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    
    include('database.php');


    // Sanitize and validate data
    $firstName = mysqli_real_escape_string($mysqli, $_POST["firstName"]);
    $lastName = mysqli_real_escape_string($mysqli, $_POST["lastName"]);
    $displayName = mysqli_real_escape_string($mysqli, $_POST["displayName"]);
    $description = mysqli_real_escape_string($mysqli, $_POST["description"]);
    $country = mysqli_real_escape_string($mysqli, $_POST["country"]);
    $service = mysqli_real_escape_string($mysqli, $_POST["service"]);
    $skills = isset($_POST["skills"]) ? implode(", ", $_POST["skills"]) : '';
    $education = mysqli_real_escape_string($mysqli, $_POST["education"]);
    $website = mysqli_real_escape_string($mysqli, $_POST["website"]);
    $email = mysqli_real_escape_string($mysqli, $_POST["email"]);
    $password = password_hash(mysqli_real_escape_string($mysqli, $_POST["password"]), PASSWORD_BCRYPT);
    $phoneNumber = mysqli_real_escape_string($mysqli, $_POST["phonenumber"]);

    // Function to handle profile picture upload
    $profilePicturePath = uploadProfilePicture();

    // Insert data into the database
    $sql = "INSERT INTO sellerinformation 
            (firstName, lastName, displayName, description, country, service, skills, education, website, email, password, phoneNumber, profilePicturePath)
            VALUES 
            ('$firstName', '$lastName', '$displayName', '$description', '$country', '$service', '$skills', '$education', '$website', '$email', '$password', '$phoneNumber', '$profilePicturePath')";

    if ($mysqli->query($sql) === TRUE) {
        // Data inserted successfully, redirect to success page
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $mysqli->error;
    }

    // Close the database connection
    $mysqli->close();
}

// Function to handle profile picture upload
function uploadProfilePicture() {
    $targetDirectory = "profile_pictures/"; // Set the target directory
    $targetFile = $targetDirectory . basename($_FILES["profilePicture"]["name"]); // Get the file name

    // Check if the file is an actual image
    $check = getimagesize($_FILES["profilePicture"]["tmp_name"]);
    if ($check !== false) {
        // Check if the file already exists
        if (file_exists($targetFile)) {
            echo "Sorry, the file already exists.";
            return null;
        }

        // Upload the file
        if (move_uploaded_file($_FILES["profilePicture"]["tmp_name"], $targetFile)) {
            return $targetFile; // Return the file path
        } else {
            echo "Sorry, there was an error uploading your file.";
            return null;
        }
    } else {
        echo "File is not an image.";
        return null;
    }
}
?>
