<?php
session_start();
include("Php/Conn.php");


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST['name'];
    $email = $_SESSION['email'];
    $phone = $_POST['phone'];
    $duration = $_POST['duration'];
    $vehicleId = $_POST['vehicle_id'];

    try {
  
        $conn = Conn::GetConnection();

      
        $stmt = $conn->prepare("SELECT * FROM Vehicles WHERE Id = :vehicle_id");
        $stmt->bindParam(':vehicle_id', $vehicleId);
        $stmt->execute();
        $vehicle = $stmt->fetch(PDO::FETCH_ASSOC);


        $stmt = $conn->prepare("INSERT INTO vehicle_rental (name, email, phone, rental_duration, vehicle_id, owner_name, owner_email, owner_phone) VALUES (:name, :email, :phone, :rental_duration, :vehicle_id, :owner_name, :owner_email, :owner_phone)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':rental_duration', $duration);
        $stmt->bindParam(':vehicle_id', $vehicleId);
        $stmt->bindParam(':owner_name', $vehicle['User_Name']);
        $stmt->bindParam(':owner_email', $vehicle['User_Email']);
        $stmt->bindParam(':owner_phone', $vehicle['Phone_Number']);
        $stmt->execute();

        $updateStmt = $conn->prepare("UPDATE Vehicles SET Status = 'pending' WHERE Id = :vehicle_id");
        $updateStmt->bindParam(':vehicle_id', $vehicleId);
        $updateStmt->execute();
       
        echo '<script>alert("Rent request successfully submitted!");</script>';

        echo '<script>
                setTimeout(function() {
                    window.location.href = "./Home.php";
                }, 2000); // 2000 milliseconds = 2 seconds
              </script>';
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
