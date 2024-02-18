<?php
session_start();
include("Php/Conn.php");


if (!isset($_GET['id'])) {
    header("Location: Home.php"); 
    exit();
}


$vehicleId = $_GET['id'];

try {
  
    $conn = Conn::GetConnection();

    $stmt = $conn->prepare("SELECT * FROM vehicle_rental WHERE vehicle_id = :vehicle_id");
    $stmt->bindParam(':vehicle_id', $vehicleId);
    $stmt->execute();
    $rentalDetails = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($rentalDetails) {
        
        echo "<h1>Rent Success</h1>";
        echo "<h2>Rented Vehicle Details:</h2>";
        echo "<p>Name: " . $rentalDetails['name'] . "</p>";
        echo "<p>Email: " . $rentalDetails['email'] . "</p>";
        echo "<p>Phone Number: " . $rentalDetails['phone'] . "</p>";
        echo "<p>Rental Duration (in days): " . $rentalDetails['rental_duration'] . "</p>";
        echo "<p>Status: " . $rentalDetails['status'] . "</p>";
      
    } else {
        echo "No rental details found for the provided vehicle ID.";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
