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

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['group']);
  unset($_SESSION['PrevUrl']);
  
  mysql_select_db($database_ksnews3,$ksnews3);
  $query_update = sprintf("UPDATE user_count SET out_time = %s WHERE view_id = %s",GetSQLValueString(date("Y-m-d H:i:s"),"date"),GetSQLValueString($_SESSION['Logout_id'],"int"));	
  mysql_query($query_update,$ksnews3);
  
  if(dirname($_SERVER['PHP_SELF']) == "/ksbnb/admin_manage") {
  	$logoutGoTo = "../index.php";
  }
  else{
  	$logoutGoTo = "index.php";
  }
  
  if ($logoutGoTo) {
    header("Location: ".$logoutGoTo);
    exit;
  }
}

if(isset($_GET['level2_id']) && $_GET['level2_id']!=""){
mysql_select_db($database_ksnews3, $ksnews3);
$query_banner_header = "SELECT banner_id, banner_type, banner_pic, `update`,downdate FROM banner WHERE level = '{$_GET['level2_id']}' AND  CURDATE( )<=  DATE_ADD( `update`  , INTERVAL `downdate` DAY ) AND class = 'B6' ORDER BY sorting asc LIMIT 0,1";
$banner_header = mysql_query($query_banner_header, $ksnews3) or die(mysql_error());
$row_banner_header = mysql_fetch_assoc($banner_header);
$totalRows_banner_header = mysql_num_rows($banner_header);

}

if(isset($_GET['level2_id']) && $_GET['level2_id']!="" && isset($_GET['n_id']) && $_GET['n_id']!=""){
mysql_select_db($database_ksnews3, $ksnews3);
$query_banner_header = "SELECT banner_id, banner_type, `update`,banner_pic, downdate FROM banner WHERE level = '{$_GET['level2_id']}' AND  CURDATE( )<=  DATE_ADD( `update`  , INTERVAL `downdate` DAY ) AND class = 'C4' ORDER BY sorting asc LIMIT 0,1";
$banner_header = mysql_query($query_banner_header, $ksnews3) or die(mysql_error());
$row_banner_header = mysql_fetch_assoc($banner_header);
$totalRows_banner_header = mysql_num_rows($banner_header);

}
/*
if(isset($_GET['action_type']) && $_GET['action_type']!="" && $_GET['action_type']=='1'){
mysql_select_db($database_ksnews3, $ksnews3);
$query_banner_header = "SELECT banner_id, banner_type, banner_pic, downdate FROM banner WHERE level = '151' OR level = '152' AND  CURDATE( )<=  DATE_ADD( `update`  , INTERVAL `downdate` DAY ) AND class = 'D3' ORDER BY rand() LIMIT 0,1";
$banner_header = mysql_query($query_banner_header, $ksnews3) or die(mysql_error());
$row_banner_header = mysql_fetch_assoc($banner_header);
$totalRows_banner_header = mysql_num_rows($banner_header);

}


if(isset($_GET['action_type']) && $_GET['action_type']!="" && $_GET['action_type']=='2'){
mysql_select_db($database_ksnews3, $ksnews3);
$query_banner_header = "SELECT banner_id, banner_type, banner_pic, downdate FROM banner WHERE level = '153' OR level = '154' AND  CURDATE( )<=  DATE_ADD( `update`  , INTERVAL `downdate` DAY ) AND class = 'D3' ORDER BY rand() LIMIT 0,1";
$banner_header = mysql_query($query_banner_header, $ksnews3) or die(mysql_error());
$row_banner_header = mysql_fetch_assoc($banner_header);
$totalRows_banner_header = mysql_num_rows($banner_header);

}

if(isset($_GET['action_type']) && $_GET['action_type']!="" && $_GET['action_type']=='3'){
mysql_select_db($database_ksnews3, $ksnews3);
$query_banner_header = "SELECT banner_id, banner_type, banner_pic, downdate FROM banner WHERE level = '149' OR level = '150' AND  CURDATE( )<=  DATE_ADD( `update`  , INTERVAL `downdate` DAY ) AND class = 'D3' ORDER BY rand() LIMIT 0,1";
$banner_header = mysql_query($query_banner_header, $ksnews3) or die(mysql_error());
$row_banner_header = mysql_fetch_assoc($banner_header);
$totalRows_banner_header = mysql_num_rows($banner_header);

}
*/
if(isset($_GET['action_type']) && $_GET['action_type']!="" ){
mysql_select_db($database_ksnews3, $ksnews3);
$query_banner_header = "SELECT banner_id, banner_type, banner_pic, `update`, downdate FROM banner WHERE level = '172' AND  CURDATE( )<=  DATE_ADD( `update`  , INTERVAL `downdate` DAY ) AND class = '172' ORDER BY rand() LIMIT 0,1";
$banner_header = mysql_query($query_banner_header, $ksnews3) or die(mysql_error());
$row_banner_header = mysql_fetch_assoc($banner_header);
$totalRows_banner_header = mysql_num_rows($banner_header);

}
//echo $query_banner_header;
//echo $query_banner_header;
//echo $query_banner_header;
?>
<style type="text/css">
#header {
	height: 16px;
	width: 990px;
}
#header_R {
	float: right;
	height: 16px;
	width: auto;
	font-family: "微軟正黑體", "標楷體", "細明體";
	font-size: 12px;
}
  #dete {
	float: left;
	height: 16px;
	width: 350px;
	font-family: "微軟正黑體", "標楷體", "新細明體";
}
  #logo {
	height: 62px;
	width: 990px;
	float: left;
	margin-top: 2px;
	background-image: url(images/kslogo2_1.gif);
}

