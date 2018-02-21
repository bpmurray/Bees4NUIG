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

   if ($_POST) { // Is this the newpassword request?
      if (session_status() != PHP_SESSION_ACTIVE) {
         session_start();
      }

      $email = $_POST['email'];

      try {   

         $stmt = $db_con->prepare("SELECT * FROM beekeeper WHERE email=:email");
         $stmt->execute(array(":email"=>$email));

         if ($stmt->rowCount() === 1) { 
            $beekeeper = $stmt->fetch(PDO::FETCH_BOTH);
            $name  = $beekeeper['name'];
            $id    = $beekeeper['beekeeperid'];
            $token = base64_encode(mcrypt_create_iv(22, MCRYPT_DEV_URANDOM));

            $stmt = $db_con->prepare("UPDATE beekeeper SET token=:token WHERE beekeeperid=:id");
            $stmt->bindParam(':token', $token);
            $stmt->bindParam(':id', $id);

            if ($stmt->execute()) {
               $subject = 'Please reset your password';
               $message = '<html><head>
                     <title>NUIG/NIHBS Varroa Project</title>
                     </head><body><h1>NUIG/NIHBS Varroa Project</h1>
                     Dear ' . $name . '<br /><br />
                     Please change your password by clicking
		               <a href="https://coolfore.com/changepassword.php?x=' . urlencode($token) .
                     '">here</a>.<br /><br />Regards<br />Registration Team</body></html>';

               $headers = 'From: no-reply@coolfore.com' . "\n" .
                          'Reply-To: registration@coolfore.com' . "\n" .
                          'Content-type: text/html; charset=utf-8' . "\n" .
                          'X-Mailer: PHP/' . phpversion();

               mail($email, $subject, $message, $headers);

               $_SESSION['email'] = $email;
          
               echo "mailsent";
            } else {
               echo "Query could not execute !";
            }
         } else {
            echo "1"; //  not available
         }
      } catch(PDOException $e) {
         echo $e->getMessage();
      }
   } else { // Not POST - we'll assume GET

   include 'head.php';
?>
   <div class="signin-form">
      <div class="container">
         <form class="form-signin" method="post" id="newpassword-form">
            <h2 class="form-signin-heading">Change your password</h2>
            <hr />

            <div id="error"></div>

            <div class="form-group">
               <input type="email" class="form-control" placeholder="Email address"
                      title="Please provide your E-mail address." name="email" id="email" autocomplete="section-register email" />
               <span id="check-e"></span>
            </div>

            <hr />

            <div class="form-group">
               <button type="submit" class="btn btn-default" name="btn-submit" id="btn-submit" title="Click to change your password">
                  <span class="glyphicon glyphicon-lock"></span> &nbsp; Change Password
               </button> 
            </div>  
            
         </form>
       </div>
   </div>

<?php
   include 'foot.php';
   } // else not POST
?>
