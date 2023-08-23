<?php
date_default_timezone_set('Asia/Bangkok');
///แสดง Error
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('memory_limit', '-1');
error_reporting(E_ALL);


$seceretKey = "k4pGvhg7GNKYznhWk4pGvhg7GNKYznhW";

class Database
{
    private $host = "localhost";
    private $db_name = "etuter";
    private $username = "root";
    private $password = "";
    public $conn;

    public function dbConnection()
    {

        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->exec("set names utf8");
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
