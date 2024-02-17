<?php
session_start();
include("Php/Conn.php");

// Check if the vehicle ID is provided
if (!isset($_GET['id'])) {
    header("Location: Home.php"); // Redirect to homepage if no ID is provided
    exit();
}


$vehicleId = $_GET['id'];

try {
    // Establish database connection
    $conn = Conn::GetConnection();

    // Fetch rented vehicle details from the vehicle_rental table
    $stmt = $conn->prepare("SELECT * FROM vehicle_rental WHERE vehicle_id = :vehicle_id");
    $stmt->bindParam(':vehicle_id', $vehicleId);
    $stmt->execute();
    $rentalDetails = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if rental details are found
    if ($rentalDetails) {
        // Display the rented vehicle details to the user
        echo "<h1>Rent Success</h1>";
        echo "<h2>Rented Vehicle Details:</h2>";
        echo "<p>Name: " . $rentalDetails['name'] . "</p>";
        echo "<p>Email: " . $rentalDetails['email'] . "</p>";
        echo "<p>Phone Number: " . $rentalDetails['phone'] . "</p>";
        echo "<p>Rental Duration (in days): " . $rentalDetails['rental_duration'] . "</p>";
        echo "<p>Status: " . $rentalDetails['status'] . "</p>";
        // You can display additional details here if needed
    } else {
        echo "No rental details found for the provided vehicle ID.";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
