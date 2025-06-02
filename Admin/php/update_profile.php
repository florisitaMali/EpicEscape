<?php
include_once '../../config.php';
include_once '../../connect-db.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["status" => "error", "message" => "Invalid request."]);
    exit;
}

$user_id = $_SESSION['ID'] ?? null;
if (!$user_id) {
    echo json_encode(["status" => "error", "message" => "User not logged in."]);
    exit;
}

$name = trim($_POST['name'] ?? '');
$surname = trim($_POST['surname'] ?? '');
$username = trim($_POST['username'] ?? '');
$email = trim($_POST['email'] ?? '');
$age = intval($_POST['age'] ?? 0);
$password = trim($_POST['password'] ?? '');

if (!$name || !$surname || !$username || !$email || $age <= 0) {
    echo json_encode(["status" => "error", "message" => "Invalid input."]);
    exit;
}
$stmt = "UPDATE employees SET Name='$name', Surname='$surname', Username='$username', Email='$email', Age='$age'";
if ($password != "") {
    $password = hash('sha256', $salt.$password);
    $stmt .= ", user_password='$password'";
} 
$stmt .= " WHERE ID = '$user_id'";

if ($conn->query($stmt)) {
    echo json_encode(["status" => "success", "message" => "Profile updated successfully."]);
} else {
    echo json_encode(["status" => "error", "message" => "Failed to update profile."]);
}

?>
