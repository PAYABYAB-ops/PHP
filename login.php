<?php
include 'db.php'; // Include the database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $identifier = $_POST['identifier']; // Username or email
    $password = $_POST['password'];

    // Prepare the SQL statement to retrieve the hashed password
    $sql = "SELECT password FROM users WHERE username = ? OR email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ss", $identifier, $identifier);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $hashed_password);
        mysqli_stmt_fetch($stmt);

        // Verify the password
        if ($hashed_password && password_verify($password, $hashed_password)) {
            echo "Login successful!";
            // You can start a session and store user information if needed
            header('location: dashboard.html');
        } else {
            echo "Invalid username/email or password.";
        }

        mysqli_stmt_close($stmt); // Close the statement
    } else {
        echo "Error preparing the statement: " . mysqli_error($conn); // Error preparing the statement
    }
}

mysqli_close($conn); // Close the database connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="login.css">
    <title>Document</title>
</head>
<body>
    <!-- HTML form for login -->
<form action="login.php" method="post">
    <h1>KoJaFi</h1>
    Username or Email: <input type="text" name="identifier" required><br>
    Password: <input type="password" name="password" required><br>
    <input type="submit" value="Login">
    <p>Don't have an account? <a href="register.php">Register here</a></p>
</form>


</body>
</html>