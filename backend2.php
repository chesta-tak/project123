<?php
session_start();

// Function to establish a database connection
function connectToDatabase() {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "kids_bank";


    // Create connection
    $conn = new mysqli($localhost, $root $password, $dbname);

   // Check connection
   if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

return $conn;
}
// Function to close the database connection
function closeDatabaseConnection($conn) {
    $conn->close();
}

// Function to authenticate user
function authenticateUser($username, $password) {
    $conn = connectToDatabase();
    $hashed_password = md5($password); // Assuming passwords are stored as MD5 hashes
    $sql = "SELECT * FROM users WHERE username='$username' AND password='$hashed_password'";
    $result = $conn->query($sql);
    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        $_SESSION['user_id'] = $user['id'];
        closeDatabaseConnection($conn);
        return true;
    } else {
        closeDatabaseConnection($conn);
        return false;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Create a new goal setting
    $data = json_decode(file_get_contents('php://input'), true);
    $amount = $data['amount'];
    $currentAmount = $data['currentAmount'];
    
    $stmt = $conn->prepare("INSERT INTO goals (amount, current_amount) VALUES (:amount, :currentAmount)");
    $stmt->bindParam(':amount', $amount);
    $stmt->bindParam(':currentAmount', $currentAmount);
    $stmt->execute();

    echo json_encode(['message' => 'Goal setting created successfully']);
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Retrieve all goal settings
    $stmt = $conn->query("SELECT * FROM goals");
    $goals = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($goals);
} else {

    http_response_code(405);
    echo json_encode(['error' => 'Method Not Allowed']);
}
// Function to deposit money into account
function depositMoney($amount) {
    $conn = connectToDatabase();
    $user_id = $_SESSION['user_id'];
    $sql = "UPDATE accounts SET balance = balance + $amount WHERE user_id = $user_id";
    if ($conn->query($sql) === TRUE) {
        closeDatabaseConnection($conn);
        return true;
    } else {
        closeDatabaseConnection($conn);
        return false;
    }
}
// Function to withdraw money from account
function withdrawMoney($amount) {
    $conn = connectToDatabase();
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT balance FROM accounts WHERE user_id = $user_id";
    $result = $conn->query($sql);
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if ($row['balance'] >= $amount) {
            $sql = "UPDATE accounts SET balance = balance - $amount WHERE user_id = $user_id";
            if ($conn->query($sql) === TRUE) {
                closeDatabaseConnection($conn);
                return true;
            } else {
                closeDatabaseConnection($conn);
                return false;
            }
        } else {
            closeDatabaseConnection($conn);
            return false; // Insufficient balance
        }
    } else {
        closeDatabaseConnection($conn);
        return false;
    }
}
// Function to set a savings goal
function setGoal($goal_amount, $target_date) {
    $conn = connectToDatabase();
    $user_id = $_SESSION['user_id'];
    // Code to set the goal in the database
    closeDatabaseConnection($conn);
    return true; // Placeholder return value
}
?>
