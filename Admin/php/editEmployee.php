<?php
include_once '../../config.php';
include_once '../../connect-db.php';

if (!isset($_POST['id'])) {
    echo "Missing ID";
    exit;
}

$id = intval($_POST['id']);
$name = $conn->real_escape_string($_POST['name']);
$surname = $conn->real_escape_string($_POST['surname']);
$username = $conn->real_escape_string($_POST['username']);
$email = $conn->real_escape_string($_POST['email']);
$age = $conn->real_escape_string($_POST['age']);
$password = $conn->real_escape_string($_POST['password']);

$updateQuery = "UPDATE employees SET 
    `Name` = '$name', 
    `Surname` = '$surname', 
    `Username` = '$username', 
    `Email` = '$email', 
    `Age` = '$age'";

if (!empty($password)) {
    $password .= $salt;
    $hashedPassword = md5($password);
    $updateQuery .= ",`user_password` = '$hashedPassword'";
}

$updateQuery .= " WHERE  `ID` = $id";

if ($conn->query($updateQuery)) {
    echo "success";
} else {
    echo "error";
}


