<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

require 'db_connect.php';

// Fetch user info (optional)
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Dashboard - Swift Aid</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Welcome, <?php echo htmlspecialchars($user['fullname']); ?>!</h1>
        <p>Your email: <?php echo htmlspecialchars($user['email']); ?></p>
        <p><a href="logout.php">Logout</a></p>
    </div>
</body>
</html>
