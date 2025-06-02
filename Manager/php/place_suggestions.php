<?php
include '../../connect-db.php';

$term = $_GET['term'] ?? '';

$suggestions = [];
if (!empty($term)) {
    $term = mysqli_real_escape_string($conn, $term);
    $query = "SELECT DISTINCT Place FROM packages WHERE Place LIKE '%$term%' LIMIT 10";
    $result = mysqli_query($conn, $query);

    while ($row = mysqli_fetch_assoc($result)) {
        $suggestions[] = $row['Place'];
    }
}

echo json_encode($suggestions);
?>
