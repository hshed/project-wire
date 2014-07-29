<?php    // functions.php
$dbhost='localhost';     // Name of the host
$dbname='project wire';  // Name of the database
$dbuser='project wire';      // Name of the database user
$dbpass='123456';      // Password of the database
$appname="Collegewires"; // CollegeWires

mysql_connect($dbhost, $dbuser, $dbpass) or die(mysql_error());
mysql_select_db($dbname) or die(mysql_error());

function createTable($name, $query)
{
    if (tableExists($name))
	 {
	    echo "Table Name '$name' already exists!";
	 }
	else
	 {
	    queryMysql("CREATE TABLE $name($query)");
		echo "Table '$name' created<br/>";
	 }
}

function tableExists($name)
{
    $result = queryMysql("SHOW TABLES LIKE '$name'");
	return mysql_num_rows($result);
}

function queryMysql($query)
{
    $result = mysql_query($query) or die(mysql_error());
	return $result;
}

function destroySession()
{
    $_SESSION=array();
	
	if (session_id() !="" || isset($_COOKIE[session_name()]))
	    setcookie(session_name(), '', time()-2592000, '/');                                        
		
	session_destroy();
}

function sanitizeString($var)
{
    $var = strip_tags($var);
    $var = htmlentities($var);
    $var = stripslashes($var);
    return mysql_real_escape_string($var);
}

function showProfile($username)
{
    if (file_exists("$username.jpg"))
        echo "<img src='$username.jpg' border='1' align='left' />";
    
    $result = queryMysql("SELECT * FROM profiles WHERE user='$username'");
    
    if (mysql_num_rows($result))
    {
        $row = mysql_fetch_row($result);
        echo stripslashes($row[1]). "<br clear=left /><br/>";
    }
}

function validate_user($field) 
{
    if ($field == "") return "No Username was entered<br/>";
	return "";
}

function validate_pass($field)
{
    if ($field == "") return "No Password was entered<br/>";
	else if (strlen($field) < 6) return "Password must be at least 6 characters<br/>";
    return "";
}

function validate_forename($field)
{
    if ($field == "") return "No First Name was entered<br/>";
	return "";
}

function validate_email_id($field)
{
    
    if ($field == "") return "No Email-id was entered<br/>";
        else if (!((strpos($field, ".") >0) &&
                   (strpos($field, "@") >0))) return "The email address is invalid<br/>";			
    return "";
}
?>
