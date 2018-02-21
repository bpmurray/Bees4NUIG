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

   if ($_POST) {
      if (session_status() != PHP_SESSION_ACTIVE) {
         session_start();
      }
      if (isset($_POST['btn-cancel'])) {
         header('Location: showuser.php');
         exit;
      }
      
      $name  = $_SESSION['name'];
      $email = $_SESSION['email'];
      $id    = $_SESSION['id'];

      $aname  = $_POST['aname'];
      $where  = $_POST['where'];
      $ccount = $_POST['ccount'];

      try
      {   
         $stmt = $db_con->prepare("SELECT * FROM apiary WHERE beekeeperid=:id and name=:aname");
         $stmt->execute(array(":id"=>$id, ":aname"=>$aname));
         $count = $stmt->rowCount();

         if ($count > 0) { 
            echo "alreadyexists";
         } else {
            $stmt = $db_con->prepare("INSERT INTO apiary(beekeeperid,name,location,colonies) VALUES(:id, :aname, :location, :colonies)");
            $stmt->bindParam(":id", $id);
            $stmt->bindParam(":aname", $aname);
            $stmt->bindParam(":location", $where);
            $stmt->bindParam(":colonies", $ccount);
            if ($stmt->execute()) {
               echo "ok";
            } else {
               echo "Query could not execute !";
            }
         }
      } catch(PDOException $e) {
         echo $e->getMessage();
      }
   } else {

   include 'head.php';
?>

   <div class="signin-form">
      <div class="container">
         <form class="form-signin" method="post" id="addapiary-form">
            <h2 class="form-signin-heading">Add new apiary</h2><hr />

            <div id="error">
               <!-- error will be shown here ! -->
            </div>

            <div class="form-group">
               <input type="text" class="form-control" placeholder="Apiary name" 
                      title="Please provide a unique name for this apiary" name="aname" id="aname" />
               <span id="check-e"></span>
            </div>

            <div class="form-group">
               <input type="text" class="form-control" placeholder="Location (exact location not necessary)" 
                      title="Please indicate the approximate location of the apiary" name="where" id="where" />
            </div>

            <div class="form-group">
               <input type="text" class="form-control" placeholder="Total colonies in apiary (excluding nucs)" 
                      title="How many hives are at this location? Do not count nucs." name="ccount" id="ccount" />
            </div>

            <hr />

            <div class="form-group">
               <button type="submit" class="btn btn-default" name="btn-submit" id="btn-submit" title="Click to add the apiary">
                  <span class="glyphicon glyphicon-ok-circle"></span> &nbsp;Add
               </button> 

               <a href="showuser.php" class="btn btn-default" name="btn-cancel" id="btn-cancel" title="Click to return to your list of apiaries">
                  <span class="glyphicon glyphicon-ban-circle"></span> &nbsp;Cancel
               </a> 
            </div>  
         </form>
       </div>
   </div>

<?php
   include 'foot.php';
   } // else
?>
