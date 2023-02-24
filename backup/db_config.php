<?php
$servername = "localhost";
$dbname = "tdl";
$dbusername = "root";
$dbpassword = "root";



try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $dbusername, $dbpassword);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully  ";
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>