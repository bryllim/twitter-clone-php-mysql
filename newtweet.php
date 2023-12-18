<?php
session_start();
// Establish Database Configuration

// $host = 'locahost';
$host = 'localhost';
$username = 'root';
$password = 'root';
$database = 'twitter';

// Create database connection

$conn = new mysqli($host, $username, $password, $database);

if($_SERVER['REQUEST_METHOD'] == 'POST') {

    
    $body = $_POST['tweet'];
    $user_id = $_SESSION['user_id'];

    $sql = $conn->prepare("INSERT INTO tweets (body, user_id) VALUES (?, ?)");
    $sql->bind_param("ss", $body, $user_id);

    if($sql->execute()){
        header("location: index.php");
    }

    
}

?>