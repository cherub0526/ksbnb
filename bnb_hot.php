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

mysql_select_db($database_ksnews3, $ksnews3);
$query_RecHot = sprintf("SELECT * FROM product WHERE n_choose = 1 ORDER BY rand() ASC");
$RecHot = mysql_query($query_RecHot, $ksnews3) or die(mysql_error());
$row_RecHot = mysql_fetch_assoc($RecHot);
$totalRows_RecHot = mysql_num_rows($RecHot);
?>
<?php if($totalRows_RecHot!=0) { ?>
<table width="100%">
<tr style="height:20px; background-color:#9FD4BA">
      <td align="center"><strong>精選民宿</strong></td>
    </tr>
</table>
<?php 
if($totalRows_RecHot > 0){
}do { ?>
  <a href="cx_bnb_detail.php?id=<?php echo $row_RecHot['n_id']; ?>&amp;hits=true" title="<?php echo $row_RecHot['n_name'];?>" style="margin-bottom:10px"><img src="images/bnb/<?php echo $row_RecHot['big_pic']; ?>" width="145" align="left" style="margin-top:10px; border:solid 1px #000"></a>
  <?php } while ($row_RecHot = mysql_fetch_assoc($RecHot));} ?><?php mysql_free_result($RecHot); ?>
