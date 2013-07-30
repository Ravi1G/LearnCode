<?php
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    session_start();
    
    include 'function.php';
    include 'server_constraints.php';
    $con = mysqli_connect($host, $server_username, $server_password, $db);
?>

<html>
    <head>
        <script language="javascript" type="text/javascript" src="js/editarea_0_8_2/edit_area/edit_area_full.js"></script>
        <script language="javascript" type="text/javascript">
        editAreaLoader.init({
                id : "area"		// textarea id
                ,syntax: "css"			// syntax to be uses for highgliting
                ,start_highlight: true		// to display with highlight mode on start-up
        });
        </script>
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
    $code = $_POST['code-area'];
    $user = $_SESSION['username'];
 
    if(isset($_POST['whole-code-submit']))
    {
        //create file
        $question_name = "square";                        //TODO     
        $query = "select number from code_number where id = '1'";
        $code_num_obj = mysqli_query($con,$query);
        //echo mysqli_num_rows($code_num);
        $row = mysqli_fetch_array($code_num_obj);
        $code_num = $row['number'];                      // the numbe/name of file that will be created
        /*{
            header("Location: index.php?id=5");
        }*/
        $query = "update code_number set number='".($row['number']+1)."' where id='1'";
        if(!mysqli_query($con,$query))
        {
            echo mysqli_errno();
        }
         $query = "INSERT INTO code_submissions (`id`,`username`,`question`, `code_num`)
                      values (NULL,'$user','$question_name','$code_num')";
            mysqli_query($con, $query);
        $code_file_name = "codes/".$code_num.".c";
        $code_file = fopen($code_file_name,'w');
        //  echo fread($code_file,filesize("questions/square.txt"));
        fwrite($code_file,$code);
        fclose($code_file);
                             /****************Code for COMPILE CODE***************/
        $compile_output_file_name = "compiler_output/".$code_num.".txt";
        exec("gcc $code_file_name 2> $compile_output_file_name");
        $compile_output_file = fopen($compile_output_file_name,'r');
        $compile_output_data = fread($compile_output_file,filesize($compile_output_file_name));
        
        fclose($compile_output_file);
        $error = false;
        for($i = 0;$i <filesize($compile_output_file_name); $i++)
        {
          if($compile_output_data[$i] == 'e')
          {
            if(substr($compile_output_data,$i,6) == 'error:')
            {
                $error = true;
                break;
            }
          }
        }
        if($error)
        {
                $time = date("Y-m-d H:i:s");
            //echo "<br>$time";#ffe3e3
            echo "<br><span style = \"background:rgb(184,50,0); color:white; margin-left:400px; padding:10px;\">Oops!!!! Compilation error</span>";
            $j =0;
            echo "<div id = \"comp-output\" style = \"color:red; margin-left:50px;\">";
            while($j<strlen($compile_output_data))
            {
                if($compile_output_data[$j] == 'c')
                {
                    //echo substr($compile_output_data,$j,6)."<br>";
                    if(substr($compile_output_data,$j,6) == "codes/")
                        echo "<br>> c";
                    else echo $compile_output_data[$j];
                }
                else
                  echo $compile_output_data[$j];
                $j++;
            }
            echo "</div>";
            $query = "UPDATE code_submissions SET status ='0', result = 'compilation error', sub_time = '$time' where code_num = '$code_num'";
            if(!mysqli_query($con, $query))
                echo mysqli_error($con);
        
        }
        else
        {
            //echo "<br>successs";
            /*******************************RUN CODE******************************/
            
            $expected_output_file_name = "output/".$question_name.".txt";
            $input_file_name = "input/".$question_name.".txt";
            $user_output_file_name = "user_output/".$code_num.".txt";// TODO read from database
            $execute_res = execute("./a.out <".$input_file_name." >".$user_output_file_name, null, $out, $out, 5);
            if(!$execute_res)
            {
                $time = date("Y-m-d H:i:s");
                $query = "UPDATE code_submissions SET status ='0', result = 'runtime error', sub_time = '$time' where code_num = '$code_num'";
                if(!mysqli_query($con, $query))
                    echo mysqli_error($con);
                exit("<br><span style=\"background:rgb(184,50,0); color:white; margin-left:400px; padding:10px;\">Run time Error..... there might be come infinite loop in your code</span>");
            }
           // exec("./a.out <".$input_file_name." >".$user_output_file_name);  //Todo replace with execute write for segmentation fault
            $out_file = fopen($expected_output_file_name,'r');
            $user_output_file = fopen($user_output_file_name,'r');
            //$expected_output = fread($out_file,filesize("output.txt"));
            //echo $expected_output;
            echo "<div id = \"comp-output\" style = \"margin-left:50px;\">";
            $accepted = true;
            echo "<table class = \"table-style\">
                    <tr><th>output</th>
                    <th>expected</th></tr>";
            /*while(!feof($out_file))
            {
                echo fgets($out_file);
            }*/
          while(!feof($out_file) || !feof($user_output_file))
            {
                if(!feof($user_output_file))
                {
                    $i = fgets($user_output_file);
                    echo "<tr><td>$i</td>";
                    //echo "i $i<br>";
                }
                if(!feof($out_file))
                {
                    $j = fgets($out_file);
                    //echo $j."<br>";
                    echo "<td>$j</td></tr>";
                }
                if(strcmp(($i),$j))
                {
                    //echo ">here $i    $j";
                    $accepted = false;
                }
            }
            $time = date("Y-m-d H:i:s");
             if($accepted)
            {
                echo "Solution Accepted!!<br>";
                $query = "UPDATE code_submissions SET status ='1', result = 'accepted', sub_time = '$time' where code_num = '$code_num'";
                if(!mysqli_query($con, $query))
                {
                    echo "not added db error".mysqli_error($con);
                }
            }
            else
            {
                 $query = "UPDATE code_submissions SET status ='0', result = 'wrong answer', sub_time = '$time' where code_num = '$code_num'";
                if(mysqli_query($con, $query))
                {
                    echo ":(";
                }
                else
                echo "not added db error".mysqli_error($con);
            }
            echo "</div>";
            
        }
            
            
            
            
        
        /*
        echo " ";
        //echo exec("pwd");
        $compile_output_file = fopen("compile_output.txt",'w');
        fclose($compile_output_file);
        exec("gcc -g temp.c 2> compile_output.txt");
        $compile_output_file = fopen("compile_output.txt",'r');
        $compile_output_data = fread($compile_output_file,filesize("compile_output.txt"));
        
        fclose($compile_output_file);
        $error = false;
        for($i = 0;$i <filesize("compile_output.txt"); $i++)
        {
          if($compile_output_data[$i] == 'e')
          {
            if(substr($compile_output_data,$i,6) == 'error:')
            {
                $error = true;
                break;
            }
          }
        }
        if($error)
        {
            exit( "Oops!!!! Compilation error<br/>here is the verbose generated by the compiler<br/>$compile_output_data");
        }
        else
        {
            exec("./a.out <input.txt",$prog_output);
            $out_file = fopen("output.txt",'r');
            //$expected_output = fread($out_file,filesize("output.txt"));
            echo $expected_output;
            
            $accepted = true;
            echo "prog  expetec</br>";
            foreach($prog_output as $i)
            {
                $j = fgets($out_file);
                echo "$i   $j <br/>";
                if(!strcmp(($i),$j))
                {
                    echo "here $i    $j";
                    $accepted = false;
                    break;
                }
            }
             if($accepted)
                exit("Solution Accepted!!");
            else
                exit("wrong answer");
        }*/
        
    }/*************************************TOPCODER*****************************************/
    else
    {
        echo "topcoder<br/>";
        $code_file = fopen("temp.c",'w');
        $header_file = fopen("headers.txt",'r');
        $headers = fread($header_file,filesize("headers.txt"));
        fclose($header_file);
        fwrite($code_file,$headers);
        fwrite($code_file,$code);
        $tester_code_file = fopen("tester.cpp",'r');
        $tester_code = fread($tester_code_file,filesize("tester.cpp"));
        
        fclose($tester_code_file);
        fwrite($code_file,$tester_code);
        fclose($code_file);
        exec("g++ temp.c 2> compile_output.txt");
        $compile_output_file = fopen("compile_output.txt",'r');
        $compile_output_data = fread($compile_output_file,filesize("compile_output.txt"));
        
        fclose($compile_output_file);
        $error = false;
        for($i = 0;$i <filesize("compile_output.txt"); $i++)
        {
          if($compile_output_data[$i] == 'e')
          {
            if(substr($compile_output_data,$i,6) == 'error:')
            {
                $error = true;
                break;
            }
          }
        }
        if($error)
        {
            exit( "Oops!!!! Compilation error<br/>here is the verbose generated by the compiler<br/>$compile_output_data");
        }
        else
        {
            echo "compiled successful<br/>";
           exec("./a.out",$x);
           $user_output_file = fopen("user_output.txt",'r');
           
           echo '<br/> <br/><br/>
           <div id = "analysis">
                <table id = "ana_table">"
                    <th>Case</th>
                    <th>Input</th>
                    <th>Output</th>
                    <th>Expected</th>
                    <th>Time</th>
                    <th>Status</th>';
           $count = 0; // when count %4 == 0 then create a new row in the table
           while(!feof($user_output_file))
           {
                $line = fgets($user_output_file);
                if(strlen($line) == 0)
                    break;
                if($count % 5 == 0)  //strpos($line,"User Output:") === false)
                {
                    echo "</tr>";
                    $inp = substr($line,6);
                    $case = $count/5;
                    echo "<tr><td>#$case</td>";
                    echo "<td>$inp</td>";
                    $count++;
                }
                else
                {
                    if($count % 5 == 1)
                    {
                        echo "<td>";
                        echo substr($line,13);
                        echo "</td>";
                    }
                    else if($count % 5== 2)
                    {
                        echo "<td>";
                        echo substr($line,13);
                        echo "</td>";
                    }
                    else if($count % 5 == 3)
                    {
                        echo "<td>";
                        echo substr($line,6);
                        echo "</td>";
                    }
                    else if($count % 5 == 4)
                    {
                        echo "<td>";
                        echo substr($line,7);
                        echo "</td>";
                    }
                    $count++;
                }
           }
           echo "</table></div>";
           /* $out_file = fopen("output.txt",'r');
            //$expected_output = fread($out_file,filesize("output.txt"));
            echo $expected_output;
            
            $accepted = true;
            echo "prog  expetec</br>";
            foreach($prog_output as $i)
            {
                $j = fgets($out_file);
                echo "$i   $j <br/>";
                if(!strcmp(($i),$j))
                {
                    echo "here $i    $j";$
                    $accepted = false;
                    break;
                }
            }
             if($accepted)
                exit("Solution Accepted!!");
            else
                exit("wrong answer");*/
        }
        
    }
    
 
    
?>
    </body>
</html>