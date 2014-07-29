<?php //logout.php
include_once 'header.php';
echo"<h3>Log out</h3>";

if (isset($_SESSION['email_id']))
{
   destroySession();
   header( "Location: http://localhost/project wire/index.php" ) ;
}
else echo "You are not logged in";
?>   