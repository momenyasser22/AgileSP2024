<?php
require_once 'UsersController.php';
// Instantiate the controller
$usersController = new UsersController();

// Check if the form is submitted for updating an existing user
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    // Validate and sanitize the input
    $userID = $_POST['userID'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $name = $_POST['name'];
    $usertype = $_POST['usertype'];
    $address = $_POST['address'];

    // Update the user
    $updateSuccess = $usersController->updateUser($userID, $username, $password, $name, $usertype, $address);

    if ($updateSuccess) {
        // Redirect back to the users view page
        header("Location: UsersView.php");
        exit();
    } else {
        // If update failed, handle the error (e.g., display an error message)
        echo "Failed to update user.";
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

    <h2>Update User</h2>

    <!-- Form for updating an existing user -->
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div>
            <label for="userID">User ID:</label>
            <input type="text" id="userID" name="userID">
        </div>
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
            <button type="submit" name="update">Update User</button>
        </div>
    </form>
</body>
</html>
