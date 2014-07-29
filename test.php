<?php
if(!file_exists('counter.txt')){
  file_put_contents('counter.txt', '0');
}
if($_GET['click'] == 'yes'){
  file_put_contents('counter.txt', ((int) file_get_contents('counter.txt')) + 1);
  header('Location: ' . $_SERVER['SCRIPT_NAME']);
  die;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>counter example</title>
</head>
<body>
  <h1><?php echo file_get_contents('counter.txt'); ?></h1>
  <a href="?click=yes">clickMe</a>
</body>
</html>