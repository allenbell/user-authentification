<?php
    session_start();
    
    $valid_user = $_SESSION['valid_user'];
    unset($_SESSION['valid_user']);
    session_destroy();
?>
<html>
    <body>
        <a href="bellma-p3-login.php">Log in</a>
    </body>
</html>
