<?php
require_once('./conn.php');

$sql = 'SELECT user_id,file, name, email, dob FROM users';
$result = mysqli_query($conn, $sql);
$data = array(); 
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $image = $row['file'];
        $name = $row['name'];
        $email = $row['email'];
        $dob = $row['dob'];
        $user_id = $row['user_id'];
        $data[] = array(
            'file' => $image,
            'name' => $name,
            'email' => $email,
            'dob' => $dob,
            'user_id' => $user_id

        );
    }
    $jsonData = json_encode($data);
    echo $jsonData;
} else {
    echo "Error: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
