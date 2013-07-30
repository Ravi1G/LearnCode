<?php
        error_reporting(E_ALL);
    ini_set('display_errors', '1');
    session_start();
    include '../server_constraints.php';
    $con = mysqli_connect($host, $server_username, $server_password, $db);
    if(isset($_POST['username']))
    {
        if($_POST['username'] != "admin")
            echo "wrong Username/password<br>";
        else
        {
        $query = "select * from users where username = 'admin'";
        if(!mysqli_query($con, $query))
        {
            echo "unable to record to db $mysqli_error($con)";
        }
        $result = mysqli_query($con, $query);
        echo mysqli_num_rows($result);
        $row = mysqli_fetch_array($result);
        if($_POST['passwd'] != $row['passwd'])
        {
            echo "wrong username/password";
        }
        else
            $_SESSION['username'] = 'admin';
            header("Location: adminhome.php");
        }
    }
    //echo "fafa";
?>
<form action = "admin-login.php" method = "post">
    Username <input type = "text" name = "username" >
    password <input type = "password" name = "passwd">
    <input type = "submit" value = "login">
</form>