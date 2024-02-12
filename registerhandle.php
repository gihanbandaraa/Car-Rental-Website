<?php
// Include the Conn.php file to establish a database connection
include("Php/Conn.php");

// Retrieve form data
$username = $_POST["username"];
$email = $_POST["email"];
$password = $_POST["password"];

// Hash the password for security
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Set the user_type to "user"
$user_type = "user";

// Insert data into the database
try {
    // Connect to the database
    $conn = Conn::GetConnection();
    
    // Prepare the SQL statement
    $stmt = $conn->prepare("INSERT INTO users (username, email, password, user_type) VALUES (:username, :email, :password, :user_type)");
    
    // Bind parameters
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $hashed_password);
    $stmt->bindParam(':user_type', $user_type);
    
    // Execute the statement
    $stmt->execute();
    
    // Close the connection
    $conn = null;
    
    // Display an alert message
    echo "<script>alert('Registration successful!');</script>";
    
    // Redirect to the login page
    header("Location: Php/login.php");
    exit();
} catch(PDOException $e) {
    // Display an error message if registration fails
    echo "Error: " . $e->getMessage();
}
?>
