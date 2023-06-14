<?php
require_once('./conn.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $dob = $_POST['dob'];

    $file = $_FILES['file'];
    $filename = $file['name'];
    $tempFilePath = $file['tmp_name'];
    $targetFilePath = './files/' . $filename;
    if (move_uploaded_file($tempFilePath, $targetFilePath)) {
        $sql = "INSERT INTO users (name, email, dob, file) VALUES ('$name', '$email', '$dob', '$targetFilePath')";
        if ($conn->query($sql) === TRUE) {
            echo "Data saved successfully!";
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "Error uploading file.";
    }
}
$conn->close();
?>
