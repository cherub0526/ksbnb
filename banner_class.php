<?php require_once('Connections/ksnews3.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "admin,member,reporter,editor,adv,paywall";
$MM_donotCheckaccess = "false";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "viewthread.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
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

mysql_select_db($database_ksnews3, $ksnews3);
$query_pay = "SELECT * FROM pay_type";
$pay = mysql_query($query_pay, $ksnews3) or die(mysql_error());
$row_pay = mysql_fetch_assoc($pay);
$totalRows_pay = mysql_num_rows($pay);

$start_day=$_POST["year"]."-".$_POST["month"]."-".$_POST["day"];

session_start(); //啟動session功能
header("Cache-control:private");//解決session 引起的回上一頁表單被清
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>更生房仲網 刊登廣告</title>
<meta http-equiv="Content-Language" content="zh-tw" />
<link href="web.css" rel="stylesheet" type="text/css" />
<script language=javascript src="address.js"></script><!--引入郵遞區號.js檔案-->
<script type="text/javascript" src="fckeditor/fckeditor.js"></script>
	
	<style type="text/css">
	a{text-decoration:none;}

	#write {
	margin-left: 130px;
	height: auto;
	float: left;
	margin-top: 5px;
}
#spry_L1 {
	background-color: #06c;
	float: left;
	height: auto;
	width: 990px;
	margin-bottom: 5px;
}</style>
</head>

<body><div id="main"><?php include("header.php"); ?><div id="spry_L1">
	<?php require("spry_L1.php"); ?>
</div>
<div id="admin_main3">
       <? include("right_zone.php");?>
  </div>
  <div id="admin_main2">
  <form method="POST" enctype="multipart/form-data" name="form1" id="form1">
<table width="750" border="0.5" cellpadding="2" cellspacing="0">
        <tr>
          <td height="30" align="center" class="board_add">廣告種類：</td>
          <td align="left" class="board_add"><input type="button" value="報紙" onclick="self.location.href='banner_post_news.php'"/>
          <input type="button" value="網路" onclick="self.location.href='banner_post_web.php'"/>
<span class="font_red"> ( 請先選擇刊登廣告的種類 ) </span></td>
        </tr>
        <tr>
          <td width="76" height="30" align="center" class="board_add">查詢：</td>
          <td width="666" align="left" class="board_add"><input type="button" value="網路刊登查詢" onclick="self.location.href='banner_post.php'"/>
          <!--<input type="button" value="網路廣告點擊數總計" onclick="self.location.href='banner_Count.php'"/>-->
</td>
        </tr>
        <tr>
          <td height="40" colspan="2" align="center">&nbsp;</td>
        </tr>
      </table>
  </form>
  </div><?php include("footer.php"); ?>
</div>

</body>
</html>
<?php
mysql_free_result($pay);
?>
