<?php
require_once('./conn.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['userId'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $dob = $_POST['dob'];
    $sql = "UPDATE users SET name='$name', email='$email', dob='$dob' WHERE user_id=$userId";
    if ($conn->query($sql) === TRUE) {
        echo "Data updated successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>
