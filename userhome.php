<?php
error_reporting(E_ALL);
    ini_set('display_errors', '1');
    include 'server_constraints.php';
    include 'function.php';
    session_start();
    if(!isset($_SESSION['username']))
        header("Location:index.php?id=4");
    $user = $_SESSION['username'];
    $con = mysqli_connect($host,$server_username, $server_password, $db);
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
    echo '<table class = "table-style">
            <th>id</th>
            <th>question</th>
            <th>time</th>
            <th>status</th>
            ';
    $query = "SELECT * from code_submissions where username = '$user'";
    if(mysqli_query($con,$query))
        $result = mysqli_query($con,$query);
    else
        echo "fas".mysqli_error($con);
    while($row = mysqli_fetch_array($result))
    {
        //messed up commas but working :P
        $color = "#d4edc9";
        if(!$row['status'])
            $color = "#f9e3e3";
        
        echo '<tr >
                <td style = "background:'.$color.'"><a href = "codedisplay.php?id='   .$row['code_num'].    '" target = "_blank">'   .$row['code_num'].    '</a></td>
                <td style = "background:'.$color.'"><a href = "problem.php?id='.string_to_url($row['question']).'">'.$row['question'].'</a></td>
                <td style = "background:'.$color.'">'.$row['sub_time'].'</td>
                <td style = "background:'.$color.'">'.$row['result'].'</td>
              </tr>';
            
    }
    echo '</table>'
    
?>