<!DOCTYPE html>
<html>
<head>
    <title>Schedule Management</title>
    <link rel="stylesheet" href="EditTrainScheduleStyle.css">
</head>
<body>
    <button onclick="showAddScheduleForm()">Add Schedule</button>
    <button onclick="showUpdateScheduleForm()">Update Schedule</button>
    <button onclick="showDeleteScheduleForm()">Delete Schedule</button>

    <!-- Add Schedule Form -->
    <div id="addScheduleForm" style="display:none;">
        <form method="POST">
            Train Number: <input type="text" name="trainno"><br><br>
            Station Name: <input type="text" name="sname"><br><br>
            Arrival Time: <input type="time" name="arrival_time"><br><br>
            Departure Time: <input type="time" name="departure_time"><br><br>
            Distance: <input type="text" name="distance"><br><br>
            <input type="submit" name="addSchedule" value="Add Schedule">
        </form>
    </div>

    <!-- Update Schedule Form -->
    <div id="updateScheduleForm" style="display:none;">
        <form method="POST">
            Schedule ID: <input type="text" name="idToUpdate"><br><br>
            Train Number: <input type="text" name="trainnoToUpdate"><br><br>
            Station Name: <input type="text" name="snameToUpdate"><br><br>
            Arrival Time: <input type="time" name="arrival_timeToUpdate"><br><br>
            Departure Time: <input type="time" name="departure_timeToUpdate"><br><br>
            Distance: <input type="text" name="distanceToUpdate"><br><br>
            <input type="submit" name="updateSchedule" value="Update Schedule">
        </form>
    </div>

    <!-- Delete Schedule Form -->
    <div id="deleteScheduleForm" style="display:none;">
        <form method="POST">
            ID to Delete: <input type="text" name="idToDelete"><br><br>
            <input type="submit" name="deleteSchedule" value="Delete Schedule">
        </form>
    </div>

    <script>
        function showAddScheduleForm() {
            document.getElementById("addScheduleForm").style.display = "block";
            document.getElementById("updateScheduleForm").style.display = "none";
            document.getElementById("deleteScheduleForm").style.display = "none";
        }

        function showUpdateScheduleForm() {
            document.getElementById("addScheduleForm").style.display = "none";
            document.getElementById("updateScheduleForm").style.display = "block";
            document.getElementById("deleteScheduleForm").style.display = "none";
        }

        function showDeleteScheduleForm() {
            document.getElementById("addScheduleForm").style.display = "none";
            document.getElementById("updateScheduleForm").style.display = "none";
            document.getElementById("deleteScheduleForm").style.display = "block";
        }
    </script>

<?php
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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addSchedule'])) {
    $trainno = $_POST['trainno'];
    $sname = $_POST['sname'];
    $arrival_time = $_POST['arrival_time'];
    $departure_time = $_POST['departure_time'];
    $distance = $_POST['distance'];

    $sql = "INSERT INTO schedule (trainno, sname, arrival_time, departure_time, distance) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $trainno, $sname, $arrival_time, $departure_time, $distance);

    if ($stmt->execute()) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $stmt->error;
    }
    $stmt->close();

}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['updateSchedule'])) {
    // Retrieve form data
    $idToUpdate = $_POST['idToUpdate'];
    $trainnoToUpdate = $_POST['trainnoToUpdate'];
    $snameToUpdate = $_POST['snameToUpdate'];
    $arrival_timeToUpdate = $_POST['arrival_timeToUpdate'];
    $departure_timeToUpdate = $_POST['departure_timeToUpdate'];
    $distanceToUpdate = $_POST['distanceToUpdate'];

    $stmt = $conn->prepare("UPDATE schedule SET trainno=?, sname=?, arrival_time=?, departure_time=?, distance=? WHERE id=?");
    $stmt->bind_param("sssssi", $trainnoToUpdate, $snameToUpdate, $arrival_timeToUpdate, $departure_timeToUpdate, $distanceToUpdate, $idToUpdate);
    if ($stmt->execute()) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }
    $stmt->close();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deleteSchedule'])) {
    $idToDelete = $_POST['idToDelete'];
    $stmt = $conn->prepare("DELETE FROM schedule WHERE id=?");
    $stmt->bind_param("i", $idToDelete);
    if ($stmt->execute()) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
    $stmt->close();
}



?>
</body>
</html>
