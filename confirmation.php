<?php
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
