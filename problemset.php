 <?php
    error_reporting(E_ALL);
    ini_set('display_errors'.'1');
    session_start();
    include 'server_constraints.php';
    $con = mysqli_connect($host, $server_username, $server_password, $db);
?>
<html>
 <head>
        <title>D-odge</title>
        <link href="css/style.css" rel="stylesheet">
    </head>
    <body>
        <div id = "header">
            <div id = "logo">
                D-odge  ^
            </div>
            <div id = "header-bar">
                <div id = "menu" style ="float:left">
                    <ul>
                       <li><a href = "problemset.php">Problemset</a></li>
                   </ul>
                </div>
                <div id = user-id style = "float:right; font-size:19px;">
                    <ul>
                        <li ><a href = "userhome.php"><?php echo $_SESSION['username'];?></a></li>
                        <li><a href = "logout.php">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
<?php
    echo "<h3>Problemset</h3><br><br>";
    echo "<div >
            <table class =\"table-style\">
            <th>id   </th>
            <th> Problem</th>";
    $query = "select * from questions";
    $result = mysqli_query($con,$query);
    while($row = mysqli_fetch_array($result))
    {
        
        echo '<tr>
                <td>'.$row['id'].'</td>
                <td><a href = problem.php?id=' .$row['name']. '>'.$row['name'].'</a></td>
               </tr> ';
    }
    echo "</table>
            </div>"
    
?>