<?php
   include_once '../../config.php';
   if(isset($_SESSION['Token'])){
    $token = $_GET['token'];

    if($token == $_SESSION['Token']){
        session_destroy();
        header("Location: ../../login.php");
        exit();
    } else{
        header("Location: ../html/Manager.php");
    }
}
?>