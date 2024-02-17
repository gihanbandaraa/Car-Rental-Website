<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include the Conn.php file to establish a database connection
include("Php/Conn.php");
include("Php/vehicleClass.php");
session_start();

// Debug: Check session variables
var_dump($_SESSION);

$vehicle = new Vehicle();
$vehicles = $vehicle->GetVehicles();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SLMoto | Home</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="./Css/homepage.css">
</head>

<body>
    <nav class="navbar">
        <div class="navbar-container">
            <div class="brand">
                <a href="#">SL<Span class="subbrand">Moto</Span></a>
            </div>
            <ul class="nav-links">
                <li><a href="./Home.php">Home</a></li>
                <li><a href="./allvehicle.php">Vehicles</a></li>
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
                // Check if the user is logged in
                if (isset($_SESSION['user_id'])) {
                    echo '<div class="dropdown">';
                    echo '<button class="dropbtn"><i class="fas fa-user-circle"></i></button>';
                    echo '<div class="dropdown-content">';
                    echo '<a href="./Php/account.php">Account</a>';
                    echo '<a href="./Php/logout.php">Logout</a>';
                    echo '<a href="./Php/activeJob.php">Active Job</a>';
                    echo '</div>';
                    echo '</div>';
                } else {
                    echo '<a href="./Php/login.php" class="login-btn">Login/Register</a>';
                }
                ?>
            </div>
        </div>
    </nav>
    <header class="header">
        <div class="header-content">
            <h1>Welcome to SL<span class="subtopic">Moto</span></h1>
            <p>Your ultimate destination for car rentals</p>
            <a href="./allvehicle.php" class="btn">Rent a Car</a>
        </div>
    </header>
    <h1 class="vehicle-list-heading">Available Vehicles for Rent</h1>
    <div class="vehicle-list-container" id="vehicle-list-container">
        <a href="./allvehicle.php" class="view-all-btn" style="text-decoration: none;">View All </a>
        <div class="vehicle-slideshow">
            <?php

            $chunkedVehicles = array_chunk($vehicles, 4);
            foreach ($chunkedVehicles as $chunk) {
                echo '<div class="vehicle-slide">';
                foreach ($chunk as $vehicle) {
                    echo '<div class="vehicle-card">';
                    echo '<img src="' . $vehicle->Image . '" alt="' . $vehicle->Title . '">';
                    echo '<h2>' . $vehicle->Title . '</h2>';
                    echo '<p>' . $vehicle->Description . '</p>';
                    echo '<p>Location: ' . $vehicle->Location . '</p>';
                    echo '<p>Price: Rs.' . $vehicle->Price . ' per day</p>';
                    echo '<button class="rent-btn" onclick="redirectToRentPage(' . $vehicle->ID . ')">Rent</button>';
                    echo '</div>';
                }
                echo '</div>';
            }
            ?>
        </div>
    </div>

    <script>
        const mobileMenu = document.querySelector('.mobile-menu');
        const navLinks = document.querySelector('.nav-links');
        mobileMenu.addEventListener('click', () => {
            mobileMenu.classList.toggle('active');
            navLinks.classList.toggle('show');
        });
    </script>
    <script>
        let slideIndex = 0;
        showSlides();

        function showSlides() {
            let slides = document.getElementsByClassName("vehicle-slide");

            for (let i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }

            slideIndex++;

            if (slideIndex > slides.length) {
                slideIndex = 1;
            }

            slides[slideIndex - 1].style.display = "flex";
            setTimeout(showSlides, 3000);
        }

        function redirectToRentPage(vehicleId) {
            window.location.href = './rent_vehicle.php?id=' + vehicleId;
        }
    </script>
</body>

</html>