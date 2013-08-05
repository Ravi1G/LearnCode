<html>
    <head>
        <title>D-odge</title>
        <link href="css/style.css" rel="stylesheet">
                <script src="js/jquery.js"></script>
            <script src="js/jquery.validate.js"></script>
        
            <script>
               $("#loginform").validate();
               $("#signup").validate();
                </script>
    </head>
    <body>
        <div id = "header">
            <div id = "logo">
                D-odge  ^
            </div>
            <div id = "loginform">
                            <form id = "login" action = "login.php" method = "post">
                Username &nbsp<input type="text" name = "login_username" required>&nbsp&nbsp
                Password &nbsp<input type = "password" name ="login_passwd" required>&nbsp&nbsp
                <input type = "submit" name = "Login" class = "button" value = "Login">
            </form>
            </div>
        </div>
         <div id = "alert_div">
            <?php
                $id = $_GET['id'];
                if($id == 1)
                    echo "<p style=\"background:#9ACD32; border-radius:2px; color:white;\"> &nbsp&nbsp&nbspregistration successful</p>";
                else if($id == 2)
                    echo "<p style=\"background:rgb(200,50,10); border-radius:2px; color:white;\">&nbsp&nbsp&nbspWrong Username/password</p>";
                else if($id == 3)
                    echo "<p style=\"background:rgb(200,50,10); border-radius:2px; color:white;\">&nbsp&nbsp&nbsp Username already registered</p>";
                else if($id == 4)
                    echo "<p style=\"background:rgb(200,50,10); border-radius:2px; color:white;\">&nbsp&nbsp&nbsp Session Expired</p>";
            ?>
        </div>
        <div id = "register_div">
            <p>
                <h3>Register</h3>
            </p>
            <form id = "signup" action = "register_user.php" method="post">
                <table>
                <tr>
                    <td>Username </td>
                    <td><input name = "username" type="text" required/></td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td><input name="email" type="email" required></td>
                </tr>
                <tr>
                    <td>Passsword</td>
                    <td><input name="passwd" type="password" required/></td>
                </tr>
                </table>
                <input style = "margin-left:80px;" type="submit" class ="button" name ="submit_button" value = "Register">              
            </form>
        </div>
       
    </body>
</html>
