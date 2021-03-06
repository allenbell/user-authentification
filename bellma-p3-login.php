<?php
 
    session_start();
    
    //if the user has entered something into the username and password fields...
    if (isset($_POST['username']) && isset ($_POST['password'])) {
        
        //connect to the database
        require "/export/home/b/bellma/private/dbconnect2.php"; 

        //make sure the database connection worked
        if (!$db) {
            die('Connect Error: ' . mysqli_connect_error());
        }
    
        //filter user input
        if (get_magic_quotes_gpc()) {
            $username = htmlentities(strip_tags(stripslashes($_POST['username'])));
            $password = htmlentities(strip_tags(stripslashes($_POST['password'])));
        }
        else {
            $username = htmlentities(strip_tags($_POST['username']));
            $password = htmlentities(strip_tags($_POST['password']));
        }
    
        //trim the user input
        $username = trim($username);
        $password = trim($password);
        
        //initialize all other variables
        $query = '';
        $stmt = '';
        $num_rows = '';
        $usertype = '';
        
        //match the user input against username and encrypted password in the db
        $query = "SELECT usertype from p3users WHERE username=? and password=sha1(?)";
        
        //prepared statement for layer of security between user and db     
        if ($stmt = mysqli_prepare($db, $query)) {

            //bind parameters
            mysqli_stmt_bind_param($stmt, 'ss', $username, $password); 

            //execute query
            mysqli_stmt_execute($stmt);
                
            //bind results
            mysqli_stmt_bind_result($stmt, $usertype);
               
            //store result so num rows can be counted
            mysqli_stmt_store_result($stmt);
            
            //fetch results, i.e. usertype, so $_SESSION['user_type] will work
            mysqli_stmt_fetch($stmt);           
        }
                  
        //$num_rows should = 1 if there is a username/password match
        $num_rows = mysqli_stmt_num_rows($stmt);
                
        if ($num_rows > 0) {
            //$row = mysqli_fetch_row($result);  //will need to do binding to make work
            $_SESSION['valid_user'] = $username;
            $_SESSION['user_type'] = $usertype;
        }
                                
        //close the db connection
        mysqli_close($db); 
    }        
?>

<!--begin HTML-->
<html>
    <body>
        <h1>Welcome</h1>
        
<?php   
    //if username/password match found, tell user she is logged in
    if (isset($_SESSION['valid_user'])) {
        echo 'You are logged in.<br />';
    
?>
  
        <!--navigation links-->
        <a href="bellma-p3-page1.php">1</a> &nbsp;&nbsp;
        <a href="bellma-p3-page2.php">2</a> &nbsp;&nbsp;
        <a href="bellma-p3-page3.php">3</a> &nbsp;&nbsp;
        <a href="bellma-p3-page4.php">4</a> &nbsp;&nbsp;
        <a href="bellma-p3-logout.php">Log Out</a>
  
<?php  
  
    }else {
        //if username exists but password is incorrect or absent
        if (isset($username)) {
            echo 'Login failed.<br />';
        }
    //HTML below is part of this else statement...
?>        
            
        <!--Login form-->
        <h1>Please log in</h1>
        <form method="post" action="bellma-p3-login.php">
            <p>Username:&nbsp;<input type="text" name="username"></p>
            <p>Password:&nbsp;<input type="password" name="password"></p>
            <input type="submit" value="Login">
        </form>

<?php
    //close the else statement 
    }
?>

    </body>
</html>
