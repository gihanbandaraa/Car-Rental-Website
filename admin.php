<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: Php/login.php");
    exit();
}


include("Php/Conn.php");
include("Php/vehicleClass.php");

try {
    $conn = Conn::GetConnection();
    $stmt = $conn->query("SELECT COUNT(*) AS total_users FROM Users");
    $totalUsers = $stmt->fetch(PDO::FETCH_ASSOC)['total_users'];

    $stmt = $conn->query("SELECT COUNT(*) AS total_vehicles FROM Vehicles");
    $totalVehicles = $stmt->fetch(PDO::FETCH_ASSOC)['total_vehicles'];


    $stmt = $conn->query("SELECT COUNT(*) AS total_rentals FROM vehicle_rental");
    $totalRentals = $stmt->fetch(PDO::FETCH_ASSOC)['total_rentals'];
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="Css/admin.css">
    <link rel="stylesheet" href="styles.css">

</head>

<body>
    <nav class="navbar">
        <div class="navbar-container">
            <div class="brand">
                <a href="#">Admin Panel</a>
            </div>
            <ul class="nav-links">
                <li><a href="./admin.php">Dashboard</a></li>
                <li><a href="./manageAdmin.php">Admin</a></li>
                <li><a href="./allVehicleAdmin.php">Vehicles</a></li>
                <li><a href="Php/logout.php">Logout</a></li>
            </ul>
        </div>
    </nav>

    <div class="admin-content">
        <h1>Welcome, Admin!</h1>
        <div class="stats">
            <div class="stat-box">
                <h2>Total Users</h2>
                <p><?php echo $totalUsers; ?></p>
            </div>
            <div class="stat-box">
                <h2>Total Vehicles</h2>
                <p><?php echo $totalVehicles; ?></p>
            </div>
            <div class="stat-box">
                <h2>Total Rentals</h2>
                <p><?php echo $totalRentals; ?></p>
            </div>
        </div>

        <div class="container">
            <h2>Add Admin Accounts</h2>
            <form action="./adminRegisterHandle.php" method="post">
                <input type="text" name="username" placeholder="Username" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">Register</button>
            </form>
            <p>Already have an account? <a href="Php/login.php">Login</a></p>
        </div>

    </div>

</body>

</html>