<?php
$conn = new mysqli("localhost", "root", "", "courier_tracking");

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$name = $_POST['name'];
$email = $_POST['email'];
$service_type = $_POST['service_type'];
$details = $_POST['details'];

$stmt = $conn->prepare("INSERT INTO service_requests (name, email, service_type, details) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $name, $email, $service_type, $details);

if ($stmt->execute()) {
  echo "<h2>Thank you for booking!</h2><p>Your request for <strong>$service_type</strong> has been received.</p><a href='services.html'>Go back</a>";
} else {
  echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
