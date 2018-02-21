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
   include 'head.php';
?>
   <script type="text/javascript">
      $('document').ready(function() { 
         //window.setTimeout(function(){
         //   window.location.href = "index.php";
         //}, 6000);
   
         $("#back").click(function(){
            window.location.href = "index.php";
         });
      });
   </script>

   <div class="signin-form">
      <div class="container">
         <div class='alert alert-success'>
            <button class='close' data-dismiss='alert'>&times;</button>

<?php

   require_once 'dbconfig.php';

   $error = 1;

   $token = $_GET['x'];
   try
   {   
      $stmt = $db_con->prepare("SELECT * FROM beekeeper WHERE token=:token");
      $stmt->bindParam(":token", $token);
      $stmt->execute();
      $count = $stmt->rowCount();

      if ($count === 1) { 
         $stmt = $db_con->prepare('UPDATE beekeeper SET token="", activated=1 WHERE token=:token');
         $stmt->bindParam(":token", $token);
         $stmt->execute();
         $error = 0;
      }
   } catch(PDOException $e) {
      echo $e->getMessage();
   }

   if ($error === 0) {
      echo "<strong>Success!</strong> Your registration is now complete.";
   } else {
      echo "<strong>Unfortunately we were not able to confirm your registration.</strong>";
   }

?>
         </div>
    
      </div>
   </div>

<?php
   include 'foot.php';
?>
