<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Stations</title>
    <link rel="stylesheet" href="EditStationStyle.css">
</head>
<body>
    <h1>Station Management Options</h1>

    <div class="options">
        <div class="option">
            <a href="?action=change" id="change-stations-link">Change Station Details</a>
        </div>
        <div class="option">
            <a href="?action=delete" id="delete-stations-link">Delete Station</a>
        </div>
        <div class="option">
            <a href="?action=add" id="add-stations-link">Add Station</a>
        </div>
    </div>

    <?php
    if (isset($_GET['action']) && $_GET['action'] === 'change') {
        echo '<div class="change-station-form">
            <h2>Change Station Details</h2>
            <form method="post">
                <label for="old-station-name">Old Station Name:</label>
                <input type="text" id="old-station-name" name="old-station-name" required><br><br>
    
                <label for="new-station-name">New Station Name:</label>
                <input type="text" id="new-station-name" name="new-station-name" required><br><br>
    
                <input type="submit" value="Change Station Details">
            </form>
        </div>';
    }
    elseif (isset($_GET['action']) && $_GET['action'] === 'delete') {
        echo '<div class="delete-station-form">
            <h2>Delete Station</h2>
            <form method="post">
                <label for="station-id-delete">Enter Station ID to Delete:</label>
                <input type="text" id="station-id-delete" name="station-id-delete" required><br><br>
            
                <input type="submit" value="Delete Station">
            </form>
        </div>';
    }
    elseif (isset($_GET['action']) && $_GET['action'] === 'add') {
        echo '<div class="add-station-form">
            <h2>Add New Station</h2>
            <form method="post">
                <label for="station-name">Station Name:</label>
                <input type="text" id="station-name" name="station-name" required><br><br>

                <!-- Other station details fields can be added here -->

            <input type="submit" value="Add Station">
            </form>
        </div>';

    }
    

    ?>
    <?php


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
    if (isset($_POST["station-id-delete"])) {
        $stationIdToDelete = $_POST["station-id-delete"];

        // Begin a transaction to ensure atomicity
        $conn->begin_transaction();

        // Delete related records in the classseats table that reference the station to be deleted
        $stmtDeleteClassSeats = $conn->prepare("DELETE FROM classseats WHERE sp = ?");
        $stmtDeleteClassSeats->bind_param("s", $stationIdToDelete);

        if ($stmtDeleteClassSeats->execute()) {
            // Now, delete the station from the station table
            $stmtDeleteStation = $conn->prepare("DELETE FROM station WHERE id = ?");
            $stmtDeleteStation->bind_param("i", $stationIdToDelete);

            if ($stmtDeleteStation->execute()) {
                echo "Station with ID $stationIdToDelete deleted successfully!";
            } else {
                echo "Error deleting station: " . $stmtDeleteStation->error;
            }

            $stmtDeleteStation->close();
        } else {
            echo "Error deleting related records in classseats table: " . $stmtDeleteClassSeats->error;
        }

        $stmtDeleteClassSeats->close();

        // Commit or rollback the transaction based on the deletion status
        if (!$conn->commit()) {
            $conn->rollback();
            echo "Transaction failed: Rollback executed.";
        }
    }

    elseif (isset($_POST["station-name"])) {
        $stationName = $_POST["station-name"];

        // Prepare a statement to insert the new station into the station table
        $stmtInsertStation = $conn->prepare("INSERT INTO station (sname) VALUES (?)");
        $stmtInsertStation->bind_param("s", $stationName);

        if ($stmtInsertStation->execute()) {
            echo "Station '$stationName' added successfully!";
        } else {
            echo "Error adding station: " . $stmtInsertStation->error;
        }

        $stmtInsertStation->close();
    }
    elseif (isset($_POST["old-station-name"]) && isset($_POST["new-station-name"])) {
        $oldStationName = $_POST["old-station-name"];
        $newStationName = $_POST["new-station-name"];

        // Prepare a statement to update the station name in the station table
        $stmtUpdateStation = $conn->prepare("UPDATE station SET sname = ? WHERE sname = ?");
        $stmtUpdateStation->bind_param("ss", $newStationName, $oldStationName);

        if ($stmtUpdateStation->execute()) {
            echo "Station '$oldStationName' updated to '$newStationName' successfully!";
        } else {
            echo "Error updating station: " . $stmtUpdateStation->error;
        }

        $stmtUpdateStation->close();
    }    
}

$conn->close();
?>

</body>
</html>
