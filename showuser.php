<?php

   require_once 'dbconfig.php';

   if (session_status() != PHP_SESSION_ACTIVE) {
      session_start();
   }

   $name  = $_SESSION['name'];
   $email = $_SESSION['email'];
   $id    = $_SESSION['id'];
   $admin = intval($_SESSION['admin']);

   if ($_POST) {
      if (isset($_POST['btn-logout'])) {
         session_destroy();
         header('Location: index.php');
         exit;
      } else if (isset($_POST['btn-admin']) && $admin != 0) {
         header('Location: admin.php');
         exit;
      }
   } else if (isset($_GET['btn-logout'])) {
         session_destroy();
         header('Location: index.php');
         exit;
   }

   try {   
      $stmt = $db_con->prepare("SELECT * FROM apiary WHERE beekeeperid=:beekeeperid");
      $stmt->execute(array(":beekeeperid"=>$id));
      $count = $stmt->rowCount();
   } catch(PDOException $e) {
      echo $e->getMessage();
   }

   // If no apiaries - jump straight to adding one
   if ($count===0 && $admin==0) {
      header('Location: addapiary.php');
      exit;
   }
   include 'head.php';
?>
   <div class="signin-form">
      <div class="container">
         <form class="form-signin" method="get" id="showuser-form">
            <h2 class="form-signin-heading">
               Apiaries for <?php echo $name; ?>
            </h2><hr />

            <div id="error">
               <!-- error will be shown here ! -->
            </div>

            <table class="table">
               <thead>
                  <tr class="row">
                     <th class="col-sm-6">Name</th>
                     <th class="col-sm-9">Location</th>
                     <th class="col-sm-1">Colonies</th>
                  </tr>
               </thead>
<?php
   try {   
      while ($count > 0) {
         $apiary = $stmt->fetch(PDO::FETCH_BOTH);
         $apiaryid = $apiary['apiaryid'];
         $name     = $apiary['name'];
         $location = $apiary['location'];
         $colonies = $apiary['colonies'];
         echo '<tr class="row">';
         echo '<td><a href="showapiary.php?id=' . $apiaryid . '">'
            . '<span class="glyphicon glyphicon-edit">&nbsp;'
            . $name . '</span></button></a></td>';
         echo '<td>' . $location . '</td>';
         echo '<td>' . $colonies . '</td></tr>';
         $count--;
      }
   } catch(PDOException $e) {
      echo $e->getMessage();
   }
?>
            </table>
            <hr />

            <div class="form-group">
               <button type="submit" class="btn btn-default" name="btn-submit" id="btn-submit">
                  <span class="glyphicon glyphicon-plus"></span> &nbsp;Add apiary
               </button> 
               <?php
                  if ($admin != 0) {
                     echo('&nbsp;&nbsp;<button type="submit" class="btn btn-default" name="btn-admin" id="btn-admin">');
                     echo('<span class="glyphicon glyphicon-education"></span> &nbsp;Admin');
                     echo('</button>');
                  }
               ?>
               &nbsp;&nbsp;
               <button type="submit" class="btn btn-default" name="btn-logout" id="btn-logout">
                  <span class="glyphicon glyphicon-log-out"></span> &nbsp;Logout
               </button> 
               &nbsp;&nbsp;
               <a href="newpassword.php" class="btn btn-default" name="btn-chpassword" id="btn-chpassword">
                  <span class="glyphicon glyphicon-log-out"></span> &nbsp;Update Password
               </a> 
            </div>  
         </form>
       </div>
   </div>

<?php
   include 'foot.php';
?>
