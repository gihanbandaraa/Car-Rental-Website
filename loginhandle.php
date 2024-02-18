<?php

session_start();


error_reporting(E_ALL);
ini_set('display_errors', 1);


include("Php/Conn.php");


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST["email"];
    $password = $_POST["password"];

    try {
     
        $conn = Conn::GetConnection();

       
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");

       
        $stmt->bindParam(':email', $email);

 
        $stmt->execute();

       
        $user = $stmt->fetch();

   
        if ($user && password_verify($password, $user['password'])) {
          
            $_SESSION['user_id'] = $user['Id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['user_name'] = $user['username'];
            $_SESSION['user_type'] = $user['user_type'];

            if ($user['user_type'] === 'user') {
                header("Location: Home.php");
            } elseif ($user['user_type'] === 'admin') {
                header("Location: admin.php");
            } else {
            }
            exit();

            var_dump($_SESSION);
        } else {
          
            header("Location: Php/login.php?error=invalid_credentials");
            exit();
        }
    } catch (PDOException $e) {
       
        echo "Error: " . $e->getMessage();
    }
} else {
   
    header("Location: Php/login.php");
    exit();
}
