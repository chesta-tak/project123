<?php
$servername = "localhost";
$username = "root";
$password = " ";
$dbname = "kids_bank";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['signup_submit'])) {
        // Sign-up process
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

     // Check if required fields are empty
if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
    echo "All fields are required";
    exit();
}

// Validate email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "Invalid email format";
    exit();
}

// Check password length
if (strlen($password) < 6) {
    echo "Password must be at least 6 characters long";
    exit();
}


        // Check if passwords match
        if ($password !== $confirm_password) {
            echo "Passwords do not match";
            exit();
        }

        // Check if user already exists in the database
        $sql = "SELECT * FROM users WHERE email='$email'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "User with this email already exists";
            exit();
        }

        // Insert user data into database
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$hashed_password')";

        if ($conn->query($sql) === TRUE) {
            header("Location: success.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } elseif (isset($_POST['login_submit'])) {
        // Login process
        $login_email = $_POST['login_email'];
        $login_password = $_POST['login_password'];

        // Retrieve user data from database based on email
        $sql = "SELECT * FROM users WHERE email='$login_email'";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            if (password_verify($login_password, $row['password'])) {
                header("Location: success.php");
                exit();
            } else {
                echo "Incorrect password";
            }
        } else {
            echo "User not found";
        }
    } else {
        // Handle invalid form data
        echo "Invalid form data";
    }
}

$conn->close();
?>
