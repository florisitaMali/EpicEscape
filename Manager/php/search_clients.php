<?php
include_once '../../connect-db.php';
include_once '../../config.php';

header('Content-Type: application/json');

if (isset($_GET['term'])) {
  $term = $conn->real_escape_string($_GET['term']);
  $sql = "SELECT ID, Name, Surname FROM clients WHERE Name LIKE '%$term%' OR Surname LIKE '%$term%' LIMIT 10";
  $result = $conn->query($sql);
  $suggestions = [];

  while ($row = $result->fetch_assoc()) {
    $suggestions[] = $row;
  }

  echo json_encode($suggestions);
} elseif (isset($_GET['id'])) {
  $id = intval($_GET['id']);
  $sql = "SELECT * FROM clients WHERE ID = $id";
  $result = $conn->query($sql);
  
  while ($row = $result->fetch_assoc()) {
    echo "<tr>
            <td><div class='avatar'>" . strtoupper($row['Name'][0] . $row['Surname'][0]) . "</div></td>
            <td>" . htmlspecialchars($row['Name']) . "</td>
            <td>" . htmlspecialchars($row['Surname']) . "</td>
            <td>" . htmlspecialchars($row['Username']) . "</td>
            <td>" . htmlspecialchars($row['Email']) . "</td>
            <td>" . htmlspecialchars($row['Age']) . "</td>
            <td><span class='badge bg-success-subtle text-success-emphasis rounded-pill'>" . htmlspecialchars($row['Registration_Date']) . "</span></td>
          </tr>";
  }
}
?>
