<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_connSQL = "localhost";
$database_connSQL = "ksbnb";
$username_connSQL = "root";
$password_connSQL = "root";
$connSQL = mysql_pconnect($hostname_connSQL, $username_connSQL, $password_connSQL) or trigger_error(mysql_error(),E_USER_ERROR); 
mysql_query('SET NAMES UTF8');
?>