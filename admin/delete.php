<?php
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    session_start();
    include '../server_constraints.php';    
    $con = mysqli_connect($host, $server_username, $server_password, $db);
    $ques = $_GET['id'];
    $query = "delete from questions where name = '$ques'";
    if(!mysqli_query($con,$query))
    {
        echo mysqli_error($con);
    }
    unlink("../questions/".$_GET['id'].".txt");
    header("Location: adminhome.php?id=2");
?>