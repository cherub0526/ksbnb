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

mysql_select_db($database_ksnews3, $ksnews3);
$query_RecType = "SELECT * FROM product_type WHERE id >= 14 ORDER BY id ASC";
$RecType = mysql_query($query_RecType, $ksnews3) or die(mysql_error());
$row_RecType = mysql_fetch_assoc($RecType);
$totalRows_RecType = mysql_num_rows($RecType);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>無標題文件</title>
<link href="../css/admin_style.css" rel="stylesheet" type="text/css" />
<script language="javascript">
function reSize(){
　　//parent.document.all.frameid.height=document.body.scrollHeight; 
  if(　parent.document.getElementById("frm").height < 700){
	  　parent.document.getElementById("frm").height = 700;
  }
  else{
　	   parent.document.getElementById("frm").height=document.body.scrollHeight;
  }
} 
window.onload=reSize;
</script>
</head>

<body>
<div class="cx_admin_table" id="content">
  <div id="top_nav">
    <table width="835" border="0" cellpadding="0" cellspacing="0" height="28">
      <tr>
        <td width="23" background="../images/board10.gif">&nbsp;</td>
        <td width="232" background="../images/board04.gif" align="left" style="font-size:0.8em"> 屬性選單 總覽         </td>
        <td width="569" background="../images/board04.gif">&nbsp;</td>
        <td width="11" background="../images/board05.gif">&nbsp;</td>
      </tr>
      </table>
<table width="835" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="73">編號</td>
    <td width="122">標題</td>
    <td width="522">內容</td>
    <td width="118">編輯</td>
  </tr>
  <?php do { ?>
    <tr>
      <td width="73"><?php echo $row_RecType['id']; ?></td>
      <td width="122"><?php echo $row_RecType['info_zh']; ?></td>
      <td width="522"><?php echo $row_RecType['detail']; ?></td>
      <td width="118"><a href="edit_type.php?id=<?php echo $row_RecType['id']; ?>" target="frm">編輯</a></td>
    </tr>
    <?php } while ($row_RecType = mysql_fetch_assoc($RecType)); ?>
</table>

  </div>
</div>
</body>
</html>
<?php
mysql_free_result($RecType);
?>
