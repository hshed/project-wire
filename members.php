<?php //members.php
include_once 'header.php';

if (!isset($_SESSION['email_id']))
    die("<br/><br/> You must be logged in to view this page.");
$email=$_SESSION['email_id'];
$result=mysql_query("SELECT * FROM members WHERE email_id='$email'") or die(mysql_error());
$row   =mysql_fetch_array($result) or die(mysql_error());
$username = $row['user'];

if (isset($_GET['veiw']))
{
    $view = sanitizeString($_GET['view']);
	
	if ($view == $user) $name = "Your";
	else $name = "$view's";
	
	echo "<h3>$name Page</h3>";
	showProfile($view);
	echo "<a href='meassages.php?view=$view'>$name Messages</a><br/>";
	die("<a href='cables.php?view=$view'>$name Friends</a><br/>");
}

if (isset($_GET['add']))
{
    $add = sanitizeString($_GET['add']);
	$query = "SELECT * FROM cables WHERE user = '$add' AND cable='$username'";
	
	if (!mysql_num_rows(queryMysql($query)))
	{
	    $query = "INSERT INTO cables VALUES ('$add', '$username')";
		queryMysql($query);
	}
}
elseif (isset($_GET['remove']))
{
    $remove = sanitizeString($_GET['remove']);
	$query = "DELETE FROM cables WHERE user='$remove' AND cable='$username'";
	queryMysql($query);
}
$result = queryMysql("SELECT user FROM members ORDER BY user");
$num = mysql_num_rows($result);
echo "<h3>Other Members</h3><ul>";

for ($j=0; $j<$num; ++$j)	
{
    $row = mysql_fetch_row($result);
	if ($row[0]==$username) continue;
	
	echo "<li><a href='members.php?view=$row[0]'>$row[0]</a>";
	$query = "SELECT * FROM cables WHERE user='$row[0]' AND cable='$username'";
	$t1 = mysql_num_rows(queryMysql($query));
	
	$query = "SELECT * FROM cables WHERE user='$username' AND cable='$row[0]'";
	$t2 = mysql_num_rows(queryMysql($query));
	$follow = "follow";
	
	if (($t1 + $t2) > 1)
	{
	    echo " &harr; is a mutual friend";
	}
	elseif ($t1)
	{
	    echo " &larr; you are following";
	}	
	elseif ($t2)
	{
	    echo " &rarr; is following you";
	}
	
	if (!$t1)
	{
	    echo "[<a href='members.php?add=".$row[0]."'>$follow</a>]";
	}
    else 
    {
	    echo "[<a href='members.php?remove=".$row[0]."'>drop</a>]";
	}
}
?>	