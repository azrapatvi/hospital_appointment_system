<?php
$servername = "localhost";
$username = "root";
$password = "";
$db = "hospital";

$conn = mysqli_connect($servername, $username, $password, $db);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize user input
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $message = htmlspecialchars($_POST['message']);

    $sql = "INSERT INTO `query` (`name`, `email`, `phone`, `message`) 
            VALUES ('$name', '$email', '$phone', '$message')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('✅ Your query has been submitted successfully!');</script>";
    } else {
        echo "<script>alert('❌ Unable to submit your query. Please try again.');</script>";
    }

}

mysqli_close($conn);
?>
