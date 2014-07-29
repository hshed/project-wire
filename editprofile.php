<?php  //editprofile.php
include_once 'header.php';

if(!isset($_SESSION['email_id']))
   die("You must be logged in to view this page.");
$email=$_SESSION['email_id'];
    $result=mysql_query("SELECT * FROM members WHERE email_id='$email'") or die(mysql_error());
    $row = mysql_fetch_array($result) or die(mysql_error());
	$username= $row['user'];
echo"<h3>Edit Your Profile</h3>";

if (isset($_POST['text']))
{
    $text=sanitizeString($_POST['text']);
    $text=preg_replace('/\s\s+/', '', $text);

    $query = "SELECT * FROM profiles WHERE user='$username'";
	if (mysql_num_rows(queryMysql($query)))
	{
	    queryMysql("UPDATE profiles SET text='$text' WHERE user='$username'");
	}

    else
    {	
        $query = ("INSERT INTO profiles VALUES('$username','$text')");
        queryMysql($query);
    }
}
else
{
	$query=("SELECT * FROM profiles WHERE user='$username'");
	$result=queryMysql($query);
	
	if (mysql_num_rows($result))
	{
	    $row= mysql_fetch_row($result) or die(mysql_error());
		$text= stripslashes($row[1]);
	}
    else $text = "";
}

$text = stripslashes(preg_replace('/\s\s+/', '', $text));

if (isset($_FILES['image']['name']))
{
    $saveto = "$username.jpg";
	move_uploaded_file($_FILES['image']['tmp_name'], $saveto);
	$typeok = TRUE;
	
	switch($_FILES['image']['type'])
	{
	    case "image/gif": $src = imagecreatefromgif($saveto); 
		break;
		
		case "image/jpeg":
		case "image/pjpeg": $src = imagecreatefromjpeg($saveto);
		break;
		
		case "image/png": $src = imagecreatefrompng($saveto);
		break;
		
		default: $typeok = FALSE;
		break;
	}

	if($typeok)
	{
	    list($w, $h) = getimagesize($saveto);
		$max = 200;
		$tw = $w;
		$th = $h;
		
		if ($w>$h && $max<$w)
		{
		    $th = $max/$w*$h;
			$tw = $max;
		}
		elseif ($h>$w && $max<$h)
		{
		    $th = $max/$w*$h;
			$tw = $max;
		}
		elseif ($max<$w)
		{
		    $tw=$th=$max;
		}

		$tmp = imagecreatetruecolor($tw,$th);
		imagecopyresampled($tmp, $src, 0, 0, 0, 0, $tw, $th, $w, $h);
		/*imageconvolution($tmp, array(  //Sharpen Images
		                       array(-1,-1,-1),
							   array(-1,16,-1),
							   array(-1,-1,-1)
							   ),8,0);*/
		imagejpeg($tmp, $saveto);
        imagedestroy($tmp);
        imagedestroy($src);
    }
}

showProfile($username);

echo <<<_END
<form method='POST' action='editprofile.php' enctype='multipart/form-data'>
Enter or edit your details and upload an image:<br/>
<textarea name='text' cols='40' rows='3'>$text</textarea><br/>
Image: <input type='file' name='image' size='14' maxlength='32' />
<input type='submit' value='Save Profile'/>
</pre></form>
_END;
?>