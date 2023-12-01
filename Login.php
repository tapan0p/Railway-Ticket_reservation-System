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
        <h1>User Login</h1>
        <form method="post">
            <div>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Login</button>
        </form>
        <?php
        $error = ''; // Initialize the error variable
        
        $servername = "localhost"; 
        $port_no = 3306; 
        $username = "user_1";
        $password = "pass_1";
        $myDB= "train_db";

        try {
            $conn = new PDO("mysql:host=$servername;port=$port_no;dbname=$myDB", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $email = $_POST['email'];
                $password = $_POST['password'];
                
                $query = "SELECT * FROM user WHERE emailid = :email AND password = :password";
                $stmt = $conn->prepare($query);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':password', $password);
                $stmt->execute();
                
                
                if ($stmt->rowCount() > 0) {
                    session_start();
                    $_SESSION['email'] = $email; 
                    header("Location: SearchTrains.php"); 
                    exit();
                } else {
                    $error = "Invalid email or password";
                }
            }
        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
        ?>
        <p><?php echo $error; ?></p>
    </div>
</body>
</html>
