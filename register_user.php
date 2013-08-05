

<?php
error_reporting(E_ALL);
    ini_set('display_errors'.'1');
    include 'server_constraints.php';
    $con=mysqli_connect($host,$server_username,$server_password,$db);

    if (mysqli_connect_errno($con))
    {
    exit( "Failed to connect to MySQL: " . mysqli_connect_error());
    }
    $query = "select * from users where username = '".$_POST['username']."'";
    if(!mysqli_query($con,$query))
        exit("exit".mysqli_error($con));
    $res = mysqli_query($con,$query);
    if(mysqli_num_rows($res))
     {
        header("Location:index.php?id=3");
        die();
     }
    $query = "INSERT INTO users (username, passwd, email)
              values
              ('$_POST[username]','$_POST[passwd]','$_POST[email]')";
    if(!mysqli_query($con,$query))
    {
        die('error:'. mysqli_error($con));
    }
    echo "added";
    mysqli_close($con);  
    header("Location: index.php?id=1");
    
  
?>



