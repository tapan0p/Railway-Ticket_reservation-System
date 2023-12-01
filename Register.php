<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <link rel="stylesheet" href="RegisterStyle.css">
</head>
<body>
    <header>
        <div class="logo">
            <img src="./Images/logo_reg.jpg" alt="Company Logo">
        </div>
    </header>

    <main class="container-wrapper">
        <div class="container">
            <h1>User Registration</h1>
            <form  method="post">
                <div>
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div>
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required
                        pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$"
                        title="Password must contain at least 8 characters, including one uppercase letter, one lowercase letter, one number, and one special character [@ $ ! % * ? &]">
                </div>
                <div>
                    <label for="mobile_no">Mobile No:</label>
                    <input type="tel" id="mobile_no" name="mobile_no" required>
                </div>
                <div>
                    <label for="dob">Date of Birth:</label>
                    <input type="date" id="dob" name="dob" required>
                </div>
                <button type="submit">Register</button>
            </form>
        </div>
    </main>
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $servername = "localhost";
        $port_no = 3306;
        $username = "user_1";
        $password = "pass_1";
        $myDB = "train_db";

        try {
            $conn = new PDO("mysql:host=$servername;port=$port_no;dbname=$myDB", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $email = $_POST['email'];
            $password = $_POST['password'];
            $mobile_no = $_POST['mobile_no'];
            $dob = $_POST['dob'];
            $sql = "INSERT INTO user (emailid, password, mobileno, dob) VALUES (:email, :password, :mobile_no, :dob)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':mobile_no', $mobile_no);
            $stmt->bindParam(':dob', $dob);
            $stmt->execute();
            header('Location: Login.php');
            exit();
            
        } 
        catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }
    ?>
</body>
</html>
