<?php require_once('Connections/ksnews3.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

mysql_select_db($database_ksnews3, $ksnews3);
$query_main = "SELECT * FROM main WHERE pory = 1";
$main = mysql_query($query_main, $ksnews3) or die(mysql_error());
$row_main = mysql_fetch_assoc($main);
$totalRows_main = mysql_num_rows($main);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>關於更生</title>
<link rel="shortcut icon" href="images/ks_logo.ico"> 
<link href="web.css" rel="stylesheet" type="text/css" />
<style type="text/css">
h2,h3,h4,h5,h6,p,ul,ol,li,dl,dt,dd,table,th,td,form,fieldset,object {
	margin: 0;
	padding: 0;
}

#main {
	height: auto;
	width: 990px;
	margin-right: auto;
	margin-left: auto;
}
#youtube {
	float: left;
	height: 400px;
	width: 990px;

}
#main_title {
	font-size: 24px;
	float: left;
	height: 24px;
	width: 990px;
	margin-top: 5px;
}
#container {
	float: left;
	height: auto;
	width: 990px;

}
#main_img {
	float: left;
	height: 390px;
	width: 480px;
	margin-right: 15px;
}
</style>
</head>

<body>
<div id="main"><?php require("header.php"); ?>
  <div id="main_title">
    <h3><?php echo $row_main['main_title']; ?></h3>
  </div>
  <div id="container">
  <div id="youtube"><div id="main_img"><?php echo $row_main['main_movie']; ?></div>
    <div id="main_img"><img src="timthumb.php?src=images/main/<?php echo $row_main['main_pic']; ?>&w=480&h=390&zc=0" alt="" name="main_pic" id="main_pic" /></div>
  </div>
  <?php echo ($row_main['main_content']); ?>
  </div>
  <?php require("admin_ksnews/footer.php"); ?>
</div>

</body>
</html>
<?php
mysql_free_result($main);
?>
