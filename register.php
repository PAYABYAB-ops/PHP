<?php
include 'db.php'; // Include the database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if username or email already exists
    $sql_check = "SELECT COUNT(*) FROM users WHERE username = ? OR email = ?";
    $stmt_check = mysqli_prepare($conn, $sql_check);
    
    if ($stmt_check) {
        mysqli_stmt_bind_param($stmt_check, "ss", $username, $email);
        mysqli_stmt_execute($stmt_check);
        mysqli_stmt_bind_result($stmt_check, $existing_count);
        
        // Store the result to avoid sync issues
        mysqli_stmt_store_result($stmt_check);
        mysqli_stmt_fetch($stmt_check); // Fetch the result

        if ($existing_count > 0) {
            echo "Error: Username or email already taken.";
        } else {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Prepare the SQL statement to insert the user
            $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "sss", $username, $email, $hashed_password);

                // Execute the statement
                if (mysqli_stmt_execute($stmt)) {
                    echo "Registration successful!";
                } else {
                    echo "Error: " . mysqli_error($conn);
                }

                mysqli_stmt_close($stmt); // Close the insert statement
            } else {
                echo "Error preparing the statement: " . mysqli_error($conn);
            }
        }

        mysqli_stmt_close($stmt_check); // Close the check statement
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
    <link rel="stylesheet" type="text/css" href="register.css">
    <title>Register</title>
</head>
<body>
    <!-- HTML form for registration -->
    <form action="register.php" method="post">
        Username: <input type="text" name="username" required><br>
        Email: <input type="email" name="email" required><br>
        Password: <input type="password" name="password" required><br>
        <input type="submit" value="Register">
        <p>Already have an account? <a href="login.php">Log in here</a></p>
    </form>
    
</body>
</html>
