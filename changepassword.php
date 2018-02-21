<?php
/***************************************************************************
 *  Copyright 2017,2018 Brendan Murray
 *
 *  Licensed under the Apache License, Version 2.0 (the "License");
 *  you may not use this file except in compliance with the License.
 *  You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Unless required by applicable law or agreed to in writing, software
 *  distributed under the License is distributed on an "AS IS" BASIS,
 *  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *  See the License for the specific language governing permissions and
 *  limitations under the License.
 ***************************************************************************/

   require_once 'dbconfig.php';

   if (session_status() != PHP_SESSION_ACTIVE) {
      session_start();
   }

   if ($_POST) { // Is this the registration request?
      $email = $_SESSION['email'];

      try {   

         $stmt = $db_con->prepare("SELECT * FROM beekeeper WHERE email=:email");
         $stmt->execute(array(":email"=>$email));

         if ($stmt->rowCount() === 1) { 
            $beekeeper = $stmt->fetch(PDO::FETCH_BOTH);

            $password = $_POST['password'];
            $id       = $beekeeper['beekeeperid'];
            $salt     = mcrypt_create_iv(22, MCRYPT_DEV_URANDOM);
            $options  = [ 'cost' => 11, 'salt' => $salt ];
            $password = base64_encode(password_hash($password, PASSWORD_BCRYPT, $options));
            $stmt = $db_con->prepare('UPDATE beekeeper SET token="", password=:pass, salt=:salt WHERE beekeeperid=:id');
            $stmt->bindParam(":id", $id);
            $stmt->bindParam(":pass", $password);
            $stmt->bindParam(":salt", $salt);

            if ($stmt->execute()) {
               echo "updated";
            } else {
               echo "Query could not execute !";
            }
         } else{
            echo "1"; //  not available
         }
      } catch(PDOException $e) {
         echo $e->getMessage();
      }
   } else { // Not POST - we'll assume GET
      $token = $_GET['x'];
      try
      {   
         $stmt = $db_con->prepare("SELECT * FROM beekeeper WHERE token=:token");
         $stmt->bindParam(":token", $token);
         $stmt->execute();
         $count = $stmt->rowCount();

         if ($count === 1) { 
            $beekeeper = $stmt->fetch(PDO::FETCH_BOTH);
            $name  = $beekeeper['name'];
            $id    = $beekeeper['beekeeperid'];
            $email = $beekeeper['email'];

            $error = 0;
         }
      } catch(PDOException $e) {
         echo $e->getMessage();
      }


   include 'head.php';
?>
   <div class="signin-form">
      <div class="container">
         <form class="form-signin" method="post" id="changepassword-form">
            <h2 class="form-signin-heading">Change your password</h2>
            <hr />

            <div id="error"></div>

            <div class="form-group">
               <input type="password" class="form-control" placeholder="Create your password"
                      title="Please decide on a password." name="password" id="password" autocomplete="section-register new-password" />
            </div>

            <div class="form-group">
               <input type="password" class="form-control" placeholder="Retype Password" 
                      title="Please repeat the above password to ensure you have not mistyped something." name="cpassword" id="cpassword" autocomplete="section-register new-password" />
            </div>

            <hr />

            <div class="form-group">
               <button type="submit" class="btn btn-default" name="btn-submit" id="btn-submit" title="Click to update your password">
                  <span class="glyphicon glyphicon-lock"></span> &nbsp; Change Paassword 
               </button> 
            </div>  
            
         </form>
       </div>
   </div>

<?php
   include 'foot.php';
   } // else not POST
?>
