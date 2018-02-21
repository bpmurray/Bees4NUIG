<?php

   require_once 'dbconfig.php';

   if ($_POST) {
      if (session_status() != PHP_SESSION_ACTIVE) {
         session_start();
      }
      session_destroy();

      $email     = $_POST['email'];
      $password  = $_POST['password'];

      try
      {   
         $stmt = $db_con->prepare("SELECT * FROM beekeeper WHERE email=:email");
         $stmt->execute(array(":email"=>$email));
         $count = $stmt->rowCount();

         if ($count === 1) { 
            $beekeeper = $stmt->fetch(PDO::FETCH_BOTH);

            $salt       = $beekeeper['salt'];
            $activated  = intval($beekeeper['activated']);
            $options    = [ 'cost' => 11, 'salt' => $salt ];
            $password   = base64_encode(password_hash($password, PASSWORD_BCRYPT, $options));
            if ($activated != 1) {
               echo "notactivated";
            } else if ($password != $beekeeper['password']) {
               echo "badpassword";
            } else {
               session_start();
               $_SESSION['name']  = $beekeeper['name'];
               $_SESSION['email'] = $beekeeper['email'];
               $_SESSION['id']    = $beekeeper['beekeeperid'];
               $_SESSION['admin'] = intval($beekeeper['admin']);
               echo "ok";
            }
         } else{
            echo "1"; //  not available
         }
      } catch(PDOException $e) {
         echo $e->getMessage();
      }
   } else {

   include 'head.php';
?>

   <div class="signin-form">
      <div class="container">
         <form class="form-signin" method="post" id="login-form">
            <h2 class="form-signin-heading">Login</h2><hr />

            <div id="error">
               <!-- error will be shown here ! -->
            </div>

            <div class="form-group">
               <input type="email" class="form-control" placeholder="Email address"
                      title="The E-mail address you used to register" name="email" id="email" autocomplete="section-signin email" />
               <span id="check-e"></span>
            </div>

            <div class="form-group">
               <input type="password" class="form-control" placeholder="Password"
                      title="Enter the password you chose at registration" name="password" id="password" autocomplete="section-signin password" />
            </div>

            <hr />

            <div class="form-group">
               <button type="submit" class="btn btn-default" name="btn-submit" id="btn-submit" title="Click to log in">
                  <span class="glyphicon glyphicon-log-in"></span> &nbsp;Login
               </button> 
               &nbsp;&nbsp;
               <a href="newpassword.php" class="btn btn-default" name="btn-chpassword" id="btn-chpassword">
                  <span class="glyphicon glyphicon-log-out"></span> &nbsp;Change Password
               </a> 
            </div>  
         </form>
       </div>
   </div>

<?php
   include 'foot.php';
   } // else
?>
