<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Ticket</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            
        }

        .container {
            display: flex;
            justify-content: space-between;
            max-width: 1000px;
            width: 100%;
            text-align: center;
        }

        .table-container {
            flex: 1;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: left;
            margin-right: 20px;
        }

        .train-table, .form-container {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .train-table th, .train-table td {
            border: 1px solid #ddd;
            padding: 15px;
            text-align: left;
        }

        .train-table th {
            background-color: #4caf50;
            color: #fff;
        }

        .form-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: left;
        }

        h1 {
            color: #333;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
        }

        input, select {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 15px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        button {
            background-color: #4caf50;
            color: #fff;
            padding: 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
        }

        button:hover {
            background-color: #45a049;
        }

        p {
            text-align: center;
            margin-top: 20px;
            color: #555;
        }
    </style>
</head>
<body>

<?php
// Ensure the train number is provided in the URL
if (isset($_GET['trainno'])) {
    $trainNo = $_GET['trainno'];

    // Retrieve train details from the database based on the train number
    try {
        $servername = "localhost";
        $port_no = 3306;
        $username = "user_1";
        $password = "pass_1";
        $myDB = "train_db";

        $conn = new PDO("mysql:host=$servername;port=$port_no;dbname=$myDB", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT * FROM train WHERE trainno = :trainNo";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':trainNo', $trainNo, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // Display train details in a horizontal table
            echo "<div class='container'>";
            
            echo "<div class='table-container'>";
            echo "<h1>Train Details</h1>";
            echo "<table class='train-table'>";
            echo "<tr><th>Train No:</th><td>" . $row["trainno"] . "</td></tr>";
            echo "<tr><th>Train Name:</th><td>" . $row["tname"] . "</td></tr>";
            echo "<tr><th>From:</th><td>" . $row["sp"] . "</td></tr>";
            echo "<tr><th>To:</th><td>" . $row["dp"] . "</td></tr>";
            echo "<tr><th>Departure Time:</th><td>" . $row["st"] . "</td></tr>";
            echo "<tr><th>Arrival Time:</th><td>" . $row["dt"] . "</td></tr>";
            echo "<tr><th>Day:</th><td>" . $row["dd"] . "</td></tr>";
            echo "<tr><th>Distance:</th><td>" . $row["distance"] . "</td></tr>";
            echo "</table>";
            echo "</div>";

            // Add a form for booking, with additional attributes
            echo "<div class='form-container'>";
            echo "<h1>Book Your Ticket</h1>";
            echo "<form method='post'>";
            echo "<input type='hidden' name='trainNo' value='" . $row["trainno"] . "'>";
            
            echo "<label for='passengerName'>Passenger Name:</label>";
            echo "<input type='text' id='passengerName' name='passengerName' required><br>";
            
            echo "<label for='passengerAge'>Passenger Age:</label>";
            echo "<input type='number' id='passengerAge' name='passengerAge' required><br>";
            
            echo "<label for='passengerGender'>Passenger Gender:</label>";
            echo "<select id='passengerGender' name='passengerGender'>
                    <option value='M'>Male</option>
                    <option value='F'>Female</option>
                  </select><br>";

            echo "<label for='mobileNumber'>Mobile Number:</label>";
            echo "<input type='text' id='mobileNumber' name='mobileNumber' required><br>";
            
            echo "<label for='email'>Email:</label>";
            echo "<input type='email' id='email' name='email' required><br>";

            echo "<label for='password'>Password:</label>";
            echo "<input type='password' id='password' name='password' required><br>";

            echo "<label for='numSeats'>Number of Seats:</label>";
            echo "<input type='number' id='numSeats' name='numSeats' required><br>";

            echo "<label for='ticketClass'>Ticket Class:</label>";
            echo "<select id='ticketClass' name='ticketClass'>
                    <option value='ac1'>AC1</option>
                    <option value='ac2'>AC2</option>
                    <option value='sleeper'>Sleeper</option>
                    <option value='general'>General</option>
                  </select><br>";

            echo "<button type='submit'>Book Ticket</button>";
            echo "</form>";
            echo "</div>";

            echo "</div>";
        } else {
            echo "<p>Train details not found.</p>";
        }
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
} else {
    echo "<p>Train number not provided.</p>";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $trainNo = $_POST['trainNo'];
    $pname = $_POST['passengerName'];
    $page = $_POST['passengerAge'];
    $pgender = $_POST['passengerGender'];
    $mobileNumber = $_POST['mobileNumber'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $numSeats = $_POST['numSeats'];
    $ticketClass = $_POST['ticketClass'];

    try {
        $servername = "localhost";
        $port_no = 3306;
        $username = "user_1";
        $password = "pass_1";
        $myDB = "train_db";

        $conn = new PDO("mysql:host=$servername;port=$port_no;dbname=$myDB", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare the SQL statement to insert the booking details into a bookings table
        $sql = "INSERT INTO pd (pname,page,pgender)
                VALUES (:pname, :page, :pgender)";
        
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':pname', $pname);
        $stmt->bindParam(':page', $page);
        $stmt->bindParam(':pgender', $pgender);
        

        $stmt->execute();

        echo "Ticket booked successfully!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {

}
?>


</body>
</html>
