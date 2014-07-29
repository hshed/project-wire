<?php //login.php
//include_once 'header.php';
$salt1= "av#7";
$salt2= "@cx8";
echo "<h3>Member Log In</h3>";
$error=$email=$pass="";

function sanitizeString($var)
{
    $var = strip_tags($var);
    $var = htmlentities($var);
    $var = stripslashes($var);
    return mysql_real_escape_string($var);
}

if (isset($_POST['email_id']))
{
    $email = sanitizeString($_POST['email_id']);
	$pass  = sanitizeString($_POST['pass']);
	$token = md5("$salt1$pass$salt2");
	if ($email == "" || $pass == "")
	{
	    $error = "Not all fields were entered<br/>";
		
	}
    else
    {
        $query = "SELECT email_id,pass FROM members WHERE email_id='$email' AND pass='$token'";
        
        if (mysql_num_rows(queryMysql($query)) == 0)
        {		
		$error = "Email-id or Password Incorrect<br/>";
		
		}
		else
		{
		    $_SESSION['email_id']=$email;
			$_SESSION['pass']=$pass;
			header( "Location: http://collegewires.com/data/index.php" ) ;
		}
	}
}

echo <<<_END

<body>
<table class="login" border="0" cellpadding="2"
    cellspacing ="5" bgcolor ="#eeeeee">
<th colspan ="2" align="center">Login</th>


<form method = 'post' action = 'login.php'>$error
<tr><td>Email-id</td><td><input type="text" maxlength="50"
       name="email_id" value="$email" /></td></tr><br/>
<tr><td>Password</td><td><input type="password" maxlength="50"
       name="pass" value="$pass" /></td></tr><br/>
 &nbsp; &nbsp; 
 <tr><td colspan="2" align="center"><input type="submit"
        value="Login" /></tr> 
		</form></table></body>

_END;
?>