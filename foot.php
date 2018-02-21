
   <br />
<?php
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
