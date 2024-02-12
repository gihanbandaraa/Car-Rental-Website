<?php

include_once("Php/Conn.php");

class Vehicle
{
    public $ID;
    public $Title;
    public $Description;
    public $Price;
    public $Image;

    // Method to add vehicle details
    public function AddVehicle($title, $description, $price, $image)
    {
        try {
            $query = "INSERT INTO `Vehicles` (`Title`, `Description`, `Price`, `Image`) VALUES (:Title, :Description, :Price, :Image)";
            $conn = Conn::GetConnection();
            $st = $conn->prepare($query);
            $st->bindValue(":Title", $title, PDO::PARAM_STR);
            $st->bindValue(":Description", $description, PDO::PARAM_STR);
            $st->bindValue(":Price", $price, PDO::PARAM_INT);
            $st->bindValue(":Image", $image, PDO::PARAM_STR);
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
            $query = "SELECT `ID`, `Title`, `Description`, `Price`, `Image` FROM `Vehicles`";
            $conn = Conn::GetConnection();
            $vehicles = array();
            $result = $conn->query($query);
            foreach ($result as $row) {
                $vehicle = new Vehicle();
                $vehicle->ID = $row['ID'];
                $vehicle->Title = $row['Title'];
                $vehicle->Description = $row['Description'];
                $vehicle->Price = $row['Price'];
                $vehicle->Image = $row['Image'];
                array_push($vehicles, $vehicle);
            }
            return $vehicles;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    // Method to update vehicle details
    public function UpdateVehicle($id, $title, $description, $price, $image)
    {
        try {
            $query = "UPDATE `Vehicles` SET `Title`=:Title, `Description`=:Description, `Price`=:Price, `Image`=:Image WHERE `ID`=:ID";
            $conn = Conn::GetConnection();
            $st = $conn->prepare($query);
            $st->bindValue(":Title", $title, PDO::PARAM_STR);
            $st->bindValue(":Description", $description, PDO::PARAM_STR);
            $st->bindValue(":Price", $price, PDO::PARAM_INT);
            $st->bindValue(":Image", $image, PDO::PARAM_STR);
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
