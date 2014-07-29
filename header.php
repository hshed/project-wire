<!DOCTYPE html 
      PUBLIC "-//W3C//DTD HTML 4.01//EN"
      "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en-US">
<head profile="http://www.w3.org/2005/10/profile">
<link rel="icon" 
      type="image/png" 
      href="favicon.ico"></head></html>

<?php  //header.php
include 'functions.php';
session_start();

if (isset($_SESSION['email_id']))
{
    $email=$_SESSION['email_id'];
	$loggedin = TRUE ;
	
}
else $loggedin = FALSE ;

 ?>

<html><style>
@import url('style.css');</style>
<?php
echo "<html><head><title>$appname";
echo "</title><link rel='shortcut icon' href='favicon.ico' type='image/x-icon'/></head>";
echo "<body><div id='logo'><a class='two' href='index.php'><img width='' height='' src='logo.jpg' style='border:0;margin-top:4px;margin-left:140px;'/></a></div></body>";
include 'menu.php'; ?>

</body></html>
