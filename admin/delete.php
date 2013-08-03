<?php
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    session_start();
    include '../function.php';
    include '../server_constraints.php';    
    $con = mysqli_connect($host, $server_username, $server_password, $db);
    echo $_GET['id'];
    $ques = url_to_string($_GET['id']);
    $query = "delete from questions where name = '$ques'";
    if(!mysqli_query($con,$query))
    {
        echo mysqli_error($con);
    }
    else
    {
        unlink("../questions/".$ques.".txt");
        unlink("../input/".$ques.".txt");
        unlink("../input/".$ques.".txt");
        header("Location: adminhome.php?id=2");
    }
?>