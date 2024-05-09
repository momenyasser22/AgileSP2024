<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get username and password from the form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Database connection
    require_once 'dbconnect.php'; // Include your database connection file

    // Query to fetch user with provided username and password
    $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = $conn->query($query);

    // If user found, set session and redirect to dashboard
    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        $_SESSION['UserID'] = $user['UserID'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['usertype'] = $user['usertype']; // Assuming user type ID is stored in 'user_type_id' column
        // Redirect to view.php with UserID and usertype in the URL
        header("Location: view.php?UserID={$user['UserID']}&usertype={$user['usertype']}");
        exit();
    } else {
        // If user not found, display error message
        $error = "Invalid username or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <?php if(isset($error)): ?>
        <p><?php echo $error; ?></p>
    <?php endif; ?>
    <form action="login.php" method="post">
        <div>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username">
        </div>
        <div>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password">
        </div>
        <div>
            <button type="submit">Login</button>
        </div>
    </form>
</body>
</html>
