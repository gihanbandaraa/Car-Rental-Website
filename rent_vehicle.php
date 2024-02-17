<?php
session_start();
include("Php/Conn.php");
include("Php/vehicleClass.php");


if (!isset($_GET['id'])) {
    header("Location: Home.php");
    exit();
}


$vehicleId = $_GET['id'];
$conn = Conn::GetConnection();
$stmt = $conn->prepare("SELECT * FROM Vehicles WHERE Id = :vehicle_id");
$stmt->bindParam(':vehicle_id', $vehicleId);
$stmt->execute();
$vehicle = $stmt->fetch(PDO::FETCH_ASSOC);


if (!$vehicle) {
    header("Location: Home.php"); // Redirect to homepage if vehicle not found
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rent Vehicle</title>
    <link rel="stylesheet" href="Css/homepage.css">
    <link rel="stylesheet" href="Css/rentVehicle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>
    <nav class="navbar">
        <div class="navbar-container">
            <div class="brand">
                <a href="#">SL<Span class="subbrand">Moto</Span></a>
            </div>
            <ul class="nav-links">
                <li><a href="./Home.php">Home</a></li>
                <li><a href="#vehicle-list-container">Vehicles</a></li>
                <li><a href="#">About</a></li>
                <li><a href="#">Contact</a></li>
                <li><a href="./Php/add_vehicle_form.php">Post</a></li>
            </ul>
            <div class="mobile-menu">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <div class="account">
                <?php

                if (isset($_SESSION['user_id'])) {
                    echo '<div class="dropdown">';
                    echo '<button class="dropbtn"><i class="fas fa-user-circle"></i></button>';
                    echo '<div class="dropdown-content">';
                    echo '<a href="Php/account.php">Account</a>';
                    echo '<a href="Php/logout.php">Logout</a>';
                    echo '<a href="Php/activeJob.php">Active Job</a>';
                    echo '</div>';
                    echo '</div>';
                } else {
                    echo '<a href="./Php/login.php" class="login-btn">Login/Register</a>';
                }
                ?>
            </div>
        </div>
    </nav>
    <h1 style="text-align: center; font-size:2.5rem;margin:20px">Rent Vehicle</h1>

    <!-- Display vehicle details -->
    <div class="vehicle-details">
        <div class="vehicle-image">
            <img src="<?php echo $vehicle['Image']; ?>" alt="<?php echo $vehicle['Title']; ?>">
        </div>
        <div class="vehicle-info">
            <h2 style="font-size: 2rem;color:red;"><?php echo $vehicle['Title']; ?></h2>
            <p>Description: <?php echo $vehicle['Description']; ?></p>
            <p>Location: <?php echo $vehicle['Location']; ?></p>
            <p>Price: Rs. <?php echo $vehicle['Price']; ?> per day</p>
            <p>Phone Number: <?php echo $vehicle['Phone_Number']; ?></p>
            <p>Active Days: <?php echo $vehicle['Time_Duration']; ?></p>
            <p>User Name: <?php echo $vehicle['User_Name']; ?></p>
            <p>User Email: <?php echo $vehicle['User_Email']; ?></p>
        </div>
    </div>

    <div class="form-container">
        <div class="terms">
            <h3>Terms and Conditions:</h3>
            <ul>
                <li>Renters must be at least 18 years old.</li>
                <li>A valid driver's license is required to rent a vehicle.</li>
                <li>Vehicle rental rates are subject to change without prior notice.</li>
                <li>Additional charges may apply for late returns or damages to the vehicle.</li>
                <li>Smoking and pets are not allowed in the rental vehicles.</li>
                <li>Payment must be made in full before renting a vehicle.</li>
                <li>Refunds are subject to the company's refund policy.</li>
                <li>By renting a vehicle, you agree to abide by the terms and conditions set forth by the rental company.</li>
            </ul>
        </div>

        <form action="./rent_process.php" method="POST" class="rent-form">
           
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required><br><br>

            <label for="phone">Phone Number:</label>
            <input type="tel" id="phone" name="phone" required><br><br>

            <label for="duration">Rental Duration (in days):</label>
            <input type="number" id="duration" name="duration" required><br><br>

            <input type="hidden" name="vehicle_id" value="<?php echo $vehicleId; ?>">
            <button type="submit" class="rent-btn">Rent Now</button>
        </form>


    </div>


</body>

</html>