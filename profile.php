<?php //profile.php
include_once 'header.php';
if($loggedin)
{ showProfile($username);
  echo"<p><a href='editprofile.php'>Edit</a> your profile.</p>";
}
else
{ echo"<p>You must be logged in to view this page. <a href='login.php'>Click here to login</a></p>";
} 
 ?>