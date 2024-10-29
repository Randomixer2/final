<?php
// Attempt to include database connection
if (file_exists('../db_connect/db_connect.php')) {
    include '../db_connect/db_connect.php';  
} else {
    die("Database connection file not found.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if POST variables are set
    if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password'])) {
        // Retrieve form data
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT); 

        // Prepare statement to check if email is already registered
        $check_email = "SELECT email FROM user WHERE email = ?";
        $stmt = $conn->prepare($check_email);

        if (!$stmt) {
            die("Error preparing statement: " . $conn->error);
        }

        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        // Check if email already exists
        if ($stmt->num_rows > 0) {
            echo "Email is already registered!";
        } else {
            // Prepare statement to insert new user
            $sql = "INSERT INTO user (username, email, password) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);

            if (!$stmt) {
                die("Error preparing insert statement: " . $conn->error);
            }

            // Bind parameters and execute
            $stmt->bind_param("sss", $username, $email, $password);

            if ($stmt->execute()) {
                echo "Registration successful! You can now <a href='login.php'>login</a>";
            } else {
                echo "Error executing statement: " . $stmt->error;  
            }

            $stmt->close();  
        }
    } else {
        echo "Please fill all the fields.";
    }
}

// Close the database connection
$conn->close();  
?>
