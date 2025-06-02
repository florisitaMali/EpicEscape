<?php
include_once '../../config.php';
include_once '../../connect-db.php';

if (!isset($_SESSION['Token'])) {
    header("Location: ../login.php");
    exit();
}
//Here are used two type of data representing, one using json and the other using array
if (isset($_GET['id'])) {
    $sql = "SELECT * FROM `employees` WHERE ID = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("error" => "SQL Error: " . $conn->error);
    }

    $stmt->bind_param("i", $_GET['id']);
    $stmt->execute();
    $result = $stmt->get_result();

    
    header("Content-Type: application/json");
    if ($result->num_rows == 1 && $row = $result->fetch_assoc()) {
      //This part does nothing more that the data are entry to the json format
        echo json_encode([
            "id" => $row["ID"],
            "name" => $row["Name"],
            "surname" => $row["Surname"],
            "username" => $row["Username"],
            "email" => $row["Email"],
            "age" => $row["Age"]
        ]);
    } else {
        echo json_encode(["error" => "Employee not found"]);
    }
    exit();
}

$sql = "SELECT e.*, a.Name AS AddedByName, a.Surname AS AddedBySurname
        FROM `employees` e
        JOIN `employees` a ON e.addedBy = a.ID";

$result = $conn->query($sql);

if($result->num_rows == 0) {
    echo "<tr><td colspan='9' class='text-center'>No employees found</td></tr>";
    exit();
}

while ($row = mysqli_fetch_assoc($result)) {
    if ($row['ID'] == $_SESSION['ID']) continue;

    $fullName = "{$row['Name']} {$row['Surname']}";
    $addedBy = "{$row['AddedByName']} {$row['AddedBySurname']}";
    $img = htmlspecialchars($row['profile_image_path']);
    $role = htmlspecialchars($row['Role']);
    $desc = "Email: {$row['Email']}<br>Username: {$row['Username']}<br>Age: {$row['Age']}";

echo "
  <div class='swiper-slide'>
    <div class='employee-card'>
      <div class='card-header'>
        <div class='profile-image'>
          <img src='$img' alt='Profile Image'>
        </div>
      </div>
      <div class='card-body'>
        <h2>$fullName</h2>
        <p><strong>Email:</strong> {$row['Email']}</p>
        <p><strong>Username:</strong> {$row['Username']}</p>
        <p><strong>Age:</strong> {$row['Age']}</p>
        <p><strong>Role:</strong> $role</p>
        <div class='actions' style='margin-bottom: 10px;'>
          <button class='btn btn-info edit-btn' data-id='{$row['ID']}'>
            <i class='bi bi-pencil-square'></i> Edit
          </button>
          <button class='btn btn-danger delete-btn' data-id='{$row['ID']}'>
            <i class='bi bi-trash-fill'></i> Delete
          </button>
        </div>
      <p class='text-muted small'><strong>Added by:</strong> $addedBy</p>      </div>
    </div>
  </div>
";
}

?>
