<?php
    // การเชื่อมต่อฐานข้อมูลใน PHP
    $servername = "localhost";
    $dbname = "hack";  // ระบุชื่อฐานข้อมูลที่คุณสร้างไว้
    $username = "root";  // ชื่อผู้ใช้ MySQL
    $password = "";  // รหัสผ่าน MySQL

    try {
        // ใช้ PDO เชื่อมต่อฐานข้อมูล
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // ตอนนี้สามารถใช้งานตาราง `users` และ `projects` ได้
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
?>
