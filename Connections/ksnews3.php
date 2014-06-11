<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_ksnews3 = "localhost";
$database_ksnews3 = "kshouse";
$username_ksnews3 = "root";
$password_ksnews3 = "root";
$ksnews3 = mysql_pconnect($hostname_ksnews3, $username_ksnews3, $password_ksnews3) or trigger_error(mysql_error(),E_USER_ERROR); 
mysql_query("set character set utf8",$ksnews3);
mysql_query("SET CHARACTER_SET_database= utf8",$ksnews3);
mysql_query("SET CHARACTER_SET_CLIENT= utf8",$ksnews3);
mysql_query("SET CHARACTER_SET_RESULTS= utf8",$ksnews3);
?>