<?php

   require_once 'dbconfig.php';

   if (session_status() != PHP_SESSION_ACTIVE) {
      session_start();
   }
   $name   = $_SESSION['name'];
   $email  = $_SESSION['email'];
   $id     = $_SESSION['id'];
   $delete = $_SESSION['delete'];

   if ($_POST) {
      if ($delete == "apiary") {
         $apiaryid = $_SESSION['apiaryid'];

         try {   
            // Delete this apiary
            $stmt = $db_con->prepare("DELETE FROM apiary WHERE apiaryid=:id");
            $stmt->execute(array(":id"=>$apiaryid));
            $apiary = $stmt->fetch(PDO::FETCH_BOTH);
         } catch(PDOException $e) {
            echo $e->getMessage();
         }
         $lastPage = "showuser.php";
      } else {
         try {   
            // Delete this user
            $stmt = $db_con->prepare("DELETE FROM beekeeper WHERE beekeeperid=:id");
            $stmt->execute(array(":id"=>$id));
         } catch(PDOException $e) {
            echo $e->getMessage();
         }
         $lastPage = "index.php";
      }
      echo "goto:" . $lastPage;

   } else { // GET

      $dname = ""; // Name of item to be deleted

      if ($delete == "apiary") {
         $apiaryid = $_SESSION['apiaryid'];

         try {   
            // Get the apiary details
            $stmt = $db_con->prepare("SELECT * FROM apiary WHERE apiaryid=:id");
            $stmt->execute(array(":id"=>$apiaryid));
            $apiary = $stmt->fetch(PDO::FETCH_BOTH);
            $count = $stmt->rowCount();

            if ($stmt->rowCount == 1) {
               $dname = $apiary['name'];
            }

         } catch(PDOException $e) {
            echo $e->getMessage();
         }
         $lastPage = "showapiary.php";
      } else {
         $lastPage = "showuser.php";
         $dname = $name;
      }

      include 'head.php';

?>
   <div class="signin-form">
      <div class="container">
         <form class="form-signin" method="get" id="delete-form">
            <h2 class="form-signin-heading">
<?php
      echo "Deleting " . $delete . ": " . $dname;
?>
            </h2>

            <div id="error">
               <!-- error will be shown here ! -->
            </div>

            <hr />

            <div class="form-group">
               <button type="submit" class="btn btn-default btn-md" name="btn-submit" id="btn-submit">
                  <span class="glyphicon glyphicon-plus"></span> &nbsp;Delete
               </button> 
               &nbsp;&nbsp;
               <a href="<?php echo $lastPage; ?>" class="btn btn-default btn-md" name="btn-cancel" id="btn-cancel">
                  <span class="glyphicon glyphicon-ban-circle"></span> &nbsp;Cancel
               </a> 
            </div>  
         </form>
       </div>
   </div>

<?php
   include 'foot.php';
   } // else GET
?>
