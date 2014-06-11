<?php 
require_once('Connections/ksnews3.php'); 
require('admin_manage/clientGetObj.php');
$str1 = $code->getBrowse();//瀏覽器： 
$str2 = $code->getIP();//IP地址： 
$str3 = $code->getOS();//操作系統：
?>
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

$colname_RecProduct = "-1";
if (isset($_GET['id'])) {
  $colname_RecProduct = $_GET['id'];
}
mysql_select_db($database_ksnews3, $ksnews3);
$query_RecProduct = sprintf("SELECT * FROM product WHERE n_id = %s", GetSQLValueString($colname_RecProduct, "int"));
$RecProduct = mysql_query($query_RecProduct, $ksnews3) or die(mysql_error());
$row_RecProduct = mysql_fetch_assoc($RecProduct);
$totalRows_RecProduct = mysql_num_rows($RecProduct);
if ((isset($_GET['hits'])) && ($_GET['hits'] != "")) 
{
	mysql_select_db($database_ksnews3,$ksnews3);
	$query_insert = sprintf("INSERT INTO viewcount_class (`view_time`,`view_ip`,`view_class`,`view_browser`) VALUES (%s,%s,%s,%s)",GetSQLValueString(date("Y-m-d H:i:s"),"date"),GetSQLValueString($str2,"text"),GetSQLValueString($row_RecProduct['level2_id'],"text"),GetSQLValueString($str1,"text"));
	mysql_query($query_insert,$ksnews3);

	mysql_select_db($database_ksnews3,$ksnews3);
	$query_insert = sprintf("INSERT INTO viewcount (`view_time`,`view_ip`,`view_os`,`view_browser`) VALUES (%s,%s,%s,%s)",GetSQLValueString(date("Y-m-d H:i:s"),"date"),GetSQLValueString($str2,"text"),GetSQLValueString($str3,"text"),GetSQLValueString($str1,"text"));
	mysql_query($query_insert,$ksnews3);
	
	mysql_select_db($database_ksnews3,$ksnews3);
	$query_RecHits = sprintf("SELECT * FROM hits_count WHERE t_level = %s AND t_date = %s", GetSQLValueString($row_RecProduct['level2_id'], "int"), GetSQLValueString(date("Y-m")."-01", "date"));
	$RecHits = mysql_query($query_RecHits, $ksnews3) or die(mysql_error());
	$row_RecHits = mysql_fetch_assoc($RecHits);
	$totalRows_RecHits = mysql_num_rows($RecHits);
	
	if($totalRows_RecHits == 0)
	{
		mysql_select_db($database_ksnews3,$ksnews3);
		$query_RecInsert = sprintf("INSERT INTO hits_count (t_level,t_date,t_times) VALUES (%s,%s,1)", GetSQLValueString($row_RecProduct['level2_id'], "int"), GetSQLValueString(date("Y-m")."-01", "date"));
		mysql_query($query_RecInsert, $ksnews3) or die(mysql_error());
	}
	else
	{
		mysql_select_db($database_ksnews3,$ksnews3);
		$query_RecUpdate = sprintf("UPDATE hits_count SET t_times = t_times + 1 WHERE t_level = %s AND t_date = %s", GetSQLValueString($row_RecProduct['level2_id'], "int"), GetSQLValueString(date("Y-m")."-01", "date"));
		mysql_query($query_RecUpdate, $ksnews3) or die(mysql_error());
	}
}
?>

<table width="690" border="0" cellpadding="0" cellspacing="0"  style="word-break:break-all">
  <tr>
    <td><h1><?php echo $row_RecProduct['n_name']; ?></h1></td>
  </tr>
  <tr>
    <td><?php echo $row_RecProduct['n_detail']; ?></td>
  </tr>
</table>
<?php
mysql_free_result($RecProduct);
?>
