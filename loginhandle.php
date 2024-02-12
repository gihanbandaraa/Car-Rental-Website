<?php
// Start the session
session_start();

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include the Conn.php file to establish a database connection
include("Php/Conn.php");

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $email = $_POST["email"];
    $password = $_POST["password"];

    try {
        // Connect to the database
        $conn = Conn::GetConnection();
        
        // Prepare the SQL statement
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
        
        // Bind parameters
        $stmt->bindParam(':email', $email);
        
        // Execute the statement
        $stmt->execute();
        
        // Fetch user data
        $user = $stmt->fetch();
        
        // Verify the password
        if ($user && password_verify($password, $user['password'])) {
            // Store user information in session variables
            $_SESSION['user_id'] = $user['Id'];
            $_SESSION['email'] = $user['email'];
            
            // Debug: Check session variables
            var_dump($_SESSION);
            
            // Redirect to home.php
            header("Location: Home.php");
            exit();
        } else {
            // Redirect back to the login page with an error message
            header("Location: Php/login.php?error=invalid_credentials");
            exit();
        }
    } catch(PDOException $e) {
        // Display an error message if login fails
        echo "Error: " . $e->getMessage();
    }
} else {
    // Redirect back to the login page if the form is not submitted
    header("Location: Php/login.php");
    exit();
}
?>
