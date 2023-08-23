<?php
try {
    $mysql['host'] = 'localhost'; //database host
    $mysql['username'] = 'root'; //username ที่เชื่อมต่อฐานข้อมูล
    $mysql['password'] = ''; //password สำหรับ username
    $mysql['database'] = 'etuter'; //ชื่อฐานข้อมูล

    $connSystem = new PDO(
        "mysql:host=" . $mysql['host'] . "; dbname=" . $mysql['database'] . ";charset=utf8mb4",
        $mysql['username'],
        $mysql['password'],
        // [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"]
        // array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'")
    ); //กำหนดการเชื่อมต่อเป็น utf8

} catch (PDOException $e) { //ดักจับ ERROR แล้วเก็บไว้ใน $e
    echo $e->getMessage(); # แสดงออกมาหน้าจอ
}
