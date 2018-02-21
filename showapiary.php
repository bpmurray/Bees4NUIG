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

   if ($_POST) {
      if (isset($_POST['btn-cancel'])) {
         header('Location: showuser.php');
         exit;
      } else if (isset($_POST['btn-delete'])) {
         $_SESSION['delete'] = 'apiary';
         echo "delete";
      } else if (isset($_POST['btn-editapiary'])) {
         echo "edit";
      } else { // Must be submit = add
         echo "add";
      }

   } else { // GET

      $name  = $_SESSION['name'];
      $email = $_SESSION['email'];
      $id    = $_SESSION['id'];

      $apiaryid = $_GET['id'];

      // Set the current apiary in the session
      $_SESSION['apiaryid'] = $apiaryid;

      try {   
         // Get the apiary details
         $stmt = $db_con->prepare("SELECT * FROM apiary WHERE apiaryid=:id");
         $stmt->execute(array(":id"=>$apiaryid));
         $apiary = $stmt->fetch(PDO::FETCH_BOTH);

         // Get the hive details
         $stmt = $db_con->prepare("SELECT * FROM hive WHERE apiaryid=:id ORDER BY queenid");
         $stmt->execute(array(":id"=>$apiaryid));
         $count = $stmt->rowCount();
      } catch(PDOException $e) {
         echo $e->getMessage();
      }
   
   include 'head.php';
?>
   <div class="signin-form">
      <div class="container">
         <form class="form-signin" method="post" id="showapiary-form">
            <h2 class="form-signin-heading">
               Apiary: <?php echo $apiary['name']; ?>
               <button type="submit" class="btn btn-default btn-sm" name="btn-editapiary" id="btn-editapiary">
                  <span class="glyphicon glyphicon-edit"></span>
               </button> 
            </h2>
            <h3 class="form-signin-heading">
               <?php echo $apiary['colonies']; ?>
               hives at <?php echo $apiary['location']; ?>
            </h3>
            <hr />

            <div id="error">
               <!-- error will be shown here ! -->
            </div>

            <table class="table">
               <thead>
                  <tr class="row">
                     <th class="col-sm-4">Hive #</th>
                     <th class="col-sm-8">Last treatment</th>
                  </tr>
               </thead>
<?php
   try {   
      while ($count > 0) {
         $hive    = $stmt->fetch(PDO::FETCH_BOTH);
         $hiveid  = $hive['queenid'];
         $treated = $hive['lasttreated'];
         $location = $apiary['location'];
         echo '<tr class="row">';
         echo '<td><a href="showhive.php?id=' . $hiveid . '">';
         echo '<span class="glyphicon glyphicon-edit">&nbsp;' . $hiveid;
         echo '</span></button></a></td>';
         echo '<td>' . $treated . '</td></tr>';
         $count--;
      }
   } catch(PDOException $e) {
      echo $e->getMessage();
   }
?>
            </table>
            <hr />

            <div class="form-group">
               <button type="submit" class="btn btn-default btn-md" name="btn-submit" id="btn-submit">
                  <span class="glyphicon glyphicon-plus"></span> &nbsp;Add hive
               </button> 
               &nbsp;&nbsp;
               <button type="submit" class="btn btn-default btn-md" name="btn-delete" id="btn-delete">
                  <span class="glyphicon glyphicon-trash"></span> &nbsp;Remove apiary
               </button> 
               &nbsp;&nbsp;
               <a href="showuser.php" class="btn btn-default btn-md" name="btn-cancel" id="btn-cancel">
                  <span class="glyphicon glyphicon-ban-circle"></span> &nbsp;Cancel
               </a> 
            </div>  
         </form>
       </div>
   </div>

<?php
   include 'foot.php';
   } // Else GET
?>
