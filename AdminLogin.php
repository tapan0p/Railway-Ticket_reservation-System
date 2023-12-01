<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <link rel="stylesheet" href="loginStyle.css">
</head>
<body>
    <div class="container">
        <h1>Admin Login</h1>
        <form method="post">
            <div>
                <label for="user">User ID</label>
                <input type="text" id="user" name="user" required>
            </div>
            <div>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Login</button>
        </form>
        <?php
        $error = ''; // Initialize the error variable
        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $servername = "localhost"; 
            $port_no = 3306; 
            $myDB= "train_db";
            $user = $_POST['user'];
            $password = $_POST['password'];

            try {
                $conn = new PDO("mysql:host=$servername;port=$port_no;dbname=$myDB", $user, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                session_start();
                $_SESSION['email'] = $email; 
                header("Location: AdminDashboard.php"); 
                exit();
            } catch(PDOException $e) {
                $error = "Admin access failed: ";
            }
        }
        ?>
        <p><?php echo $error; ?></p>
    </div>
</body>
</html>
