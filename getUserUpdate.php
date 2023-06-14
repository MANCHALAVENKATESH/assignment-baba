<?php
require_once('./conn.php');

$userId = $_POST['userId'];
$sql = "SELECT file,name, email, dob FROM users WHERE user_id = '$userId'";
$result = mysqli_query($conn, $sql);
$data = array(); 
if ($result) {
    $row = mysqli_fetch_assoc($result);
    $name = $row['name'];
    $email = $row['email'];
    $dob = $row['dob'];
    $user_id = $userId;
    $file = $row['file'];

    $data = array(
        'name' => $name,
        'email' => $email,
        'dob' => $dob,
        'user_id' => $user_id,
        'file' => $file
    );

    $jsonData = json_encode($data);
    echo $jsonData;
} else {
    echo "Error: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
