<?php require_once('../Connections/ksnews3.php'); ?>
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

//initialize the session
if (!isset($_SESSION)) {
  session_start();
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
  unset($_SESSION['PrevUrl']);
  
  mysql_select_db($database_ksnews3,$ksnews3);
  $query_update = sprintf("UPDATE user_count SET out_time = %s WHERE view_id = %s",GetSQLValueString(date("Y-m-d H:i:s"),"date"),GetSQLValueString($_SESSION['Logout_id'],"int"));	
  mysql_query($query_update,$ksnews3);
  
  $logoutGoTo = "../index.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "admin,member";
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

$MM_restrictGoTo = "login.php";
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
$colname_RecMember = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_RecMember = $_SESSION['MM_Username'];
}
mysql_select_db($database_ksnews3, $ksnews3);
$query_RecMember = sprintf("SELECT * FROM users WHERE `user` = %s", GetSQLValueString($colname_RecMember, "text"));
$RecMember = mysql_query($query_RecMember, $ksnews3) or die(mysql_error());
$row_RecMember = mysql_fetch_assoc($RecMember);
$totalRows_RecMember = mysql_num_rows($RecMember);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" > 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>更生民宿網-後檯</title>
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<link href="../css/admin_style.css" rel="stylesheet" type="text/css" />
<script src="../SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryMenuBarVertical.css" rel="stylesheet" type="text/css" />
<style type="text/css">
#frm {
}
</style>
</head>

<body>
<div id="body">
<?php
include("../cx_header.php");
?>
  <div id="cx_content">
    <div id="cx_c_left">
      <ul id="MenuBar1" class="MenuBarVertical">
      <?php if($_SESSION['MM_UserGroup']=="admin") { ?>
<li><a href="admin_banner.php" target="frm" class="MenuBarItemSubmenu">廣告</a>
          <ul>
            <li><a href="admin_banner.php" target="frm">廣告管理</a></li>
            <li><a href="admin_bannerDow.php" target="frm">下架中廣告管理</a></li>
			<li><a href="admin_bannerHits.php" target="frm">廣告點擊管理</a></li>
          </ul>
        </li>
      <?php } ?>
        <li><a href="admin_userUpdate.php?id=<?php echo $row_RecMember['user_id']; ?>" target="frm" class="MenuBarItemSubmenu">會員管理</a>
          <ul>
            <li><a href="admin_userUpdate.php?id=<?php echo $row_RecMember['user_id']; ?>" target="frm">個人資料修改</a></li>
            <?php if($_SESSION['MM_UserGroup']=="admin") { ?>
            <li><a href="admin_member.php" target="frm">一般會員管理</a></li>
            <li><a href="member_detail.php" target="frm">系統會員管理</a></li>
            <li><a href="member.php" target="frm">新增管理者</a></li>
			<!--<li><a href="admin_vender.php" target="frm">廠商會員管理</a></li>-->
            <?php } ?>
          </ul>
        </li>
        <?php if($_SESSION['MM_UserGroup']=="admin") { ?>
        <li><a href="admin_viewCount.php" target="frm" class="MenuBarItemSubmenu">流覽統計</a>
          <ul>
            <li><a href="admin_viewCount.php" target="frm">瀏覽人次</a></li>
            <li><a href="admin_user_count.php" target="frm">會員登入資料</a></li>
            <li><a href="admin_viewCount_lint.php" target="frm">瀏覽人次總計</a></li>
          </ul>
        </li>
        <li><a href="bnbstore_detail.php" target="frm" class="MenuBarItemSubmenu">產品與類別相關維護</a>
          <ul>
            <li><a href="admin_city.php" target="frm">產品類別管理</a></li>
            <li><a href="bnbstore_detail.php" target="frm">產品管理</a></li>
            <!--<li><a href="bnbadd.php" target="frm">新增產品</a></li>-->
          </ul>
        </li>
        <?php } ?>
<li><a href="../index.php">回首頁</a>        </li>
        <li><a href="<?php echo $logoutAction ?>">登出</a></li>
      </ul>
    </div>
    <div id="cx_c_right"><iframe id="frm" scrolling="no" frameborder="0" style="text-align:center" onload="javascript:resize()">cx_c_right</iframe></div>
  </div>
  <?php include("../cx_footer.php");?>
</div>
<script type="text/javascript">
var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgRight:"../SpryAssets/SpryMenuBarRightHover.gif"});
</script>
</body>
</html>
<?php
mysql_free_result($RecMember);
?>