#footer {
	float: left;
	height: 70px;
	width: 1000px;
	font-size: 14px;
	color: #666666;
	background-image: url(/images/bg_footer.gif);
	background-repeat: repeat-x;
}
#footer_pic {
	background-image: url(admin_ksnews/ckeditor/images/flooer_5.gif);
	float: left;
	height: 72px;
	width: 138px;
}
/*
#banner_logo {
	float: left;
	height: 62px;
	width: 200px;
	/* [disabled]border: 0.8px solid #990; */
/*	margin-left: 290px;
   display:inline; 
}
*/
  #logo_back {
	height: 62px;
	width: 500px;
	float: left;
	margin-top: 2px;
	background-image: url(images/KSbanner-2 (2)_remmant.jpg);
}
#banner_logo {
	float: left;
	height: 62px;
	width: 200px;
	/* [disabled]border: 0.8px solid #990; */

   /*display:inline; */
   margin-top: 2px;
  background-image: url(images/KSbanner-3 (2)_middle.jpg) 
}
#header_logo{
	height: 62px;
	width: 290px;
	float: left;
	margin-top: 2px;
	background-image: url(images/KSbanner-2 (2)_head.jpg);
	
}

</style>
<div id="header"> 
   <div id="dete">
   <?php 
      //require("date.php"); ?>
   <SCRIPT language=JavaScript src="js/lunar.js"></SCRIPT>
   </div>
   <?php if(empty($_SESSION["MM_Username"])){//未登入?>
   <div id="header_R"> <div id="link1">
   <a href="index.php">&nbsp;回首頁</a> 
   <!--<a href="introduction.php">&nbsp;關於更生</a> 
   <!--<a href="useractionAssent.php" target="_blank">&nbsp;我有活動</a> 
   <a href="userPostAssent.php" target="_blank">&nbsp;線上投稿</a> -->
   <!--<a href="uorder_add.php" target="_blank">&nbsp;網路訂報</a> 
   <a href="banner_class.php" target="_blank">&nbsp;刊登廣告</a> 
   <a href="http://tw.stock.yahoo.com/s/tse.php" target="_blank">&nbsp;股市行情</a>
   <!--<a href="userBookAssent.php" target="_blank">&nbsp;線上投書</a>-->
   <!--<a href="login_vender.php">&nbsp;廠商登入與註冊</a>-->
 <a href="login.php">&nbsp;會員登入與註冊</a>
 <a href="admin_manage/login.php">&nbsp;管理者登入</a>
 </div></div>
   <?php }else{//登入後?>
   <div id="header_R"> <div id="link1">
 <a href="index.php">&nbsp;回首頁</a> 
 <a href="introduction.php">&nbsp;關於更生</a>
 <!--<a href="useractionAssent.php" target="_blank">&nbsp;我有活動</a> 
 <a href="userPostAssent.php" target="_blank">&nbsp;線上投稿</a>
 <a href="uorder_add.php" target="_blank">&nbsp;網路訂報</a>  -->
 <a href="banner_class.php" target="_blank">&nbsp;刊登廣告</a> 
 <a href="http://tw.stock.yahoo.com/s/tse.php" target="_blank">&nbsp;股市行情</a>
 <!--<a href="userBookAssent.php" target="_blank">&nbsp;線上投書</a>-->
 <?php //if($_SESSION["MM_UserGroup"]=='member'){
	if($_SESSION['group']=='member'){
	 ?><a href="admin_ksnews/admin_ksnews.php">&nbsp;會員專區</a><?php }?>
     <?php	if($_SESSION['group']=='vender'){
	 ?><a href="admin_ksnews/admin_ksnews.php">&nbsp;廠商專區</a><?php }?>
 <?php if($_SESSION['group']=='admin'){?><a href="admin_ksnews/admin_ksnews.php">&nbsp;後臺</a><?php }?>
 <?php if(!empty($_SESSION['group'])) {;?><a href="header.php?doLogout=true">&nbsp;登出</a><?php } ?></div></div></div>
   <?php }?>

<?php 
if((isset($_GET['level2_id']) && $_GET['level2_id']!="" && isset($_GET['n_id']) && $_GET['n_id']!="")||
(isset($_GET['action_type']) && $_GET['action_type']!=""))
//mysql_free_result($banner_header);
?>