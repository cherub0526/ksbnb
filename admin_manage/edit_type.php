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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $test = implode(",",$_POST['CheckboxGroup1']);
  $query_update = sprintf("UPDATE product_type SET detail='%s' WHERE id=%s",$test,$_POST['id']);
  mysql_select_db($database_ksnews3,$ksnews3);
  mysql_query($query_update,$ksnews3);
  header("Location:product_type.php");  
}

$colname_RecType = "-1";
if (isset($_GET['id'])) {
  $colname_RecType = $_GET['id'];
}
mysql_select_db($database_ksnews3, $ksnews3);
$query_RecType = sprintf("SELECT * FROM product_type WHERE id = %s", GetSQLValueString($colname_RecType, "int"));
$RecType = mysql_query($query_RecType, $ksnews3) or die(mysql_error());
$row_RecType = mysql_fetch_assoc($RecType);
$totalRows_RecType = mysql_num_rows($RecType);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>無標題文件</title>
<script type="text/javascript" src="../js/jquery-1.7.1.min.js"></script>
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
<script>
$(document).ready(function(){
	$("#add").click(function(){
		var text = $("<input type=\"text\" id=\"checkbox\" name=\"CheckboxGroup1[]\" value=\"\" />");
		var removeButton = $("<input type=\"button\" class=\"remove\" value=\"刪除\" /> <br/>");
		var fieldWrapper = $("<label/>");
		
		removeButton.click(function() {
            $(this).parent().remove();
        });

		fieldWrapper.append(text);
		fieldWrapper.append(removeButton);	
		$("#table").append(fieldWrapper);			
	});			
	$("input.remove").click(function(){
	$(this).parent().remove();
	});
})
</script>
<link href="../css/admin_style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="cx_admin_table" id="content">
  <div id="top_nav">
    <table width="835" border="0" cellpadding="0" cellspacing="0" height="28">
      <tr>
        <td width="23" background="../images/board10.gif">&nbsp;</td>
        <td width="232" background="../images/board04.gif" align="left" style="font-size:0.8em"> 屬性選單         </td>
        <td width="569" background="../images/board04.gif">&nbsp;</td>
        <td width="11" background="../images/board05.gif">&nbsp;</td>
        </tr>
      </table>
  </div>
  <input type="button" id="add" value="新增選項"/> 
  
  <form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>">
    <input name="id" type="hidden" id="id" value="<?php echo $row_RecType['id']; ?>" />
    
    <table id="table" width="845px" border="0" cellspacing="0" cellpadding="0">
      
<?php 
$str = explode(",",$row_RecType['detail']);
for($i=0;$i<count($str);$i++){ ?>  
      <tr>
        <td>
          <label>
            <input type="text" id="checkbox" name="CheckboxGroup1[]" value="<?php echo $str[$i];?>">
        <input type="button" class="remove" value="刪除"></label></td>
      </tr>
<?php } ?>
    </table>
    <input type="hidden" name="MM_update" value="form1" />
    <input type="submit" value="送出"/>
    <input type="button" value="回上一頁" onclick="window.history.back()" />
  </form>
</div>
</body>
</html>
<?php
mysql_free_result($RecType);
?>
