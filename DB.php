<?php

$host = "localhost"; // Replace with your MySQL host name
$dbname = "test"; // Replace with your MySQL database name
$username = "root"; // Replace with your MySQL username
$password = ""; // Replace with your MySQL password

try {
  $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}

?>
