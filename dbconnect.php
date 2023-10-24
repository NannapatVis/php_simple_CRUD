<?php
    //1.connect to mysql database
    $host = "localhost"; //or 127.0.0.1
    $db_user = "root";
    $db_passwd = "";
    $db_name = "testdb";
    $con = mysqli_connect($host, $db_user, $db_passwd, $db_name) or die("Error: ไม่สามารถเชื่อมฐานข้อมูลได้ " . mysqli_error($con));
?>
