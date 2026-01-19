<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
ob_clean(); // Prevents HTML warnings from breaking JSON
header('Content-Type: application/json');
require_once('../db/database.php');

$u_id = $_SESSION['user_id'];
$username = mysqli_real_escape_string($conn, $_POST['username']);
$phone = mysqli_real_escape_string($conn, $_POST['phone']);
$address = mysqli_real_escape_string($conn, $_POST['address']);
$new_pass = $_POST['new_password'];

$update_fields = "username = '$username', phone = '$phone', address = '$address'";

if (!empty($new_pass)) {
    $update_fields .= ", password = '$new_pass'";
}

$new_image_name = null;
if (!empty($_FILES['profile_pic']['name'])) {
    $new_image_name = time() . '_' . $_FILES['profile_pic']['name'];
    // Moving files specifically to your 'images' folder
    if(move_uploaded_file($_FILES['profile_pic']['tmp_name'], "../images/" . $new_image_name)) {
        $update_fields .= ", profile_image = '$new_image_name'";
    }
}

$sql = "UPDATE users SET $update_fields WHERE id = '$u_id'";

if (mysqli_query($conn, $sql)) {
    echo json_encode([
        "status" => "success", 
        "message" => "Profile successfully updated!",
        "new_image" => $new_image_name
    ]);
} else {
    echo json_encode(["status" => "error", "message" => mysqli_error($conn)]);
}
exit();
