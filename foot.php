
   <br />
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
$filename = basename($_SERVER["SCRIPT_FILENAME"], '.php');
if ($filename != 'index' && $filename != 'terms') {
?>
   <div class="container" style="text-align: center;">
      <a href="index.php" class="ui-button ui-widget ui-corner-all">
         <span class="glyphicon glyphicon-home"></span> &nbsp;Home
      </a>
   </div>
<?php
}
?>

   <!-- Latest compiled and minified JavaScript -->
<!--   <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
           integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
           crossorigin="anonymous"></script> -->

</body>
</html>
