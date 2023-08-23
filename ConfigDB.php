<?php
//ระบบ SDC EXAM
// $servernameSystem = "127.0.0.1";
// $usernameSystem = "root";
// $passwordSystem = "cVAkB0E1kpN3SDcs";
// $databaseSystem="tbl_examtest";
// try {
//     $connSystem = new PDO("mysql:host=$servernameSystem;dbname=$databaseSystem", $usernameSystem, $passwordSystem);
//     // set the PDO error mode to exception
//     $connSystem->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//     $connSystem->exec("set names utf8");
//     //echo "Connected successfully";
//     }
// catch(PDOException $eSystem)
//     {
//     echo "Connection failed: " . $eSystem->getMessage();
//     }
try {
    $mysql['host'] = 'localhost'; //database host
    $mysql['username'] = 'root'; //username ที่เชื่อมต่อฐานข้อมูล
    $mysql['password'] = ''; //password สำหรับ username
    $mysql['database'] = 'etuter'; //ชื่อฐานข้อมูล

    $connSystem = new PDO(
        "mysql:host=" . $mysql['host'] . "; dbname=" . $mysql['database'] . "",
        $mysql['username'],
        $mysql['password'],
        // [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"]
    ); //กำหนดการเชื่อมต่อเป็น utf8

} catch (PDOException $e) { //ดักจับ ERROR แล้วเก็บไว้ใน $e
    echo $e->getMessage(); # แสดงออกมาหน้าจอ
}
