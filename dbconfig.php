<?php

   //$db_host = "mysql2880int.cp.blacknight.com";
   //$db_name = "db1454844_registration";
   //$db_user = "u1454844_root";
   //$db_pass = "Meabh3Sian";
   $db_host = "localhost";
   $db_name = "varroarecords";
   $db_user = "root";
   $db_pass = "me32316";
   
   try {
      
      $db_con = new PDO("mysql:host={$db_host};dbname={$db_name}",$db_user,$db_pass);
      $db_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

   } catch(PDOException $e) {
      echo $e->getMessage();
   }

?>
