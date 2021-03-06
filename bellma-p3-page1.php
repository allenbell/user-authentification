<?php
session_start();
?>

<html>
    <body>
        <h1>Page 1</h1>
        <p></p>

<?php
//test to see if a valid user has logged in
if (isset($_SESSION['valid_user'])) {
    
    //connect to the database
    require "/export/home/b/bellma/private/dbconnect2.php";
    //make myaddslashes_i() available
    require "/export/home/b/bellma/private/myaddslashes_i.php";
    
    //initialize variables, sanitized with myaddslashes_i()
    $username = myaddslashes_i($_POST['valid_user'], $db);
    $usertype = myaddslashes_i($_POST['user_type'], $db);

    echo '<p>You are logged in as '.$_SESSION['valid_user'].'</p>';
    
    //display a message tailored to a particular usertype
    if ($_SESSION['user_type'] == "jediknight") {
        echo 'Welcome, '.$_SESSION['valid_user'].'. You are logged in as a Jedi Knight. '; 
        echo 'Use the force. <br />';
    } elseif ($_SESSION['user_type'] == "stormtrooper") {
        echo 'Welcome, '.$_SESSION['valid_user'].'. You are logged in as a Storm Trooper.';
        echo '<br />';
    }  
    //if there's not a recognized usertype logged in, tell the user "You're not logged in"
    else {
    echo 'You are not logged in. <br />';
    echo '<a href="bellma-p3-login.php">Log in</a> <br />';
    } 
    
    //navigation links
    echo '<a href="bellma-p3-page1.php">1</a> &nbsp;&nbsp;';
    echo '<a href="bellma-p3-page2.php">2</a> &nbsp;&nbsp;';
    echo '<a href="bellma-p3-page3.php">3</a> &nbsp;&nbsp;';
    echo '<a href="bellma-p3-page4.php">4</a> &nbsp;&nbsp;';
    echo '<a href="bellma-p3-logout.php">Log Out</a>';
}
?>

    </body>
</html>
