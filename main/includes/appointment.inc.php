<?php
include_once 'dbh.inc.php';

if(isset($_POST['booking'])){
    $sched = $_POST['book_date'];
    $startt = $_POST['book_time'];
    $endt = $_POST['book_two'];
    $duration = $_POST['consult_time'];

    $sql = "INSERT INTO appointment (sched, start_time, end_time, duration) VALUES ('$sched', '$startt', '$endt', '$duration')";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    if($result){
        echo'<script> alert ("Data Saved"); </script>';
        header("Location: ../../ds.php");
    }
    else{
        echo'<script> alert ("Data not Saved"); </script>';
    }

}