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
$colname_Recordset1 = "-1";
if (isset($_GET['id'])) {
  $colname_Recordset1 = $_GET['id'];
}

mysql_select_db($database_ksnews3, $ksnews3);
$query_Recordset1 = sprintf("SELECT * FROM level2 WHERE level2_id = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $ksnews3) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $level_id =$row_Recordset1['level1_id'];	
  $updateSQL = sprintf("UPDATE level2 SET level1_id=%s, seq=%s, name=%s, detail=%s WHERE level2_id=%s",
                       GetSQLValueString($_POST['level1_id'], "int"),
                       GetSQLValueString($_POST['level1_id'], "int"),
                       GetSQLValueString($_POST['name'], "text"),
                       GetSQLValueString($_POST['name'], "text"),
                       GetSQLValueString($_POST['level2_id'], "int"));

  mysql_select_db($database_ksnews3, $ksnews3);
  $Result1 = mysql_query($updateSQL, $ksnews3) or die(mysql_error());

  $updateGoTo = "admin_city_l2.php?id=";
  header(sprintf("Location: %s%s", $updateGoTo,$level_id));
}




?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>無標題文件</title>
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
<div id="content" class="cx_admin_table">
  <table width="671" border="1">
    <tr>
      <td width="150" align="center">修改標題主題    </td>
      <td width="303" align="center"><h4>第二分類</h4></td>
      <td width="196" align="center">&nbsp;</td>
    </tr>
    <form action="<?php echo $editFormAction; ?>" name="form1" method="POST">
      <tr>
        <td align="center"><label for="name"></label>
        <input name="name" type="text" id="name" value="<?php echo $row_Recordset1['name']; ?>" /></td>
        <td align="center"><?php echo $row_Recordset1['level2_id']; ?></td>
        <td align="center">
          <input name="level2_id" type="hidden" id="level2_id" value="<?php echo $row_Recordset1['level2_id']; ?>" />
        <input name="level1_id" type="hidden" id="level1_id" value="<?php echo $row_Recordset1['level1_id']; ?>" /></td>
      </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center"><input type="submit" name="button" id="button" value="送出">
      <input type="button" value="回上一頁" onclick="self.location.href='admin_city_l2.php?id=<?php echo $row_Recordset1['level1_id']; ?>'"/></td>
  </tr>
  <input type="hidden" name="MM_update" value="form1" />
    </form>
  </table>
</div>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
