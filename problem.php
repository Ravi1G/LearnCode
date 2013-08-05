    <?php
    
        error_reporting(E_ALL);
        ini_set('display_errors'.'1');
        session_start();
        if(!isset($_SESSION['username']))
        header("Location:index.php?id=4");
        include 'server_constraints.php';
        include 'function.php';
        $con = mysqli_connect($host, $server_username, $server_password, $db);
?>
<html>
    <head>
        <script language="javascript" type="text/javascript" src="js/editarea_0_8_2/edit_area/edit_area_full.js"></script>
        <script language="javascript" type="text/javascript" src="js/jquery.js"></script>
        <script language="javascript" type="text/javascript" src="js/jquery.autosize.js"></script>
        <script language="javascript" type="text/javascript">
        editAreaLoader.init({
                id : "area"		// textarea id
                ,syntax: "css"			// syntax to be uses for highgliting
                ,start_highlight: true		// to display with highlight mode on start-up
        });
        </script>
        <script>
			$(function(){
				$('.normal').autosize();
				$('.animated').autosize({append: "\n"});
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
    <div id = "splitter" style="margin-top:20px">
        <div id = "problem" style = "float:left; width:50%">
            <div id = "prob-header">
                <div style="float:left;width:40%;">
                    <ul>
                        <li>
                            <?php
                                $query = "select * from questions where `name` = '".$_GET['id']."' ";
                                $result = mysqli_query($con,$query);
                                echo mysqli_error($con);
                                $row = mysqli_fetch_array($result);
                                echo $row['id'].".";
                                
                            ?>
                        </li>
                        <li>
                            <?php
                            echo $row['name']."(".$row['difficulty'].")";
                            ?>
                        </li>
                    </ul>
                </div>
                <div >
                    <?php echo $_GET['id'];?>
                <a style="color:white;" href = <?php echo "bestsolutions.php?id=".string_to_url($_GET['id']);?>>Best Solutions</a>
                </div>
            </div>
        <textarea class = "normal" style="background-image:url('images/cream_pixels.png'); outline: none; border: none" cols = "80"  readonly>
<?php
        $problem_name = url_to_string($_GET['id']);
        
        $file_name = "questions/".$problem_name.".txt";
        $file = fopen($file_name,'r');
        $content = fread($file,filesize($file_name));
        $j = 0;
        $enter = 1;
        echo $content;
        /*while($j<strlen($content))
        {
            /*if($content[$j] == "\n")
            echo "<br>";
            else
            echo $content[$j];*/
        /*    if($content[$j] == "\n")
            {
                $enter = 1;
                echo "<br>";
            }
            if($enter == 1)
            {
                if(!strcmp($content[$j],' '))
                    echo "here&nbsp";
                else
                  $enter = 0;
            }
            else
                echo $content[$j];
            $j++;
        }*/
?>
        </textarea>
        </div>
        <div  style = "float:right ;width:50%">
        <form action = "code-result.php?id=<?php echo string_to_url($problem_name);?>" method = "post" id = "main-form">
            <label>Language</label><select name = "lang">
                                        <option value = "C">C</option>
                                        <option value = "C++">C++</option>
                                    </select><br>
           <textarea id = "area" name = "code-area" rows = "30" cols = "80">
/*enter your code here*/

#include<stdio.h>
int main()
{
    int t;
    scanf("%d",&t);
    int n;
    while(t--)
    {
        scanf("%d",&n);
        printf("%d\n",n*n);
    }
    return 0;
}

           </textarea>
           <br>
           <input type = "submit" name ="whole-code-submit" class = "button" value = "normal">
            <input type = "submit" name ="func-code-submit" class = "button" value = "function">
        </form>
        </div>
    </div>
</body>
</html>