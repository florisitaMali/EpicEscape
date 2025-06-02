<?php
include_once '../../config.php';
include_once '../../connect-db.php';

if (!isset($_SESSION['Token'])) {
    header("Location: ../login.php");
    exit();
}


  $employeeId = $conn->real_escape_string($_POST['employee_id']);
  $password = $conn->real_escape_string($_POST['confirm_password']);
  $userId = $_SESSION['ID']; 

    $query = "SELECT user_password FROM employees WHERE `ID` = $_SESSION[ID]";
    $result = $conn->query($query);
    if ($result->num_rows == 1) {
        if ($row = $result->fetch_assoc()) {
            $hashedPassword =  hash('sha256', $salt.$password);

            if($hashedPassword !== $row['user_password']) {
                header("Location: ../html/Employees.php?error=wrongpass");
                exit();
            }else{
                $query = "DELETE FROM employees WHERE ID = $employeeId";
                $conn->query($query);
                if ($conn->affected_rows > 0) {
                    header("Location: ../html/Employees.php?deleted=1");
                } else {
                    header("Location: ../html/Employees.php?error=deletefail");
                }
            }
        }
    } else {
        header("Location: ../pages/employeePage.php?error=wrongpass");
    }
?>

