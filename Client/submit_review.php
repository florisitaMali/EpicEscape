<?php
session_start();
include "../connect-db.php";

// Check if user is logged in


if (!isset($_SESSION['ID'])) {
    // Redirect back with error parameter
    $packageID = isset($_POST['package_id']) ? intval($_POST['package_id']) : 0;
    $nr_places = isset($_POST['nr_places']) ? intval($_POST['nr_places']) : 0;
    header("Location: package.php?package_id=$packageID&nr_places=$nr_places&error=login_required");
    exit();
}



// Validate POST data
if (!isset($_POST['package_id'], $_POST['review_text']) || empty(trim($_POST['review_text']))) {
    die("Invalid review submission.");
}

$clientID = $_SESSION['ID'];
$packageID = intval($_POST['package_id']);
$reviewText = trim($_POST['review_text']);
$nr_places=intval($_POST['nr_places']);

// Insert review into database
$stmt = $conn->prepare("
    INSERT INTO reviews (packageID, review, ClientID, DateSubmitted, Confirmed)
    VALUES (?, ?, ?, NOW(), 0)
");

if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("isi", $packageID, $reviewText, $clientID);

if (!$stmt->execute()) {
    die("Execution failed: " . $stmt->error);
}

$stmt->close();

// Redirect back to package page with success message
header("Location: package.php?package_id=$packageID&nr_places=$nr_places&review=success");
exit();
