<?php
include_once 'dbh.inc.php';

function emptyInputSignup($email, $Password, $Passwordrp, $First_Name, $Last_Name, $Gender, $Contact_no, $Address){
    $result;
    if (empty($email) || empty($Password) || empty($Passwordrp) || empty($First_Name) || empty($Last_Name) || empty($Gender) || empty($Contact_no) || empty($Address)){
        $result = true;
    }
    else{
        $result = false;
    }
    return $result;
}
function invalidEmail($email){
    $result;
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}
function pwdMatch($Password, $Passwordrp){
    $result;
    if($Password !== $Passwordrp){
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}
function datemailex($conn, $sched, $email){
    $sql = "SELECT * FROM booked WHERE sched = ?  AND Email = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../signup.php?error=Emailtaken!");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "ss", $sched, $email);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)){
        return $row;
    }
    else{
        $result = false;
        return $result;
    }
    mysqli_stmt_close($stmt);
}
function emailexdit($conn, $email, $idd){
    $sql = "SELECT * FROM data WHERE Email = ? AND ID = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../signup.php?error=Emailtaken!");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "ss", $email, $idd);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)){
        $result = false;
        return $result;
    }
    else{
        return $row;
    }
    mysqli_stmt_close($stmt);
}
function emailexists($conn, $email){
    $sql = "SELECT * FROM data WHERE Email = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../signup.php?error=Emailtaken!");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)){
        return $row;
    }
    else{
        $result = false;
        return $result;
    }
    mysqli_stmt_close($stmt);
}
function createuser($conn, $email, $Password, $First_Name, $Last_Name, $Gender, $Contact_no, $Address){
    $sql = "INSERT INTO data (Email, Pass, First_Name, Last_Name, Gender, Contact, Home) VALUES (?, ?, ?, ?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../signup.php?error=somethingwentwrong");
        exit();
    }
    $hashedpwd = password_hash($Password, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, "sssssss", $email, $hashedpwd, $First_Name, $Last_Name, $Gender, $Contact_no, $Address);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../../index.php?error=none");
    exit();
}
function emptyInputlogin($email, $Password){
    $result;
    if (empty($email) || empty($Password)){
        $result = true;
    }
    else{
        $result = false;
    }
    return $result;
}
function loginUser($conn, $email, $Password){
    $Emailexists = emailexists($conn, $email);

    if ($Emailexists === false){
        header("location: ../login.php?error=wronglogin");
        exit();
    }

    $pwdhashed = $Emailexists["Pass"];
    $check = password_verify($Password, $pwdhashed);

      if ($check === false){
        header("location: ../login.php?error=wrongpassword");
        exit();
    }
    else if ($check === true){
        session_start();
        $_SESSION["id"] = $Emailexists["ID"]; 
        $_SESSION["email"] = $Emailexists["Email"];
        //$_SESSION['first'] = $Emailexist['first_name'];
       // $_SESSION['last'] = $Emailexist['last_name'];
        header("location: ../../index.php");
        exit();
    }
}
function updatepass($conn, $oldpass, $newpass, $passrp){
    session_start();
    $id = $_SESSION['id'];
    if($newpass !== $passrp){
        header("location: ../patient/update.php?error=passnotmatch");
        exit();
    }
    else {
        $password = $newpass;
    }
    $hashedpwd = password_hash($password, PASSWORD_DEFAULT);
    
    $sql = "UPDATE data SET Pass = '$hashedpwd' WHERE ID = '$id'";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    header("location: ../patient/profile.php?error=none");
    exit();
    
}
function edit($conn ,$email, $First_Name, $Last_Name, $Contact_no, $Address){
    session_start();
    $id = $_SESSION['id'];
    $sql = "UPDATE data SET Email = '$email', First_Name = '$First_Name', Last_Name = '$Last_Name', Contact = '$Contact_no', Home = '$Address' WHERE ID = '$id';";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    header("location: ../patient/profile.php");
    exit();
}

function fetchpass($conn, $id){
    $sql = "SELECT * FROM data WHERE ID = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../signup.php?error=Emailtaken");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)){
        return $row;
    }
    else{
        $result = false;
        return $result;
    }
    mysqli_stmt_close($stmt);
}

function chk($conn, $oldpass, $id){
    $passy = fetchpass($conn, $id);
    $dbpass = $passy['Pass'];
    $check = password_verify($oldpass, $dbpass);

      if ($check === false){
        header("location: ../patient/update.php?error=wrongpassword1");
        exit();
    }
    else if ($check === true){
        return $check;
    }
}
function fetchemail($conn, $email){
    $passy = emailexists($conn, $email);
    $passed = $passy['Email'];
    return $passy;
}
function loginAdmin($conn, $emaila, $Passworda){
    $Emailexists = emailadminex($conn, $emaila);

    if ($Emailexists === false){
        header("location: ../logina.php?error=wronglogin");
        exit();
    }

    $check = $Emailexists["Pass"];

      if ($check !== $Passworda){
        header("location: ../logina.php?error=wrongpassword");
        exit();
    }
    else if ($check === $Passworda){
        session_start();
        $_SESSION["id"] = $Emailexists["ID"]; 
        $_SESSION["email"] = $Emailexists["Email"];
        header("location: ../../dashboard.php");
        exit();
    }
}
function emailadminex($conn, $emaila){
    $sql = "SELECT * FROM admin WHERE Email = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../signup.php?error=Emailtaken!");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "s", $emaila);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)){
        return $row;
    }
    else{
        $result = false;
        return $result;
    }
    mysqli_stmt_close($stmt);
}

//function getID($conn, $email = null){ 
    //$sql = "SELECT 'ID' FROM data WHERE 'Email' = $email";
    //$result = mysqli_query($conn, $sql);
    //if ($row = mysqli_fetch_assoc($result)){
    //}
    //return $row;
//}
//function getUsersData(){
    //$array = array();
    //$asoc = emailexists($conn, $email);
    //$id = emailexists['ID'];
    //$sql = "SELECT * FROM data WHERE 'ID' = $id;";
    //while($row = mysqli_fetch_assoc($sql)){
        //$array['First_Name'] = $row['First_Name'];
        //$array['Last_Name'] = $row['Last_Name'];
        //$array['Email'] = $row['Email'];
        //$array['Pass'] = $row['Pass'];
        //$array['Home'] = $row['Home'];
        //$array['Contact'] = $row['Contact'];
        //$array['Gender'] = $row['Gender'];
    //}
    //return $array;
//}
