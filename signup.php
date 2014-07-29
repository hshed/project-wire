<?php //signup.php
include_once 'header.php';
$salt1= "av#7";
$salt2= "@cx8";

echo "<h3>Sign Up Form</h3>";

$error = $username = $pass = $forename = $surname = $email = $id="";
$user_id= mt_rand(100000, 999999);
if (isset($_SESSION['user'])) destroySession();

if (isset($_POST['user']))
    $username = sanitizeString($_POST['user']);
if (isset($_POST['pass']))
    $pass = sanitizeString($_POST['pass']);
if (isset($_POST['forename']))
    $forename = sanitizeString($_POST['forename']);
if (isset($_POST['surname']))
    $surname = sanitizeString($_POST['surname']);
if (isset($_POST['email_id']))
    $email = sanitizeString($_POST['email_id']);

$fail  = validate_forename($forename);
$fail .= validate_user($username);
$fail .= validate_pass($pass);
$fail .= validate_email_id($email);

echo "<html><head><title>CollegeWires | Signup</title>";

if ($fail == "" ) {
              echo "</head><body>Data submitted:<br/>Name:$forename $surname<br/>Username: $username <br/>Email-id: $email.<br/></body></html>";
			  
if (isset($_POST['user']))
{   $query = "SELECT * FROM members WHERE user='$username'";

	if (mysql_num_rows(queryMysql($query)))
        {
            $error = "<font color=red size=3><b>The Username entered has been taken already.<b></font><br/>";
			die ("$error");
        }		  
}
if (isset($_POST['email_id']))			  
{      
        $query = "SELECT * FROM members WHERE email_id='$email'";
        $token= md5("$salt1$pass$salt2");
        if (mysql_num_rows(queryMysql($query)))
        {
            $error = "<font color=red size=3><b>The email-id entered has been registered already.<b></font><br/>";
			die("$error");
        }
        else
        {
            $query = "INSERT INTO members VALUES('$id','$username','$token','$forename','$surname','$email','$user_id')";
            queryMysql($query);
			echo"Accounte Created. Please <a href='/project wire/login.php'>Log in</a> to continue. ";
			
        }
}
  exit;
}

echo <<<_END

<script type="text/javascript">
function validate(form)
{
    fail  = validateForename(form.forename.value)
    fail += validateUsername(form.username.value)
    fail += validatePassword(form.password.value)	
    fail += validateEmail(form.email.value)
	
	if (fail == "") return true
	else { alert(fail); return false }
}
</script>
<script type="text/javascript" src="/formvalidate.js"></script>
<body>
<table class="signup" border="0" cellpadding="2"
    cellspacing ="5" bgcolor ="#eeeeee">
<th colspan ="2" align="center">Signup Form</th>

<tr><td colspan="2"><p><font color=red size=2><i>$fail</i></font></p></td></tr>
<form method='post' action='signup.php'
      onSubmit="return validate(this)">
	   <tr><td>First Name</td><td><input type="text" maxlenth="50"
	   name="forename" value="$forename" /></td></tr>
	   
	   <tr><td>Last Name</td><td><input type="text" maxlength="50"
       name="surname" value="$surname" /></td></tr>

	   <tr><td>Username</td><td><input type="text" maxlength="50"
       name="user" value="$username" /></td></tr>
	   
	   <tr><td>Password</td><td><input type="password" maxlength="50"
       name="pass" value="$pass" /></td></tr>
	   
	   <tr><td>Email-id</td><td><input type="text" maxlength="50"
       name="email_id" value="$email" /></td></tr>
	   
	   <tr><td colspan="2" align="center"><input type="submit"
        value="Signup" /></tr>
		</form></table></body></html>
_END;
?>	