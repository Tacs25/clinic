<?php

// development 
// $servername = 'localhost';
// $username = 'root';
// $password = '';
// $dbname = 'access';

$servername = 'remotemysql.com';
$username = '6VJZxCdZXy';
$password = 'm4efKGyzN6';
$dbname = '6VJZxCdZXy';

$conn = mysqli_connect($servername, $username, $password , $dbname);

if (!$conn)
{
    die("Connection failed: " . mysqli_connect_error());
}