<?php
$conn = new mysqli("localhost", "root", "", "courier_tracking");

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$result = $conn->query("SELECT * FROM contacts");

echo "<h2>Contact Messages</h2>";


if (isset($_GET['updated'])) {
    echo "<p style='color: green;'>Record updated successfully!</p>";
}

echo "<table border='1' cellpadding='10'>
<tr>
<th>ID</th><th>Name</th><th>Email</th><th>Subject</th><th>Message</th><th>Actions</th>
</tr>";

while ($row = $result->fetch_assoc()) {
  echo "<tr>
    <td>" . htmlspecialchars($row['id']) . "</td>
    <td>" . htmlspecialchars($row['name']) . "</td>
    <td>" . htmlspecialchars($row['email']) . "</td>
    <td>" . htmlspecialchars($row['subject']) . "</td>
    <td>" . htmlspecialchars($row['message']) . "</td>
    <td>
      <a href='edit_contact.php?id=" . $row['id'] . "'>Edit</a> |
      <a href='delete_contact.php?id=" . $row['id'] . "' onclick=\"return confirm('Are you sure?');\">Delete</a>
    </td>
  </tr>";
}

echo "</table>";
$conn->close();
?>
