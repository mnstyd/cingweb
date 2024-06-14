<?php
// Connect to the database
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "cingdata";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the data from the form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate the data
    if (empty($email) || empty($password)) {
        echo "Please fill out all fields";
        exit();
    }

    // Prepare and bind the statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);

    // Execute the statement
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        // Verify the password
        if (password_verify($password, $user["password"])) {
            // Redirect to the main page or any other page
            header("Location: main.html");
            exit();
        } else {
            echo 'Invalid credentials';
        }
    } else {
        echo 'User not found';
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>