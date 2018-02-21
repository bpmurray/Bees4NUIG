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

   $db_host = "YourHostName";
   $db_name = "varroarecords";
   $db_user = "YourUserName";
   $db_pass = "YourPassword";
   
   try {
      
      $db_con = new PDO("mysql:host={$db_host};dbname={$db_name}",$db_user,$db_pass);
      $db_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

   } catch(PDOException $e) {
      echo $e->getMessage();
   }

?>
