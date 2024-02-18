<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sl Moto | Account</title>
    <link rel="stylesheet" href="../Css/account.css">
    <link rel="stylesheet" href="../Css/homepage.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>

    <nav class="navbar">
        <div class="navbar-container">
            <div class="brand">
                <a href="#">SL<Span class="subbrand">Moto</Span></a>
            </div>
            <ul class="nav-links">
                <li><a href="../Home.php">Home</a></li>
                <li><a href="../allvehicle.php">Vehicles</a></li>
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
                    echo '<a href="account.php">Account</a>';
                    echo '<a href="logout.php">Logout</a>';
                    echo '<a href="activeJob.php">Active Job</a>';
                    echo '</div>';
                    echo '</div>';
                } else {
                    echo '<a href="./Php/login.php" class="login-btn">Login/Register</a>';
                }
                ?>
            </div>
        </div>
    </nav>
    <div class="wrapper">
        <div class="text">
            <h2>Welcome to Your Account</h2>
            <p>Manage your account details and reset your password here.</p>
            <img src="../Images/klipartz.com.png" alt="car-Image">
        </div>

        <div class="container">
            <h1>Account Information</h1>
            <div class="user-details">
                <p><strong>Username:</strong> <?php echo $_SESSION['user_name']; ?></p>
                <p><strong>Email:</strong> <?php echo $_SESSION['email']; ?></p>
            </div>
            
            <h2>Edit Details</h2>
            <form action="../update_details.php" method="POST" class="edit-form">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" value="<?php echo $_SESSION['user_name']; ?>" required><br><br>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo $_SESSION['email']; ?>" required><br><br>
                <input type="submit" value="Update Details">
            </form>
            <h2>Reset Password</h2>
            <form action="../reset_password.php" method="POST" class="reset-password-form">
                <label for="current_password">Current Password:</label>
                <input type="password" id="current_password" name="current_password" required><br><br>
                <label for="new_password">New Password:</label>
                <input type="password" id="new_password" name="new_password" required><br><br>
                <input type="submit" value="Reset Password">
            </form>
        </div>
    </div>
</body>

</html>