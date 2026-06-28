<?php
$conn = new mysqli("localhost", "root", "", "courier_tracking");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = intval($_POST['id']);
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $subject = $conn->real_escape_string($_POST['subject']);
    $message = $conn->real_escape_string($_POST['message']);

    $sql = "UPDATE contacts SET name='$name', email='$email', subject='$subject', message='$message' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully. <a href='view.php'>Back to View</a>";
    } else {
        echo "Error updating record: " . $conn->error;
    }

    $conn->close();
    exit;
}


if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $result = $conn->query("SELECT * FROM contacts WHERE id = $id");

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
    } else {
        echo "Record not found.";
        exit;
    }
} else {
    echo "No ID provided.";
    exit;
}
?>

<h2>Edit Contact</h2>
<form method="post" action="edit_contact.php">
    <input type="hidden" name="id" value="<?= $row['id'] ?>">
    Name: <input type="text" name="name" value="<?= htmlspecialchars($row['name']) ?>" required><br><br>
    Email: <input type="email" name="email" value="<?= htmlspecialchars($row['email']) ?>" required><br><br>
    Subject: <input type="text" name="subject" value="<?= htmlspecialchars($row['subject']) ?>" required><br><br>
    Message:<br>
    <textarea name="message" rows="5" cols="40" required><?= htmlspecialchars($row['message']) ?></textarea><br><br>
    <input type="submit" value="Update">
</form>
