<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "cingdata";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm-password'];

if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
    echo "Please fill out all fields";
    exit();
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "Please enter a valid email";
    exit();
}
if ($password !== $confirm_password) {
    echo "Passwords do not match";
    exit();
}

// Hash the password
$password_hashed = password_hash($password, PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $username, $email, $password_hashed);

if ($stmt->execute()) {
    // Redirect to the main page
    header("Location: main.html");
    exit();
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>