<?php
    error_reporting(E_ALL);
    ini_set('display_errors'.'1');
    session_start();
    if(!isset($_SESSION['username']))
        header("Location:index.php?id=4");
    include 'server_constraints.php';
    $con = mysqli_connect($host, $server_username, $server_password, $db);
    $num = $_GET['id'];
?>
<html>
 <head>
        <title>D-odge</title>
        <script language="javascript" type="text/javascript" src="js/editarea_0_8_2/edit_area/edit_area_full.js"></script>
        <script language="javascript" type="text/javascript">
        editAreaLoader.init({
                id : "area"		// textarea id
                ,syntax: "css"			// syntax to be uses for highgliting
                ,start_highlight: true		// to display with highlight mode on start-up
        });
        </script>
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
        <div style = "margin:20px 30px">
        <form method = "post" action = "problem.php">
    <textarea id = "area" cols = "80" rows = "30">
<?php
        $code_file_name = "codes/".$num.".".$_GET['lang'];

    $code_file = fopen($code_file_name,'r');
    $code = fread($code_file,filesize($code_file_name));
    $j = 0;
    $enter = 0;
    while($j< strlen($code))
    {
        echo $code[$j];
            $j++;
    }
    
  
?>
</textarea>
        </form>
        </div>
    </body>
</html>