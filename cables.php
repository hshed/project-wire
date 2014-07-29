<?php  //cables.php
include_once 'header.php';

if(!isset($_SESSION['email_id']))
{ die("You must be logged in to view this page."); }

$email=$_SESSION['email_id'];
    $result=mysql_query("SELECT * FROM members WHERE email_id='$email'") or die(mysql_error());
    $row = mysql_fetch_array($result) or die(mysql_error());
$username= $row['user'];

if(isset($_GET['view'])) $view = sanitizeString($_GET['view']);
else $view = $username;

if ($view==$username)
{
    $name1= "Your";
	$name2= "Your";
	$name3= "You are";
}
else
{
    $name1= "<a href='messages.php?view=$view'>$view</a>'s";
	$name2= "$view's";
	$name3= "$view is";
}

echo "<h3>$name1 Friends</h3>";
showProfile($view);
$followers = array(); $following = array();
$query = "SELECT *FROM cables WHERE user='$view'";
$result= queryMysql($query);
$num   = mysql_num_rows($result);

for ($j=0; $j<$num; ++$j)
{
    $row = mysql_fetch_row($result);
	$followers[$j] = $row[1];
}

$query = "SELECT * FROM cables WHERE cable='$view'";
$result= queryMysql($query);
$num   = mysql_num_rows($result);

for ($j=0; $j<$num; ++$j)
{
    $row= mysql_fetch_row($result);
	$following[$j] = $row[0];
}

$mutual    = array_intersect($followers, $following);
$followers = array_diff($followers, $mutual);
$following = array_diff($following, $mutual);
$friends   = FALSE;

if (sizeof($mutual))
{
    echo"<b>$name2 friends</b><ul>";
	foreach($mutual as $friend)
	    echo"<li><a href='messages.php?view=$friend'>$friend</a>";
	echo"</ul>";
	$friends = TRUE;
}

if (sizeof($followers))
{
    echo"<b>$name2 followers</b><ul>";
	foreach($followers as $friend)
	    echo"<li><a href='messages.php?view=$friend'>$friend</a>";
	echo"</ul>";
	$friends = TRUE;
}

if (sizeof($following))
{
    echo"<b>$name3 following</b><ul>";
	foreach($following as $friend)
	    echo"<li><a href='messages.php?view=$friend'>$friend</a>";
	echo"</ul>";
	$friends = TRUE;
}

if (!$friends) echo "<ul><li>None yet";
echo "<ul><a href='messages.php?view=$view'>View $name2 messages</a>";
?>
	