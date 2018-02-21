<?php
   if (session_status() === PHP_SESSION_ACTIVE) {
	   header("location: showuser.php");
   } else {

      session_start();
      session_unset();
      session_destroy();

      include 'head.php';
?>
   <div class="container" style="text-align: center;">
      <a href="login.php" class="ui-button ui-widget ui-corner-all" title="Click to go to the login page" >
         <span class="glyphicon glyphicon-log-in"></span> &nbsp;Login
      </a>
      <a href="register.php" class="ui-button ui-widget ui-corner-all" title="Click to go to the registration page">
         <span class="glyphicon glyphicon-user"></span> &nbsp;Register
      </a>
   </div>

<?php
   include 'foot.php';
   } // else
?>
