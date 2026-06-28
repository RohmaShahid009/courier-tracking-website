<?php
header('Content-Type: application/json');

$conn = new mysqli("localhost", "root", "", "courier_tracking");

if ($conn->connect_error) {
  echo json_encode(["error" => "Database connection failed."]);
  exit();
}

if (!isset($_GET['tracking_number'])) {
  echo json_encode(["error" => "Tracking number is required."]);
  exit();
}

$tracking_number = $conn->real_escape_string($_GET['tracking_number']);

$sql = "SELECT * FROM tracking_info WHERE tracking_number = '$tracking_number'";
$result = $conn->query($sql);

if ($result->num_rows === 0) {
  echo json_encode(["error" => "Tracking number not found."]);
  exit();
}

$row = $result->fetch_assoc();
$originCoordinates = [
  "Lahore, Pakistan" => ["lat" => 31.5497, "lng" => 74.3436],
  "Karachi, Pakistan" => ["lat" => 24.8607, "lng" => 67.0011],
  "Islamabad, Pakistan" => ["lat" => 33.6844, "lng" => 73.0479],
  "Rawalpindi, Pakistan" => ["lat" => 33.5651, "lng" => 73.0169],
  "Faisalabad, Pakistan" => ["lat" => 31.4504, "lng" => 73.1350],
  "Multan, Pakistan" => ["lat" => 30.1575, "lng" => 71.5249],
  "Peshawar, Pakistan" => ["lat" => 34.0151, "lng" => 71.5805],
  "Quetta, Pakistan" => ["lat" => 30.1798, "lng" => 66.9750],
  "Gujranwala, Pakistan" => ["lat" => 32.1877, "lng" => 74.1945],
  "Sialkot, Pakistan" => ["lat" => 32.4945, "lng" => 74.5229],
  "Bahawalpur, Pakistan" => ["lat" => 29.3956, "lng" => 71.6836],
  "Sargodha, Pakistan" => ["lat" => 32.0836, "lng" => 72.6711],
  "Sukkur, Pakistan" => ["lat" => 27.7052, "lng" => 68.8574],
  "Hyderabad, Pakistan" => ["lat" => 25.3960, "lng" => 68.3578],
  "Abbottabad, Pakistan" => ["lat" => 34.1688, "lng" => 73.2215],
  "Mirpur, Pakistan" => ["lat" => 33.1485, "lng" => 73.7510],
  "Muzaffarabad, Pakistan" => ["lat" => 34.3520, "lng" => 73.4711],
  "Dera Ghazi Khan, Pakistan" => ["lat" => 30.0516, "lng" => 70.6333],
  "Mardan, Pakistan" => ["lat" => 34.2019, "lng" => 72.0524],
  "Rahim Yar Khan, Pakistan" => ["lat" => 28.4194, "lng" => 70.2989],
  "Chiniot, Pakistan" => ["lat" => 31.7202, "lng" => 72.9789],
  "Jhelum, Pakistan" => ["lat" => 32.9408, "lng" => 73.7276],
  "Okara, Pakistan" => ["lat" => 30.8138, "lng" => 73.4458],
  "Vehari, Pakistan" => ["lat" => 30.0444, "lng" => 72.3487],
  "Kohat, Pakistan" => ["lat" => 33.5898, "lng" => 71.4497],
  "Gwadar, Pakistan" => ["lat" => 25.1264, "lng" => 62.3226],
  "Gilgit, Pakistan" => ["lat" => 35.8818, "lng" => 74.4644],
  "Skardu, Pakistan" => ["lat" => 35.3353, "lng" => 75.5412],
  "Hunza, Pakistan" => ["lat" => 36.3167, "lng" => 74.6500]
];


$originLat = $originCoordinates[$row['origin']]['lat'] ?? 0;
$originLng = $originCoordinates[$row['origin']]['lng'] ?? 0;
$destLat = $originCoordinates[$row['destination']]['lat'] ?? 0;
$destLng = $originCoordinates[$row['destination']]['lng'] ?? 0;

echo json_encode([
  "origin_name" => $row['origin'],
  "destination_name" => $row['destination'],
  "origin_lat" => $originLat,
  "origin_lng" => $originLng,
  "dest_lat" => $destLat,
  "dest_lng" => $destLng,
  "status" => $row['status'],
  "progress" => $row['progress'],
  "eta" => $row['eta']
]);

$conn->close();
?>
