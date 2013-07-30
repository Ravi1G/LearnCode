<?php
    error_reporting(E_ALL);
    ini_set('display_errors'.'1');
    session_start();
    include 'server_constraints.php';
    $problem_name = $_GET['id'];
    $con = mysqli_connect($host, $server_username, $server_password, $db);
    echo "<table>
            <th>id</th>
            <th>username</th>
            <th>time</th>
            ";
    $query = "select * from code_submissions where question = '".$problem_name."' and result ='accepted'";
    $result = mysqli_query($con, $query);
    echo mysqli_error($con);
    while($row = mysqli_fetch_array($result))
    {
        echo '<tr>
                <td><a href = "codedisplay.php?id='   .$row['code_num'].    '">'   .$row['code_num'].    '</a></td>
                <td><a href = problem.php?id=' .$row['username']. '>'.$row['username'].'</a></td>
                <td>'.$row['sub_time'].'</td>
                </tr> ';
    }
?>