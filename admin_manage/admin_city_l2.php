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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
  $insertSQL = sprintf("INSERT INTO level2 (level1_id, seq, name, detail) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['level1_id'], "int"),
                       GetSQLValueString($_POST['level1_id'], "int"),
                       GetSQLValueString($_POST['name'], "text"),
                       GetSQLValueString($_POST['name'], "text"));

  mysql_select_db($database_ksnews3, $ksnews3);
  $Result1 = mysql_query($insertSQL, $ksnews3) or die(mysql_error());

  $insertGoTo = "admin_city_l2.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

if ((isset($_GET['id'])) && ($_GET['id'] != "") && (isset($_GET['delsure']))) {
	$level_id = $_GET['level_id'];
  $deleteSQL = sprintf("DELETE FROM level2 WHERE level2_id=%s",
                       GetSQLValueString($_GET['id'], "int"));

  mysql_select_db($database_ksnews3, $ksnews3);
  $Result1 = mysql_query($deleteSQL, $ksnews3) or die(mysql_error());

  $deleteGoTo = "admin_city_l2.php?id=".$level_id;
  header(sprintf("Location: %s", $deleteGoTo));
}

$colname_Recordset1 = "-1";
if (isset($_GET['id'])) {
  $colname_Recordset1 = $_GET['id'];
}
mysql_select_db($database_ksnews3, $ksnews3);
$query_Recordset1 = sprintf("SELECT * FROM level2 WHERE level1_id = %s ORDER BY level2_id ASC", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $ksnews3) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$colname_Recordset2 = "-1";
if (isset($_GET['id'])) {
  $colname_Recordset2 = $_GET['id'];
}
mysql_select_db($database_ksnews3, $ksnews3);
$query_Recordset2 = sprintf("SELECT * FROM level1 WHERE level_id = %s", GetSQLValueString($colname_Recordset2, "int"));
$Recordset2 = mysql_query($query_Recordset2, $ksnews3) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>無標題文件</title>
<script type="text/javascript">
function tfm_confirmLink(message) { //v1.0
	if(message == "") message = "Ok to continue?";	
	document.MM_returnValue = confirm(message);
}
</script>
<link href="../css/admin_style.css" rel="stylesheet" type="text/css" />
<style type="text/css">
#content {
	background-color: #F3F3F3;
	float: left;
	width: 835px;
}
</style>
<script language="javascript">
function reSize(){
　　//parent.document.all.frameid.height=document.body.scrollHeight; 
　　parent.document.getElementById("frm").height=document.body.scrollHeight;
} 
window.onload=reSize;
</script>
</head>

<body>
<div class="cx_admin_table" id="content">
  <table width="671" border="1">
    <tr>
      <td width="150" align="center">修改標題主題</td>
      <td width="303" align="center"><h4>第二分類</h4></td>
      <td width="196" align="center">
        <form id="form2" name="form2" method="POST" action="<?php echo $editFormAction; ?>">
          <h4>
            <label for="name"></label>
            <input name="level1_id" type="hidden" id="level1_id" value="<?php echo $row_Recordset2['level_id']; ?>" />
            <input name="name" type="text" id="name" size="10" /> <input type="submit" value="新增" />
          </h4>
          <input type="hidden" name="MM_insert" value="form2" />
        </form></td>
    </tr>
    <form action="<?php echo $editFormAction; ?>" name="form1" method="POST">
      <?php do { ?>
        <?php if ($totalRows_Recordset1 > 0) { // Show if recordset not empty ?>
          <tr>
            <td align="center"><?php echo $row_Recordset1['name']; ?></td>
            <td align="center"><?php echo $row_Recordset1['level2_id']; ?></td>
            <td align="center">[<a href="admin_city_l3.php?id=<?php echo $row_Recordset1['level2_id']; ?>">修改</a>][<a href="admin_city_l2.php?delsure=true&amp;id=<?php echo $row_Recordset1['level2_id']; ?>&amp;level_id=<?php echo $row_Recordset1['level1_id']; ?>" onclick="tfm_confirmLink('');return document.MM_returnValue">刪除</a>]</td>
          </tr>
          <?php } // Show if recordset not empty ?>
  <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
  <tr>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center"><input type="submit" name="button" id="button" value="送出">
      <input type="button" value="回上一頁" onclick="self.location.href='admin_city.php'"/></td>
    </tr></form>
  </table>
</div>
<input type="hidden" name="MM_update" value="form1" />
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);
?>
