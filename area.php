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
    </head>
    <body>
        <?php
           error_reporting(E_ALL);
           ini_set('display_errors', '1');
           session_start();
        ?>
        <a href = "userhome.php">home</a>&nbsp&nbsp<a href = "problemset.php">Problemset</a>
        <form action = "code-result.php" method = "post" id = "main-form">
           <textarea id = "area" name = "code-area" cols="50" rows="30">
            //enter your code here
            
            /*class FindSquare
            {
                public:
                int square(int x)
                {
                    return x*x;
                }
            };*/
            #include<stdio.h>
            int main()
            {
                int t;
                scanf("%d",&t);
                int n;
                while(t--)
                {
                    scanf("%d,&n);
                    printf("%d\n",n*n);
                }
                return 0;
            }
           </textarea>
           <input type = "submit" name ="whole-code-submit" value = "normal">
            <input type = "submit" name ="func-code-submit" value = "topcoder style">
        </form>
        
    </body>
</html>