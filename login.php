<?php
    // Connect to the MySQL server
    $db = new mysqli("hostname", "username", "password", "mydb");
    // Check if the form is submitted
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        // Sanitize the inputs
        $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
        $password = filter_var($_POST["password"], FILTER_SANITIZE_STRING);

        //Validate the email address
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            echo "Invalid Email Address";
            die();
        }
        // get the user data from the database
        $stmt = $db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        //verify the password
        if(password_verify($password, $user["password"])) {
            // Redirect the user to the main page
            header("Location: main.html");
        } else {
            echo 'Invalid Credentials';
        }
        $stmt->close();
    }
?>
