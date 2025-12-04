<?php
// central DB connection
$db_host = 'mysql-9963341-noureldeenali42-97cf.l.aivencloud.com';
$db_user = 'Mahmoud_Hosny';
$db_pass = 'AVNS_aUIQ5zxZiYvzaW5QcVz'; 
$db_name = 'Hotel_System';
$db_port = 24857;        

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name, $db_port); //Connection to the DB
if ($conn->connect_error) {
    die('DB connection failed: ' . $conn->connect_error);
} // لو الconnection باظ يكتب error
$conn->set_charset('utf8mb4'); // (utf8mb4)ده بيخليه يدعم اللغة العربية وال emojisدهال utf 8
