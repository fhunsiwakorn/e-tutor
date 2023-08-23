<?php
try {
    $mysql['host'] = 'localhost'; //database host
    $mysql['username'] = 'root'; //username ที่เชื่อมต่อฐานข้อมูล
    $mysql['password'] = ''; //password สำหรับ username
    $mysql['database'] = 'etuter'; //ชื่อฐานข้อมูล

    $connSystem = new PDO(
        "mysql:host=" . $mysql['host'] . "; dbname=" . $mysql['database'] . ";charset=utf8",
        $mysql['username'],
        $mysql['password']
    );
} catch (PDOException $e) { //ดักจับ ERROR แล้วเก็บไว้ใน $e
    echo $e->getMessage(); # แสดงออกมาหน้าจอ
}
