<?php
require_once('./conn.php');

$userId = $_POST['userId'];
$sql = "DELETE FROM users WHERE user_id = '$userId'";
if (mysqli_query($conn, $sql)) {
    echo "User deleted successfully!";
} else {
    echo "Error: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
