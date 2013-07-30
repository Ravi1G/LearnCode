

<?php
    include 'server_constraints.php';
    $con=mysqli_connect($host,$server_username,$server_password,$db);

    if (mysqli_connect_errno($con))
    {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    $query = "INSERT INTO users (username, passwd, email)
              values
              ('$_POST[username]','$_POST[passwd]','$_POST[email]')";
    if(!mysqli_query($con,$query))
    {
        die('error:'. mysqli_error($con));
    }
    echo "added";
    // add a table of the user
    /*$query = "create table user_$_POST[username](id INT AUTO_INCREMENT NOT NULL,PRIMARY KEY(id), submissions INT)";
    if(!mysqli_query($con,$query))
    {
        echo "table no cteated". mysqli_error($con);
    }
    else echo "created";*/
    header("Location: index.php?id=1");
    mysqli_close($con);  
  
?>



