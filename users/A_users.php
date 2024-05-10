<?php
require_once 'UsersController.php';

// Instantiate the controller
$usersController = new UsersController();

// Check if the form is submitted for adding a new user
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
    // Validate and sanitize the input
    $username = $_POST['username'];
    $password = $_POST['password'];
    $name = $_POST['name'];
    $usertype = $_POST['usertype'];
    $address = $_POST['address'];

    // Add the new user
    $addSuccess = $usersController->addUser($username, $password, $name, $usertype, $address);

    if ($addSuccess) {
        // Redirect back to the users view page
        header("Location: UsersView.php");
        exit();
    } else {
        // If addition failed, handle the error (e.g., display an error message)
        echo "Failed to add user.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add/Update User</title>
</head>
<body>
    <h2>Add User</h2>

    <!-- Form for adding a new user -->
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username">
        </div>
        <div>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password">
        </div>
        <div>
            <label for="name">Name:</label>
            <input type="text" id="name" name="name">
        </div>
        <div>
            <label for="usertype">User Type:</label>
            <input type="text" id="usertype" name="usertype">
        </div>
        <div>
            <label for="address">Address:</label>
            <input type="text" id="address" name="address">
        </div>
        <div>
            <button type="submit" name="add">Add User</button>
        </div>
    </form>
    </body>
    </html>
