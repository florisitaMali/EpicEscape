<?php
session_start();
require_once '../connect-db.php';
require_once '../config.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);


header('Content-Type: application/json');

if (!isset($_SESSION['ID'])) {
    echo json_encode(['status' => 'error', 'message' => 'Not authorized.']);
    exit();
}

$userId = $_SESSION['ID'];

$name = trim($_POST['name'] ?? '');
$surname = trim($_POST['surname'] ?? '');
$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';
$email = trim($_POST['email'] ?? '');
$age = intval($_POST['age'] ?? 0);

if ($name === '' || $surname === '' || $username === '' || $email === '' || $age <= 0) {
    echo json_encode(['status' => 'error', 'message' => 'Please fill in all required fields.']);
    exit();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid email address.']);
    exit();
}

// Optional: Check for unique username/email
$check = $conn->prepare("SELECT id FROM clients WHERE (username = ? OR email = ?) AND id != ?");
$check->bind_param("ssi", $username, $email, $userId);
$check->execute();
$check->store_result();
if ($check->num_rows > 0) {
    echo json_encode(['status' => 'error', 'message' => 'Username or email already taken.']);
    exit();
}
$check->close();

$sql = "UPDATE clients SET name = ' $name', surname = '$surname', username = '$username', email = '$email', age = '$age'";

try {
    if ($password !== '') {
        $password = hash('sha256', $salt.$password);
        $sql .= ", user_password = ' $password'";      
    } 

    $sql .= " WHERE id = '$userId'";

    if ($conn->query($sql)) {
        echo json_encode(['status' => 'success', 'message' => 'Profile updated successfully.']);

    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update profile. ' . $conn->error]);
    }

} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => 'Server error.']);
}
?>