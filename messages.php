<?php  //messages.php
include_once 'header.php';

if (!isset($_SESSION['email_id']))
    die ("You need to login to view this page.");
$email = $_SESSION['email_id'];
    $result=mysql_query("SELECT * FROM members WHERE email_id='$email'") or die(mysql_error());
    $row = mysql_fetch_array($result) or die(mysql_error());
$username= $row['user'];
$user_id= $row['user_id'];
if(isset($_GET['view']))  $view = sanitizeString($_GET['view']);
else $view = $user_id;

if (isset($_POST['text']))
{    
    
    $text = sanitizeString($_POST['text']);
	
	if ($text != "")
	{   
	    $pm = substr(sanitizeString($_POST['pm']),0,1);
		$time = time();
		queryMysql("INSERT INTO messages VALUES(NULL,'$user_id','$view','$pm',$time,'$text')");
	}
}

if ($view !="")
{
    if ($view == $user_id)
	{
	    $name1 = "Your";
		$name2 = "Your";
	}
	else
	{
	    $name1 = "<a href='messages.php?view=$view'>$view</a>'s";
		$name2 = "$view's";
	}

	echo "<h3>$name1 Messages</h3>";
	showProfile($view);
	
	echo <<<_END
<form method='post' action='messages.php?view=$view'>
Type here to leave a message:<br/>
<textarea name='text' cols='40' rows='3'></textarea><br/>
Public<input type='radio' name='pm' value='0' checked='checked'/>
Private<input type='radio' name='pm' value='1'/>
<input type='submit' value='Post message'/></form>
_END;
	
    if (isset($_GET['erase']))
	{
	    $erase = sanitizeString($_GET['erase']);
		queryMysql("DELETE FROM messages WHERE id=$erase AND recip = '$user_id'");
	}

	$query = "SELECT * FROM messages WHERE recip='$view' ORDER BY time DESC";
	$result= queryMysql($query);
	$num   = mysql_num_rows($result);
	
	for ($j=0; $j<$num; ++$j)
	{
	    $row = mysql_fetch_row($result) or die(mysql_error());
		
		if ($row[3]==0 ||
		    $row[1]==$user_id ||
			$row[2]==$user_id)
		{
		    
            echo date('M jS \'y g:sa:',$row[4]);
			echo "<a href='messages.php?";
			echo "view=$row[1]'>$row[1]</a>";
			
			if ($row[3] == 0)
			{
			    echo " wrote: &quot;$row[5]&quot;";
			}
			else 
			{
			    echo " whispered:<i><font color='#006600'>&quot;$row[5]&quot;</font></i>";
			}
			if ($row[2] == $user_id)
			{
			    echo "[<a href='messages.php?view=$view";
				echo "&erase=$row[0]'>erase</a>]";
			}
			echo "<br/>";
		}
	}
	if (!$num) echo "</li>No messages yet</li><br/>";
}



echo "<br/><a href='messages.php?view=$view'>Refresh messages</a>";
echo "| <a href='cables.php?view=$username'>View $name2 friends</a>";
?>	