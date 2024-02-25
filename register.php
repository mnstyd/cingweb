<?php
    //connect to the database
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "cingdata";
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    //get the data from the form
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];

    //validate the data
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

    //hash the password
    $password = password_hash($password, PASSWORD_DEFAULT);

    //insert the data into the table
    $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    //insert the data into the table
    $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
    if ($conn->query($sql) === TRUE) {
        // redirect to main page
        header("Location: main.html");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    //close the connection
    $conn->close();
?>