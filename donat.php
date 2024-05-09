
<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kids_bank";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $id = $_POST['id'] ?? ''; // Optional fields, use isset or ?? to handle if not set
    $pan = $_POST['pan'] ?? ''; // Optional fields, use isset or ?? to handle if not set
    $remarks = $_POST['remarks'];
    $amount = $_POST['amount'];

    // Validate phone number (10 digits)
    if (!preg_match('/^[0-9]{10}$/', $phone)) {
        echo "<p>Invalid phone number. Please enter a 10-digit number.</p>";
        exit;
    }

    // Validate PAN card (format: ABCDE1234F)
    if (!preg_match('/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/', $pan)) {
        echo "<p>Invalid PAN card number. Please enter a valid PAN card.</p>";
        exit;
    }

    // Prepare SQL insert statement
    $stmt = $conn->prepare("INSERT INTO donations (name, phone, id, pan, remarks, amount) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssi", $name, $phone, $id, $pan, $remarks, $amount);

     // Execute the statement
     if ($stmt->execute()) {
        // Close statement
        $stmt->close();
        
        // Close connection
        $conn->close();

        // Redirect to thankyou.html after successful donation
        
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statement
    $stmt->close();
    $conn->close();
}
?>
?>
