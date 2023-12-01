<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search for trains.</title>
    <style>
        /* Your existing styles remain unchanged */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        h1 {
            background-color: #333;
            color: #fff;
            padding: 20px;
            margin: 0;
        }

        #general {
            background-color: #fff;
            padding: 20px;
            margin: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        form {
            display: flex;
            flex-wrap: wrap;
        }

        label, input, select, button {
            margin: 10px;
            padding: 8px;
            border-radius: 5px;
        }

        button {
            background-color: #333;
            color: #fff;
            cursor: pointer;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #333;
            color: #fff;
        }
        #search-details {
            margin-top: 20px;
        }
    </style>
</head>
<body>

<h1>Search For Trains</h1>

<section id="general">
    <h2>SEARCH TRAINS</h2>
    <form method="post" action="">
        <label for="from">From:</label>
        <input type="text" id="from" name="from" required>

        <label for="to">To:</label>
        <input type="text" id="to" name="to" required>

        <label for="date">Select Date (dd-mm-yyyy):</label>
        <input type="date" id="date" name="date" required>

        <label for="ticket-type">Select Ticket Type:</label>
        <select id="ticket-type" name="ticket-type">
            <option value="general">General</option>
            <option value="ladies">Ladies</option>
            <option value="tatkal">Tatkal</option>
        </select>

        <br>
        <button type="submit">SEARCH</button>
    </form>

    <section id="search-details">
        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            echo "<h2>Search Details</h2>";
            echo "<p>From: " . htmlspecialchars($_POST['from']) . "</p>";
            echo "<p>To: " . htmlspecialchars($_POST['to']) . "</p>";
            echo "<p>Date: " . htmlspecialchars($_POST['date']) . "</p>";
            echo "<p>Ticket Type: " . htmlspecialchars($_POST['ticket-type']) . "</p>";
        }
        ?>
    </section>
</section>

<?php
// php code to connect with database and get result
$servername = "localhost";
$port_no = 3306;
$username = "user_1";
$password = "pass_1";
$myDB = "train_db";

try {
    $conn = new PDO("mysql:host=$servername;port=$port_no;dbname=$myDB", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $from = $_POST['from'];
        $to = $_POST['to'];
        $date = $_POST['date'];
        $ticketType = $_POST['ticket-type'];

        $sql = "SELECT * FROM train WHERE sp = '$from' AND dp = '$to'";
        $result = $conn->query($sql);

        if ($result->rowCount() > 0) {
            echo "<h2>Search Results</h2>";
            echo "<table>";
            echo "<tr><th>Train No</th><th>Train Name</th><th>Departure Time</th><th>Arrival Time</th><th>Day</th><th>Distance</th></tr>";
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>" . $row["trainno"] . "</td>";
                echo "<td>" . $row["tname"] . "</td>";
                echo "<td>" . $row["st"] . "</td>";
                echo "<td>" . $row["dt"] . "</td>";
                echo "<td>" . $row["dd"] . "</td>";
                echo "<td>" . $row["distance"] . "</td>";
                // Add a link to the booking page for each train
                echo "<td><a class='book-link' href='book_ticket.php?trainno=" . $row["trainno"] . "'>Book</a></td>";
                    
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No results found for the selected route.</p>";
        }
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>

</body>
</html>
