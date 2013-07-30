<?php
    error_reporting(E_ALL);
    ini_set('display_errors'.'1');
    session_start();
    include 'server_constraints.php';
    $con = mysqli_connect($host, $server_username, $server_password, $db);
    $num = $_GET['id'];
    echo $num;
    echo "<br><h3>CODE</h3><br>";
    $code_file_name = "codes/".$num.".c";
    $code_file = fopen($code_file_name,'r');
    $code = fread($code_file,filesize($code_file_name));
    $j = 0;
    $enter = 0;
    while($j< strlen($code))
    {
        if(!strcmp($code[$j],"\n"))
           {
            echo "<br>";
            $enter = 1;
           }
        else if($enter == 1 && !strcmp($code[$j]," "))
            echo "&nbsp&nbsp";
        else
           {
            echo $code[$j];
            $enter = 0;
           }
            $j++;
    }
    
    echo "<br>";
    /*while(!feof($code_file))
    {
        echo "<br>".fgets($code_file);
    }*/
    
?>