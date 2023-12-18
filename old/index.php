<?php

// Establish Database Configuration

// $host = 'locahost';
$host = 'localhost';
$username = 'root';
$password = 'root';
$database = 'todolist';

// Create database connection

$conn = new mysqli($host, $username, $password, $database);

// Check connection
if($conn->connect_error){
    echo "Database connection failed.";
}


if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(isset($_POST['newtodo'])){
        // Add task to database
        $sql = "INSERT INTO todos (name, status) VALUES ('".$_POST['newtodo']."', 'pending')";
        $conn->query($sql);
    }
}

// Function to display todo list
function displayTodoList(){

    global $conn;

    $sql = "SELECT * FROM  todos";
    $result = $conn->query($sql);

    if($result->num_rows > 0){
        echo "<ul>";
        while($row = $result->fetch_assoc()){
            if($row['status'] == 'pending'){
                echo "<li>" .  $row['name'] . " <small class='badge bg-secondary'>PENDING</small></li>";
            }else{
                echo "<li>" .  $row['name'] . " <small class='badge bg-success'>COMPLETED</small></li>";
            }
            
        }
        echo "</ul>";
    }else{
        echo "<p>There are currently no tasks in the todo list.</p>";
    }
    
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
    <div class="container m-5 p-5 border shadow">
        <h1 class="fw-bold">📝 Todo List</h1>
        <p>Powered by <strong>PHP</strong> + <strong>MySQL</strong></p>
        <hr>

        <form method="POST" action="index.php">
            <input placeholder="Write your todo here..." type="text" name="newtodo" class="form-control" required>
            <button class="btn btn-dark btn-sm mt-2" type="submit">+ Add</button>
        </form>

        <hr>

        <?php
        displayTodoList();
        ?>
        
    </div>
</body>
</html>
