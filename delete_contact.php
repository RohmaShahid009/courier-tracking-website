<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);


$conn = new mysqli("localhost", "root", "", "courier_tracking");


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); 

  
    $sql = "DELETE FROM contacts WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo " Record deleted successfully. <br><br>";
        echo "<a href='view.php'> Go back to Messages</a>";
    } else {
        echo " Error deleting record: " . $conn->error;
    }
} else {
    echo " No ID provided.";
}

$conn->close();
?>
