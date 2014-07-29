<?php  //menu.php
if ($loggedin)
{   $result=mysql_query("SELECT * FROM members WHERE email_id='$email'") or die(mysql_error());
    $row = mysql_fetch_array($result) or die(mysql_error());
	$username= $row['user'];
	$user_id= $row['user_id'];
    echo" <body><div id='menu'><b>$username</b>:
	      <a class='one' href='index.php'>Home</a> 
	      <a class='one' href='profile.php?view=$username'>Profile</a> 
		  <a class='one' href='cables.php'>Cables</a> 
		  <a class='one' href='messages.php'>Messages</a> 
		  <a class='one' href='logout.php'>Logout</a></div></body>";
} 
if (!$loggedin)
{   
    echo" <body><div id='menu'><a class='one' href='index.php'>Home</a>
          <a class='one' href='signup.php'>Sign Up</a> 
          <a class='one' href='login.php'>Log In</a></div></body>";
}
?>