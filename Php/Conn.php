<?php


class Conn
{
    public static function GetConnection()
    {
        try
        {
            $dsn ="mysql:dbname=sl moto";
            $username = "admin";
            $password ="admin";
            $conn = new PDO($dsn,$username,$password);

            $conn ->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

            return $conn;
        }
        catch(Exception $ex)
        {
            throw $ex;
        }
    }
}

?>