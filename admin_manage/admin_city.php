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


mysql_select_db($database_ksnews3, $ksnews3);
$query_Recordset1 = "SELECT * FROM level1 ORDER BY level_id ASC";
$Recordset1 = mysql_query($query_Recordset1, $ksnews3) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  for($i=1;$i<=$totalRows_Recordset1;$i++){
  $id = "level_id".$i;
  $name = "name".$i;
  $updateSQL = sprintf("UPDATE level1 SET seq=%s, name=%s, detail=%s WHERE level_id=%s",
                       GetSQLValueString($_POST[$id], "int"),
                       GetSQLValueString($_POST[$name], "text"),
                       GetSQLValueString($_POST[$name], "text"),
                       GetSQLValueString($_POST[$id], "int"));

  mysql_select_db($database_ksnews3, $ksnews3);
  $Result1 = mysql_query($updateSQL, $ksnews3) or die(mysql_error());
}
  $updateGoTo = "admin_city.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>城市管理</title>
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
  <form action="<?php echo $editFormAction; ?>" name="form1" method="POST">
    <div id="admin_main">
      <table width="671" border="1" cellpadding="0" cellspacing="2">
        <tr>
          <td align="center">頁首水平選單管理</td>
          <td align="left"><h4>主選單標題</h4></td>
          <td align="left"><h4>次選單標題</h4></td>
        </tr>
        <?php do { ?>
          <tr>
            <td width="171" align="center"><?php echo $row_Recordset1['level_id']; ?>
            <input name="level_id<?php echo (int)$row_Recordset1['level_id'];?>" type="hidden" id="level_id<?php echo (int)$row_Recordset1['level_id'];?>" value="<?php echo $row_Recordset1['level_id']; ?>" /></td>
            <td width="180" align="left"><label for="name<?php echo (int)$row_Recordset1['level_id'];?>"></label>
              <input name="name<?php echo (int)$row_Recordset1['level_id'];?>" type="text" id="name<?php echo (int)$row_Recordset1['level_id'];?>" value="<?php echo $row_Recordset1['name']; ?>" size="27" /></td>
            <td width="304" align="left"><a href="admin_city_l2.php?id=<?php echo $row_Recordset1['level_id']; ?>"><?php echo $row_Recordset1['name']; ?></a></td>
          </tr>
          <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
  <tr>
    <td align="center">&nbsp;</td>
    <td align="left" style="color:#F00">(*字數超過會造成版面錯位*)</td>
    <td align="left"><input type="submit" name="button" id="button" onclick="tfm_confirmLink('');return document.MM_returnValue" value="送出" /></td>
    </tr>
      </table>
      <br />
    </div>
    <input type="hidden" name="MM_update" value="form1" />
  </form>
</div>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
