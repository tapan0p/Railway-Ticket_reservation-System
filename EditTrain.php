<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Stations</title>
    <link rel="stylesheet" href="EditTrainStyle.css">
</head>
<body>
    <h1>Train Management Options</h1>

    <div class="options">
        <div class="option">
            <a href="?action=change" id="change-train-link">Change Train Details</a>
        </div>
        <div class="option">
            <a href="?action=delete" id="delete-train-link">Delete Train</a>
        </div>
        <div class="option">
            <a href="?action=add" id="add-train-link">Add Train</a>
        </div>
    </div>

    <?php
    if (isset($_GET['action']) && $_GET['action'] === 'add') {
        // Show the form for adding a new train
        echo '
        <div class="add-train-form" id="add-train-form">
            <h2>Add New Train</h2>
            <form method="post">
                <label for="train-no">Train Number:</label>
                <input type="text" id="train-no" name="train-no" required><br><br>

                <label for="train-name">Train Name:</label>
                <input type="text" id="train-name" name="train-name" required><br><br>

                <label for="start-point">Starting Point:</label>
                <input type="text" id="start-point" name="start-point" required><br><br>

                <label for="arrival-time">Arrival Time:</label>
                <input type="time" id="arrival-time" name="arrival-time" required><br><br>

                <label for="destination-point">Destination Point:</label>
                <input type="text" id="destination-point" name="destination-point" required><br><br>

                <label for="departure-time">Departure Time:</label>
                <input type="time" id="departure-time" name="departure-time" required><br><br>

                <label for="day">Day:</label>
                <input type="text" id="day" name="day" required><br><br>

                <label for="distance">Distance:</label>
                <input type="text" id="distance" name="distance" required><br><br>

                <input type="submit" value="Add Train">
            </form>
        </div>';
    }
    else if (isset($_GET['action']) && $_GET['action'] === 'change') {
        // Show the form for change a new train
        echo '
        <div class="add-train-form" id="change-train-form">
            <h2>Change New Train</h2>
            <form method="post">
                <label for="train-no">Train Number:</label>
                <input type="text" id="train-no" name="train-no" required><br><br>

                <label for="train-name">Train Name:</label>
                <input type="text" id="train-name" name="train-name" required><br><br>

                <label for="start-point">Starting Point:</label>
                <input type="text" id="start-point" name="start-point" required><br><br>

                <label for="arrival-time">Arrival Time:</label>
                <input type="time" id="arrival-time" name="arrival-time" required><br><br>

                <label for="destination-point">Destination Point:</label>
                <input type="text" id="destination-point" name="destination-point" required><br><br>

                <label for="departure-time">Departure Time:</label>
                <input type="time" id="departure-time" name="departure-time" required><br><br>

                <label for="day">Day:</label>
                <input type="text" id="day" name="day" required><br><br>

                <label for="distance">Distance:</label>
                <input type="text" id="distance" name="distance" required><br><br>

                <input type="submit" value="Change Train">
            </form>
        </div>';
    }
    else if (isset($_GET['action']) && $_GET['action'] === 'delete') {
        // Show form for deleting a train by train number
        echo '
        <div class="delete-train-form" id="delete-train-form">
            <h2>Delete Train</h2>
            <form method="post">
                <label for="train-no-delete">Enter Train Number to Delete:</label>
                <input type="text" id="train-no-delete" name="train-no-delete" required><br><br>

                <input type="submit" value="Delete Train">
            </form>
        </div>';
    }
    ?>
    <?php
// process.php

// Establish a connection to your database
$servername = "localhost"; 
$port_no = 3306; 
$username = "user_1";
$password = "pass_1";
$dbname= "train_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["train-no-delete"])) {
        $trainNoToDelete = $_POST["train-no-delete"];

        // Prepare and bind the DELETE statement
        $stmt = $conn->prepare("DELETE FROM train WHERE trainno = ?");
        $stmt->bind_param("s", $trainNoToDelete);

        // Execute the statement
        if ($stmt->execute()) {
            echo "Train with number $trainNoToDelete deleted successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }

    elseif (isset($_POST["add-train-form"])) {
        $trainNo = $_POST["train-no"];
        $trainName = $_POST["train-name"];
        $startPoint = $_POST["start-point"];
        $arrivalTime = $_POST["arrival-time"];
        $destinationPoint = $_POST["destination-point"];
        $departureTime = $_POST["departure-time"];
        $day = $_POST["day"];
        $distance = $_POST["distance"];

        // Prepare and bind the INSERT statement
        $stmt = $conn->prepare("INSERT INTO train (trainno, tname, sp, st, dp, dt, dd, distance) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssi", $trainNo, $trainName, $startPoint, $arrivalTime, $destinationPoint, $departureTime, $day, $distance);

        // Execute the statement
        if ($stmt->execute()) {
            echo "New train added successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }
    elseif (isset($_POST["train-no"])) {
        $trainNo = $_POST["train-no"];
        $trainName = $_POST["train-name"];
        $startPoint = $_POST["start-point"];
        $arrivalTime = $_POST["arrival-time"];
        $destinationPoint = $_POST["destination-point"];
        $departureTime = $_POST["departure-time"];
        $day = $_POST["day"];
        $distance = $_POST["distance"];

        // Prepare and bind the UPDATE statement
        $stmt = $conn->prepare("UPDATE train SET tname=?, sp=?, st=?, dp=?, dt=?, dd=?, distance=? WHERE trainno=?");
        $stmt->bind_param("ssssssis", $trainName, $startPoint, $arrivalTime, $destinationPoint, $departureTime, $day, $distance, $trainNo);

        // Execute the statement
        if ($stmt->execute()) {
            echo "Train with number $trainNo updated successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }



    
}

$conn->close();
?>

</body>
</html>
