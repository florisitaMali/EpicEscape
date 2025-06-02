<?php
    $SERVER = 'localhost';
    $USERNAME = 'root';
    $PASSWORD = '';
    $DATABASE = 'epicescape';

    global $conn;
    $conn = new mysqli($SERVER, $USERNAME, $PASSWORD, $DATABASE);

    if($conn->connect_error){
        die("Connection failed: " . $conn->connect_error);
    }
?>

