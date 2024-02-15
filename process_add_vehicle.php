<?php
include_once("Php/Conn.php");
include_once("Php/vehicleClass.php");




// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $title = $_POST["vehicle_name"];
    $description = $_POST["description"];
    $price = $_POST["price"];
    $phone_number = $_POST["phone_number"];
    $time_duration = $_POST["time_duration"];
    $user_name = $_POST["user_name"]; // Retrieve username from form
    $user_email = $_POST["email"]; // Retrieve email from form

    // Handle file upload
    if (isset($_FILES["image_file"]) && $_FILES["image_file"]["error"] == 0) {
        $targetDirectory = "uploads/";
        $fileName = basename($_FILES["image_file"]["name"]);
        $targetFilePath = $targetDirectory . $fileName;

        // Check if the file already exists
        if (file_exists($targetFilePath)) {
            echo "Sorry, the file already exists.";
        } else {
            // Attempt to move the uploaded file to the target directory
            if (move_uploaded_file($_FILES["image_file"]["tmp_name"], $targetFilePath)) {
                try {
                    // Create a new instance of the Vehicle class
                    $vehicle = new Vehicle();

                    // Add the vehicle to the database
                    $vehicleID = $vehicle->AddVehicle($title, $description, $price, $targetFilePath, $phone_number, $time_duration, $user_name, $user_email);
                    
                    // Redirect to the success page
                    header("Location: add_vehicle_success.php");
                    exit();
                } catch (Exception $ex) {
                    // If an error occurs, delete the uploaded file
                    unlink($targetFilePath);
                    echo "Error adding vehicle: " . $ex->getMessage();
                }
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    } else {
        echo "Please select an image file.";
    }
} else {
    // Redirect to the form page if the form is not submitted
    header("Location: add_vehicle_form.php");
    exit();
}
?>
