<?php
require_once 'functions.inc.php';
require_once 'dbh.inc.php';
session_start();
$_SESSION['id'];

if (isset($_POST['edit_button'])){
    $email = $_POST['patient_email_address'];
    $First_Name = $_POST['patient_first_name'];
    $Last_Name = $_POST['patient_last_name'];
    $Contact_no = $_POST['patient_phone_no'];
    $Address = $_POST['patient_address'];
    $idd = $_SESSION['id'];
    

//if (emptyInputSignup($email, $First_Name, $Last_Name, $Contact_no, $Address) !== false){
    //header("location: ../signup.php?error=emptyinput");
    //exit();
//}
if (invalidEmail($email) !== false){
    header("location: ../signup.php?error=invalidemail");
    exit();
}
if (emailexdit($conn, $email, $idd) !== false){
    header("location: ../edit.php?error=emailtaken");
    exit();
}

edit($conn, $email, $First_Name, $Last_Name, $Contact_no, $Address);
}
else{
    header("location: ../signup.php");
    exit();
}
