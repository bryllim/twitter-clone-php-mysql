<?php
session_start();

if(!isset($_SESSION['user_id'])){
    header("location: login.php");
}

// Establish Database Configuration

// $host = 'locahost';
$host = 'localhost';
$username = 'root';
$password = 'root';
$database = 'twitter';

// Create database connection

$conn = new mysqli($host, $username, $password, $database);

// Function to display tweets
function displayTweets(){

    global $conn;

    $sql = "SELECT * FROM  tweets
            JOIN users ON tweets.user_id = users.id ORDER BY date_posted DESC";
    $result = $conn->query($sql);

    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){

            echo '<div class="card p-3 my-3">';
            echo '<span class="fw-bold">'.$row['firstname']." ".$row['lastname'].'</span>';
            echo '<small class="text-secondary">🕐 '.date_format(date_create($row['date_posted']), "g:i A F j, Y").'</small>';
            echo '<p>'.$row['body'].'</p>';
            echo '</div>';
        }
    }else{
        echo "<p>There are currently no tweets available.</p>";
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
        <h1 class="fw-bold">🐦 Twitter</h1>
        <p>Connect with your friends.</p>

        <div class="container rounded border p-4">
            <h2 class="fw-bold">Welcome, <?php echo $_SESSION['firstname']." ".$_SESSION['lastname'] ?>! 👋🏻</h2>
            <small><a href="logout.php">Logout</a></small>
            <br>
            <br>
            <form method="POST" action="newtweet.php">
            <input type="text" class="form-control" name="tweet" placeholder="What's on your mind? 💬" required>
            <button class="btn btn-primary btn-sm mt-3" type="submit">Tweet</button>
            </form>
        </div>
        <div class="container rounded border p-4 mt-3">
            <h2 class="fw-bold mb-4">Recent tweets</h2>
            <?php
                displayTweets();
            ?>
        </div>

    </div>
</body>
</html>