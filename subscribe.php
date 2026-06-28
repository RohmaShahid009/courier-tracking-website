<?php
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'courier_tracking';

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
  echo "Database connection failed.";
  exit;
}

$email = isset($_POST['email']) ? trim($_POST['email']) : '';

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  echo "Invalid email format.";
  exit;
}

// Check if email already exists
$stmt = $conn->prepare("SELECT id FROM subscriptions WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
  echo "This email is already subscribed.";
  $stmt->close();
  $conn->close();
  exit;
}
$stmt->close();

// Insert email into database
$stmt = $conn->prepare("INSERT INTO subscriptions (email) VALUES (?)");
$stmt->bind_param("s", $email);

if ($stmt->execute()) {
  echo "Thank you for subscribing!";
} else {
  echo "Error: Could not subscribe.";
}

$stmt->close();
$conn->close();
?>
