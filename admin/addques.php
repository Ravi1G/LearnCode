<?php
error_reporting(E_ALL);
   ini_set('display_errors', '1');
    session_start();
    include '../server_constraints.php';    
    $con = mysqli_connect($host, $server_username, $server_password, $db);
    if(isset($_GET['id']))
    {
        $_SESSION['ques-name'] = $_GET['id'];
        $f = fopen("../questions/".$_GET['id'].".txt",'r');
        $_SESSION['ques-statement'] = fread($f,filesize("../questions/".$_GET['id'].".txt"));
        fclose($f);
    }
?>
<html>
    <head>
        <script language="javascript" type="text/javascript" src="../js/editarea_0_8_2/edit_area/edit_area_full.js"></script>
        <script language="javascript" type="text/javascript">
        editAreaLoader.init({
                id : "area"		// textarea id
                ,syntax: "css"			// syntax to be uses for highgliting
                ,start_highlight: true		// to display with highlight mode on start-up
        });
        </script>
        <title>D-odge</title>
        <link href="../css/style.css" rel="stylesheet">
        <style>
            .error{
                background:rgb(200,50,10); border-radius:2px; color:white;padding:10px 20px;
            }
            #alert-div{
                width:500px;
                margin-left:300px;
                padding:10px 20px;
            }
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

<div id = "alert-div">
<?
  /*  
     echo "Upload: " . $_FILES["input-file"]["name"] . "<br>";
  echo "Type: " . $_FILES["input-file"]["type"] . "<br>";
  echo "Size: " . ($_FILES["input-file"]["size"] / 1024) . " kB<br>";
  echo "Stored in: " . $_FILES["input-file"]["tmp_name"];
  
  echo "<br><br>";
   echo "Upload: " . $_FILES["output-file"]["name"] . "<br>";
  echo "Type: " . $_FILES["output-file"]["type"] . "<br>";
  echo "Size: " . ($_FILES["output-file"]["size"] / 1024) . " kB<br>";
  echo "Stored in: " . $_FILES["output-file"]["tmp_name"];*/
    /*INput and output files*/
    if(isset($_POST['ques-statement']) && isset($_POST['ques-name']) && isset($_POST['ques-level']))
    {
        $query = "select * from questions where name = '".$_POST['ques-name']."'";
        if(mysqli_query($con,$query))
         $res = mysqli_query($con,$query);
        else
            echo "<p class = \"error\">".mysqli_error($con)."</p>";
        if(mysqli_num_rows($res)==0)
        {
            $allowedExts = array("txt");
            $temp = explode(".", $_FILES["input-file"]["name"]);
            $extension = end($temp);
            $err = false;
            if ($_FILES["input-file"]["error"] > 0)
            {
                $err = true;
                echo "<p class = \"error\">"."Error: Input file" . $_FILES["input-file"]["error"] . "</p>";
            }
            else if (($_FILES["input-file"]["size"] > 2000000) || !in_array($extension, $allowedExts))
            {
                
                $err = true;
                echo "<p class = \"error\">"."input file size > 20kb or its not .txt extension</p>";
            }
                /*end*/
            if(!$err)
            {
                //output file
                $temp = explode(".", $_FILES["output-file"]["name"]);
                $extension = end($temp);
                if ($_FILES["output-file"]["error"] > 0)
                {
                    $err = true;
                    echo "<p class = \"error\">"."Error: Input file" . $_FILES["output-file"]["error"] . "</p>";
                }
                else if (($_FILES["output-file"]["size"] > 2000000) || !in_array($extension, $allowedExts))
                {  
                    $err = true;
                    echo "<p class = \"error\">"."output file size > 20kb or its not .txt extension</p>";
                }
                if(!$err)
                {
                    $query = "INSERT into questions (difficulty, statement, name) values ('".$_POST['ques-level']."', '".$_POST['ques-statement']."', '".$_POST['ques-name']."')";
                    if(!mysqli_query($con,$query))
                        echo "<p class = \"error\">".mysqli_error($con)."</p>";
                    $f = fopen("../input/" . $_POST['ques-name'].".txt",'w');
                    fclose($f);
                    $f = fopen("../output/" . $_POST['ques-name'].".txt",'w');
                    fclose($f);
                    echo "<h1>".$_POST['ques-name']."</h1>";
                    move_uploaded_file($_FILES["input-file"]["tmp_name"],
                    "../input/" . $_POST['ques-name'].".txt");
                    echo "Stored in: " . "../input/" . $_POST['ques-name'].".txt";
                    move_uploaded_file($_FILES["output-file"]["tmp_name"],
                    "../output/" . $_POST['ques-name'].".txt");
                    echo "Stored in: " . "../output/" . $_POST['ques-name'].".txt";
                    // to be removed
                    $ques_file_name = "../questions/".$_POST['ques-name'].".txt";
                    $ques_file = fopen($ques_file_name,'w');
                    fwrite($ques_file,$_POST['ques-statement']);
                    fclose($ques_file);
                    header("Location: adminhome.php?id=1");
                   
                }
            }
        }
        else
        echo "<p class = \"error\">"."change the question name as the question already exists</p>";
    }
?>
</div>
<div style = "margin-left: 30px; margin-top : 30px;">
<form action = "addques.php" method = "post" enctype='multipart/form-data'>
    name <input type = "text" name = "ques-name" value = "<?php if(isset($_POST['ques-name']))
                                                                    echo $_POST['ques-name'];
                                                                else if(isset($_SESSION['ques-name']))
                                                                    echo $_SESSION['ques-name'];
                                                                else
                                                                     echo "";?>">level <select name = "ques-level">
                                                            <option value = "A">A</option>
                                                            <option value = "B">B</option>
                                                            <option value = "C">C</option>
                                                        </select><br/></br>
    <textarea cols = "80" rows = "30" name = "ques-statement"><?php if(isset($_POST['ques-statement']))
                                                                                         echo $_POST['ques-statement'];
                                                                                    else if(isset($_SESSION['ques-statement']))
                                                                                        echo $_SESSION['ques-statement'];
                                                                                    else
                                                                                       echo "";?></textarea></br>
    <label> Input file</label><input type = "file" name = "input-file"></br>
    <label>Output file</label><input type = "file" name = "output-file"></br>
    <input type ="submit" class = "button" value = "add">
</form>
</div>




    </body>
</html>