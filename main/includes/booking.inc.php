<?php
require_once 'dbh.inc.php';
require_once 'functions.inc.php';
session_start();

if (isset($_POST['booking'])){
    $id = $_POST['id'];
    $email = $_SESSION['email'];
    $sched = $_POST['sched'];
    $startt = $_POST['start_time'];
    $endd = $_POST['end_time'];
    $duration = $_POST['duration'];
    if (datemailex($conn, $sched, $email)!== false){
        header("location: ../patient/bookappointment.php?error=alreadybookedforthisday");
        
    exit();
    }

    $sq = "DELETE FROM appointment WHERE ID=$id";
    $result = mysqli_query($conn, $sq) or die(mysqli_error($conn));
    $sql = "INSERT INTO booked(Email, sched, start_time, end_time, duration) VALUES (?, ?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../signup.php?error=somethingwentwrong");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sssss", $email, $sched, $startt, $endd, $duration);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../patient/myappointment.php?error=none");
    exit();

}
else{
    header("location: ../login.php");
    exit();
}
