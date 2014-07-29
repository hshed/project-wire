<?php  // Setup.php
include_once 'functions.php';
echo '<h3>Setting up.</h3>';

createTable('members',
              'id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,user VARCHAR(50), pass VARCHAR(50),
               forename VARCHAR (50), surname VARCHAR(50),
			   email_id VARCHAR(50), user_id VARCHAR(25), INDEX(user(6)) ');

createTable('messages',
             'msg_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			   auth VARCHAR(16), recip VARCHAR(16), pm CHAR(1),
			   time INT UNSIGNED, message VARCHAR(4096),
			   INDEX(auth(6)), INDEX(recip(6))');
			   
createTable('cables','user VARCHAR(16), cable VARCHAR(16),
               INDEX(user(6)), INDEX(cable(6))');

createTable('profiles', 'user VARCHAR(16),text VARCHAR(4096), 
               INDEX(user(6))');
?>			   