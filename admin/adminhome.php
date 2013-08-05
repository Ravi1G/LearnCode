<?php
    
        error_reporting(E_ALL);
        ini_set('display_errors'.'1');
        session_start();
        if(!isset($_SESSION['username']))
        header("Location:../index.php?id=4");
        include '../server_constraints.php';
        include '../function.php';
        $con = mysqli_connect($host, $server_username, $server_password, $db);
?>

<html>
    <head>
        <title>D-odge</title>
        <link href="../css/style.css" rel="stylesheet">
        <style>
            
        </style>
    </head>
    <body>
     <div id = "header">
            <div id = "logo">
                D-odge  ^
            </div>
            <div id = "header-bar">
                <div id = "menu" style ="float:left">
                    <ul>
                       <li><a href = "adminhome.php">Problemset</a></li>
                       <li><a href = "addques.php">Add</a></li>
                   </ul>
                </div>
                <div id = "user-id" style = "float:right; font-size:19px;">
                    <ul>
                        <li ><a href = "../userhome.php"><?php echo $_SESSION['username'];?></a></li>
                        <li><a href = "../logout.php">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
     <?php
    if($_GET['id'] == 1)
        echo "<p style=\"background:#9ACD32;margin-left:300px; width:400px;padding:10px 20px; border-radius:2px; color:white;\">Question added Successfully</p>";
    else if($_GET['id'] == 2)
        echo "<p style=\"background:#9ACD32;margin-left:300px; width:400px;padding:10px 20px; border-radius:2px; color:white;\">Deletion Successfull</p>";
    else if($_GET['id'] == 3)
        echo "<p style=\"background:#9ACD32;margin-left:300px; width:400px;padding:10px 20px; border-radius:2px; color:white;\">Question updated Successfully</p>";
    ?>
        <?php
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
                        <td><a href = ../problem.php?id=' .string_to_url($row['name']). '>'.$row['name'].'</a></td>
                        <td style = "width:150px;"><a href = editques.php?id=' .string_to_url($row['name']).'>edit</a></td>
                        <td style = "width:150px"><a style = "color:red;" href = delete.php?id=' .string_to_url($row['name']).'>delete</a></td>
                       </tr> ';
            }
            echo "</table>
                    </div>"
       
        ?>



    </body>
</html>