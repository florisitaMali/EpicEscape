<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

session_start();
include "../connect-db.php";

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header("Location: index.php");
    exit;
}
$packageID = (int) ($_POST['package_id'] ?? 0);
$placesRequested = (int) ($_POST['places_requested'] ?? 0);
$customers = $_POST['customers'] ?? [];

if ($packageID <= 0 || $placesRequested <= 0 || count($customers) != $placesRequested) {
    die("❌ Invalid form data. Check package ID, places, and customers count.");
}

// Retrieve available spots safely
$stmtCheck = $conn->prepare("SELECT `available_spots` FROM `packages` WHERE `ID` = ?");
$stmtCheck->bind_param("i", $packageID);
$stmtCheck->execute();
$result = $stmtCheck->get_result();
$row = $result->fetch_assoc();
$stmtCheck->close();

if (!$row) {
    die("❌ Package ID not found. Please check your selection.");
}

$availableSpots = (int)$row['available_spots'];
$nrOfSpots = count($customers);
$remaining = $availableSpots - $nrOfSpots;
if ($remaining < 0) {
    die("❌ Not enough available spots. Please adjust your reservation.");
}

// Insert reservations
$stmtInsert = $conn->prepare("INSERT INTO reservations (PackageID, clientID, reservation_date, client_Name, client_Surname, client_email, client_age, passportID) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$userID = $_SESSION['ID'];

foreach ($customers as $customer) {
    $name = trim($customer['name'] ?? '');
    $surname = trim($customer['surname'] ?? '');
    $email = trim($customer['email'] ?? '');
    $age = (int)$customer['age'];
    $reservationDate = date('Y-m-d');
    $passportID = trim($customer['passportID'] ?? '');

    if (empty($name) || empty($surname) || empty($email) || empty($passportID)) {
        $error = "❌ Missing customer details. Please ensure all fields are filled.";
        break;
    }

    $stmtInsert->bind_param("iissssis", $packageID, $userID, $reservationDate, $name, $surname, $email, $age, $passportID);

    if (!$stmtInsert->execute()) {
        error_log("Insert failed: " . $stmtInsert->error);
        $error = "❌ Failed to insert reservation into the database.";
        break;
    }
}

$stmtInsert->close();
if (!isset($error)) {
    $stmtUpdate = "UPDATE `packages` SET `available_spots` = '$remaining' WHERE `ID` ='$packageID'";

    if ($conn->query($stmtUpdate)) {
        $success = "✅ Your reservation has been successfully completed!
                    An email will be sent to your account with the confirmation.
                    You should pay on Delivery.";
    } else {
        $error = "❌ Failed to update package availability.";
    }
}
?>


<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Reservation Confirmation</title>
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <style>
    .message-box {
      margin: 50px auto;
      max-width: 600px;
      padding: 30px;
      text-align: center;
      border-radius: 10px;
      font-size: 1.25rem;
    }
    .success {
      background-color: #e6f5ea;
      color: #155724;
      border: 1px solid #c3e6cb;
    }
    .error {
      background-color: #fdecea;
      color: #721c24;
      border: 1px solid #f5c6cb;
    }
  </style>
</head>
<body>

<div class="message-box <?= isset($success) ? 'success' : 'error' ?>">
  <p><?= $success ?? $error ?></p>
  <?php if (isset($success)): ?>
    <p>⏳ Redirecting to homepage...</p>
    <script>
      setTimeout(() => {
        window.location.href = "index.php";
      }, 3000);
    </script>
  <?php endif; ?>
</div>

</body>
</html>
