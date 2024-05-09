<?php
require_once 'dbconnect.php';
require_once 'DailyActivityController.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $db = Database::getInstance();
    $conn = $db->getConnection();

    $controller = new DailyActivityController(new DailyActivityModel($conn));

    $userId = $_POST['user_id'];
    $activityTypeId = $_POST['activityTypeId'];
    $dateReceived = $_POST['dateReceived'];
    $receivedBy = $_POST['receivedBy'];
    $timeLeaved = $_POST['timeLeaved'];

    $result = $controller->addDailyActivity($userId, $activityTypeId, $dateReceived, $receivedBy, $timeLeaved);
    
    if ($result) {
        echo "New daily activity added successfully!";
    } else {
        echo "Error adding new daily activity.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Daily Activity</title>
</head>
<body>
    <h2>Add New Daily Activity</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <label for="user_id">User ID:</label>
        <input type="text" id="user_id" name="user_id"><br><br>
        
        <label for="activityTypeId">Activity Type ID:</label>
        <input type="text" id="activityTypeId" name="activityTypeId"><br><br>
        
        <label for="dateReceived">Date Received:</label>
        <input type="date" id="dateReceived" name="dateReceived"><br><br>
        
        <label for="receivedBy">Received By:</label>
        <input type="text" id="receivedBy" name="receivedBy"><br><br>
        
        <label for="timeLeaved">Time Leaved:</label>
        <input type="time" id="timeLeaved" name="timeLeaved"><br><br>
        
        <input type="submit" value="Submit">
    </form>
</body>
</html>
