<?php
    include_once '../../config.php';
    include_once '../../connect-db.php';

    if (!isset($_SESSION['Token'])) {
        header("Location: ../login.php");
        exit();
    }

    $name =  $conn->real_escape_string($_POST["name"]);
    $surname = $conn->real_escape_string($_POST["surname"]);
    $email = $conn->real_escape_string($_POST["email"]);
    $age = $conn->real_escape_string($_POST["age"]);
    $username = $conn->real_escape_string($_POST["username"]);
    $password = $conn->real_escape_string($_POST["password"]);
    $role =  $conn->real_escape_string($_POST["role"]);
    $admin_pin = $conn->real_escape_string($_POST["admin_pin"]);
    $added_by = $_SESSION['ID'];

    if (!isset($_FILES["profileImage"]) || empty($_FILES["profileImage"]["name"])) {
        echo "No profile image uploaded.";
        exit();
    }

    $target_dir = "../../images/imageProfile/";
    $imageFileType = strtolower(pathinfo($_FILES["profileImage"]["name"], PATHINFO_EXTENSION));
    $target_file = $target_dir . uniqid() . "." . $imageFileType;

    $check = getimagesize($_FILES["profileImage"]["tmp_name"]);
    if ($check === false) {
        echo "Invalid image file.";
        exit();
    }

    if (!in_array($imageFileType, ["jpg", "jpeg", "png", "gif", "webp"])) {
        echo "Invalid file type. Only JPG, JPEG, PNG, GIF, and WEBP are allowed.";
        exit();
    }

    if (!move_uploaded_file($_FILES["profileImage"]["tmp_name"], $target_file)) {
        echo "Error uploading file.";
        exit();
    }

    $password = hash('sha256', $salt.$password);

    $sql = "SELECT * FROM `employees` WHERE Username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "Username already exists.";
        exit();
    } else {
        $query = "INSERT INTO `employees` (`Name`, `Surname`, `Username`, `user_password`, `Email`, `Age`, `Registration_Date`, `Role`, `addedBy`, `profile_image_path`) 
                  VALUES ('$name', '$surname', '$username', '$password', '$email', '$age', NOW(), '$role', '$added_by', '$target_file')";

        if ($role == 'Admin' && $admin_pin != $admin_hidden_pin) {
            echo "error";
            exit();
        }

        if ($conn->query($query)) {
            echo "success";
        } else {
            echo "Error adding employee.";
        }
    }
?>



