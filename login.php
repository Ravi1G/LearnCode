
<?php
    include 'server_constraints.php';
    $con = mysqli_connect($host,$server_username,$server_password,$db);
    if(mysqli_connect_errno($con))
    {
        echo "error in connecting to mysql". mysqli_connect_error();
    }
    $query = "select * from users
              where username = '$_POST[login_username]' and passwd = '$_POST[login_passwd]'";
    $result = mysqli_query($con,$query);
    if(mysqli_num_rows($result))
    {
        session_start();
        $_SESSION['username'] = $_POST[login_username];
        echo "fasd  ".$_SESSION['username'];
        header("Location: problemset.php");
        //die();
    }
    else
    {
        echo "not fount";
       header("Location: index.php?id=2");
       die();
    }
    mysqli_close($con);


?>