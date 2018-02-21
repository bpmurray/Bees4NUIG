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
   if (session_status() === PHP_SESSION_ACTIVE) {
	   header("location: showuser.php");
   } else {

      session_start();
      session_unset();
      session_destroy();

      include 'head.php';
?>
   <div class="container" style="text-align: center;">
      <a href="login.php" class="ui-button ui-widget ui-corner-all" title="Click to go to the login page" >
         <span class="glyphicon glyphicon-log-in"></span> &nbsp;Login
      </a>
      <a href="register.php" class="ui-button ui-widget ui-corner-all" title="Click to go to the registration page">
         <span class="glyphicon glyphicon-user"></span> &nbsp;Register
      </a>
   </div>

<?php
   include 'foot.php';
   } // else
?>
