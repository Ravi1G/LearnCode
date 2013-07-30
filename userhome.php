<?php
error_reporting(E_ALL);
    ini_set('display_errors', '1');
    include 'server_constraints.php';
    session_start();
    $user = $_SESSION['username'];
    echo "Hi $user.... sssuuuppp!!!<br><br>";
    $con = mysqli_connect($host,$server_username, $server_password, $db);
    
    echo "display profile info and submissions<br>";
    echo '<table>
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
        echo '<tr>
                <td><a href = "codedisplay.php?id='   .$row['code_num'].    '">'   .$row['code_num'].    '</a></td>
                <td>'.$row['question'].'</td>
                <td>'.$row['sub_time'].'</td>
                <td>'.$row['result'].'</td>
              </tr>';
            
    }
    echo '</table>'
    
?>