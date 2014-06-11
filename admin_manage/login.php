<?php 
require_once('../Connections/ksnews3.php'); 
require('clientGetObj.php');
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
?>
<?php

//啟動 Session
if (!isset($_SESSION)) {
  session_start();
}

if(isset($_SESSION['MM_Username']))
{
	header("Location:admin_ksbnb.php");
}
//若表單送出時即先檢查驗證碼
if(isset($_POST['b_captcha'])){
	if(($_SESSION['security_code'] != $_POST['b_captcha'])||(empty($_SESSION['security_code']))){
		header("Location: login.php?errMsg=1?auth=false");
		break;
	}
}
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['b_username'])) {
  $loginUsername=$_POST['b_username'];
  $password=$_POST['b_password'];
  $MM_fldUserAuthorization = "level_group";
  $MM_redirectLoginSuccess = "admin_ksbnb.php";
  $MM_redirectLoginFailed = "login.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_ksnews3, $ksnews3);
  	
  $LoginRS__query=sprintf("SELECT `user`, pass, level_group FROM users WHERE `user`=%s AND pass=%s",
  GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $ksnews3) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
    mysql_select_db($database_ksnews3,$ksnews3);
	$query_insert = sprintf("INSERT INTO user_count (`in_time`,`user_id`,`user_ip`) VALUES (%s,%s,%s)",GetSQLValueString(date("Y-m-d H:i:s"),"date"),GetSQLValueString($loginUsername,"text"),GetSQLValueString($str2,"text"));
	mysql_query($query_insert,$ksnews3);
	$_SESSION['Logout_id'] = mysql_insert_id();
    $loginStrGroup  = mysql_result($LoginRS,0,'level_group');
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>更生民宿網-登入</title>
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" type="text/javascript">
//更換驗證碼圖片
function RefreshImage(valImageId) {
	var objImage = document.images[valImageId];
	if (objImage == undefined) {
		return;
	}
	var now = new Date();
	objImage.src = objImage.src.split('?')[0] + '?width=100&height=40&characters=5&s=' + new Date().getTime();
}
</script>
<style type="text/css">
#login form table {
	margin-right: auto;
	margin-left: auto;
}
</style>
</head>

<body>
<div id="body">
<?php
include("../cx_header.php");
?>
  <div id="cx_content" style="background-color:#f3f3f3;height:500px" class="cx_admin_table">
    <div id="login">
    <?php if(isset($_GET['errMsg'])==1) {?>
    <p style="color:#F00" align="center">帳號密碼輸入錯誤</p>
    <?php } ?>
    <?php if(isset($_GET['auth'])== 1) {?>
    <p style="color:#F00" align="center">驗證碼輸入錯誤</p>
    <?php } ?>
    
<form action="<?php echo $loginFormAction; ?>" method="POST" id="form1" name="form1" style="margin-top:150px; margin-bottom:auto">    
<table width="500" border="0" cellpadding="0">
  <tr>
    <td width="20%">管理者帳號:</td>
    <td colspan="2"><input type="text" name="b_username" id="b_username" />
      <label for="b_captcha"></label></td>
        </tr>
  <tr>
    <td>管理者密碼:</td>
    <td colspan="2"><label for="b_captcha"></label>
      <input type="password" name="b_password" id="b_password" />
      <label for="b_captcha"></label></td>
          </tr>
  <tr>
    <td>驗證碼：:</td>
    <td width="38%"><label for="b_captcha"></label>
      <input name="b_captcha" type="text" id="b_captcha" value="請輸入右方驗證碼" maxlength="10" onfocus="this.value=''" /></td>
    <td width="42%"><label for="b_captcha"><img src="CaptchaSecurityImages.php?width=130&amp;height=40&amp;characters=5" name="imgCaptcha" id="imgCaptcha" /><a href="javascript:void(0)" onclick="RefreshImage('imgCaptcha')" style="font-size:9pt">更換圖片
    </a><br />
    </a></label></td>
  </tr>  
  <tr>
    <td colspan="3"><input type="submit" value="登入" />
      </td>
        </tr>
</table>
</form>
</div>
  </div>
  <?php include('../cx_footer.php'); ?>
</div>
</body>
</html>