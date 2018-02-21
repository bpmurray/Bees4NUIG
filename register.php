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

   if ($_POST) { // Is this the registration request?
      $name         = $_POST['name'];
      $email        = $_POST['email'];
      $password     = $_POST['password'];
      $salt         = mcrypt_create_iv(22, MCRYPT_DEV_URANDOM);
      $options      = [ 'cost' => 11, 'salt' => $salt ];
      $password     = base64_encode(password_hash($password, PASSWORD_BCRYPT, $options));
      $token        = base64_encode(mcrypt_create_iv(22, MCRYPT_DEV_URANDOM));

      try {   

         $stmt = $db_con->prepare("SELECT * FROM beekeeper WHERE email=:email");
         $stmt->execute(array(":email"=>$email));
         $count = $stmt->rowCount();

         if ($count === 0) { 
            $stmt = $db_con->prepare("INSERT INTO beekeeper(name,email,password,salt,token) VALUES(:name, :email, :pass, :salt, :token)");
            $stmt->bindParam(":name", $name);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":pass", $password);
            $stmt->bindParam(":salt", $salt);
            $stmt->bindParam(":token", $token);

            if ($stmt->execute()) {

               $subject = 'Please confirm your registration';
               $message = '<html><head>
                     <title>Varroa Project Registration</title>
                     </head><body><h1>Varroa Project Registration</h1>
                     Dear ' . $name . '<br /><br />
                     Please confirm your varroa project registration by clicking
		               <a href="https://coolfore.com/confirmation.php?x=' . urlencode($token) .
                     '">here</a>.<br /><br />Regards<br />Registration Team</body></html>';

               $headers = 'From: no-reply@coolfore.com' . "\n" .
                          'Reply-To: registration@coolfore.com' . "\n" .
                          'Content-type: text/html; charset=utf-8' . "\n" .
                          'X-Mailer: PHP/' . phpversion();

               mail($email, $subject, $message, $headers);
          
               echo "registered";
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

   include 'head.php';
?>
   <div class="signin-form">
      <div class="container">
         <form class="form-signin" method="post" id="register-form">
            <h2 class="form-signin-heading">Register for the varroa project</h2>
            <hr />

            <div id="error"></div>

            <div class="form-group">
               <input type="text" class="form-control" placeholder="Name"
                      title="What is your full name?" name="name" id="name" autocomplete="section-register name" />
            </div>

            <div class="form-group">
               <input type="email" class="form-control" placeholder="Email address"
                      title="Please provide your E-mail address. This will be used to login in the future." name="email" id="email" autocomplete="section-register email" />
               <span id="check-e"></span>
            </div>

            <div class="form-group">
               <input type="password" class="form-control" placeholder="Create your password"
                      title="Please decide on a password. We do not know your password!" name="password" id="password" autocomplete="section-register new-password" />
            </div>

            <div class="form-group">
               <input type="password" class="form-control" placeholder="Retype Password" 
                      title="Please repeat the above password to ensure you have not mistyped something." name="cpassword" id="cpassword" autocomplete="section-register new-password" />
            </div>

            <hr />

            <div class="form-group">
               <button type="submit" class="btn btn-default" name="btn-submit" id="btn-submit" title="Click to complete your registration">
                  <span class="glyphicon glyphicon-user"></span> &nbsp; Register 
               </button> 
            </div>  
            <div class="form-group footing">
                Please note: by registering, you are accepting our
                <a href="terms.php" target="_blank">terms and conditions</a>.
            </div>  
            
         </form>
       </div>
   </div>

<?php
   include 'foot.php';
   } // else not POST
?>
