<?php

include_once("Php/Conn.php");

class Vehicle
{
    public $ID;
    public $Title;
    public $Description;
    public $Price;
    public $Image;
    public $Phone_Number;
    public $Time_Duration;
    public $User_Name;
    public $User_Email;

    // Method to add vehicle details
    public function AddVehicle($title, $description, $price, $image, $phone_number, $time_duration, $user_name, $user_email)
    {
        try {
            $query = "INSERT INTO `Vehicles` (`Title`, `Description`, `Price`, `Image`, `Phone_Number`, `Time_Duration`, `User_Name`, `User_Email`) 
                      VALUES (:Title, :Description, :Price, :Image, :Phone_Number, :Time_Duration, :User_Name, :User_Email)";
            $conn = Conn::GetConnection();
            $st = $conn->prepare($query);
            $st->bindValue(":Title", $title, PDO::PARAM_STR);
            $st->bindValue(":Description", $description, PDO::PARAM_STR);
            $st->bindValue(":Price", $price, PDO::PARAM_INT);
            $st->bindValue(":Image", $image, PDO::PARAM_STR);
            $st->bindValue(":Phone_Number", $phone_number, PDO::PARAM_STR);
            $st->bindValue(":Time_Duration", $time_duration, PDO::PARAM_STR);
            $st->bindValue(":User_Name", $user_name, PDO::PARAM_STR);
            $st->bindValue(":User_Email", $user_email, PDO::PARAM_STR);
            $st->execute();
            return $conn->lastInsertId();
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    // Method to get all vehicle details
    public static function GetVehicles()
    {
        try {
            $query = "SELECT `Id`, `Title`, `Description`, `Price`, `Image`, `Phone_Number`, `Time_Duration`, `User_Name`, `User_Email` FROM `Vehicles`";
            $conn = Conn::GetConnection();
            $vehicles = array();
            $result = $conn->query($query);
            foreach ($result as $row) {
                $vehicle = new Vehicle();
                $vehicle->ID = $row['Id'];
                $vehicle->Title = $row['Title'];
                $vehicle->Description = $row['Description'];
                $vehicle->Price = $row['Price'];
                $vehicle->Image = $row['Image'];
                $vehicle->Phone_Number = $row['Phone_Number'];
                $vehicle->Time_Duration = $row['Time_Duration'];
                $vehicle->User_Name = $row['User_Name'];
                $vehicle->User_Email = $row['User_Email'];
                array_push($vehicles, $vehicle);
            }
            return $vehicles;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    // Method to update vehicle details
    public function UpdateVehicle($id, $title, $description, $price, $image, $phone_number, $time_duration, $user_name, $user_email)
    {
        try {
            $query = "UPDATE `Vehicles` SET `Title`=:Title, `Description`=:Description, `Price`=:Price, `Image`=:Image,
                      `Phone_Number`=:Phone_Number, `Time_Duration`=:Time_Duration, `User_Name`=:User_Name, `User_Email`=:User_Email
                      WHERE `ID`=:ID";
            $conn = Conn::GetConnection();
            $st = $conn->prepare($query);
            $st->bindValue(":Title", $title, PDO::PARAM_STR);
            $st->bindValue(":Description", $description, PDO::PARAM_STR);
            $st->bindValue(":Price", $price, PDO::PARAM_INT);
            $st->bindValue(":Image", $image, PDO::PARAM_STR);
            $st->bindValue(":Phone_Number", $phone_number, PDO::PARAM_STR);
            $st->bindValue(":Time_Duration", $time_duration, PDO::PARAM_STR);
            $st->bindValue(":User_Name", $user_name, PDO::PARAM_STR);
            $st->bindValue(":User_Email", $user_email, PDO::PARAM_STR);
            $st->bindValue(":ID", $id, PDO::PARAM_INT);
            $st->execute();
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    // Method to delete vehicle details
    public function DeleteVehicle($id)
    {
        try {
            $query = "DELETE FROM `Vehicles` WHERE `ID`=:ID";
            $conn = Conn::GetConnection();
            $st = $conn->prepare($query);
            $st->bindValue(":ID", $id, PDO::PARAM_INT);
            $st->execute();
        } catch (Exception $ex) {
            throw $ex;
        }
    }
}

?>
