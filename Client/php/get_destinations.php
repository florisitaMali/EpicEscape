<?php
require_once '../../connect-db.php'; // replace with your actual DB config

$type = $_POST['type'] ?? 'all';

if ($type === 'all') {
    $query = "SELECT id, name FROM packages";
    $stmt = $conn->prepare($query);
} else {
    $query = "SELECT id, name FROM packages WHERE type = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $type);
}

$stmt->execute();
$result = $stmt->get_result();

$options = '<option value="all">All trips available</option>';

while ($row = $result->fetch_assoc()) {
    $options .= '<option value="' . htmlspecialchars($row['id']) . '">' . htmlspecialchars($row['name']) . '</option>';
}

echo $options;
?>
