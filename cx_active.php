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
$date = date("Y-m-d",strtotime('-2 day')); //判斷時間到期
$today = date("Y-m-d");
mysql_select_db($database_ksnews3, $ksnews3);
$query_RecActive = sprintf("SELECT * FROM banner WHERE level = %s ORDER BY banner_id ASC LIMIT 7",GetSQLValueString($level,"int")/*,GetSQLValueString($date,"date")*/);
$RecActive = mysql_query($query_RecActive, $ksnews3) or die(mysql_error());
$row_RecActive = mysql_fetch_assoc($RecActive);
$totalRows_RecActive = mysql_num_rows($RecActive);
?>
<div id="cx_active" style="font-size:0.8em">
  <table border="0" cellspacing="0" cellpadding="0" width="100%">
  <?php if($totalRows_RecActive != 0){?>
    <tr style="height:20px; background-color:#9FD4BA">
      <td colspan="2" align="center"><strong><?php echo $title;?></strong></td>
    </tr>
    <?php }do { ?>
      <?php if ($totalRows_RecActive > 0) { // Show if recordset not empty ?>
  <tr>
    <td width="25"><img src="images/new_icon.gif" width="25" height="25" /></td>
    <td width="948" style="background-color:"><a href="cx_active_detail.php?id=<?php echo $row_RecActive['banner_id']; ?>&amp;hits=true"><?php echo mb_substr($row_RecActive['banner_title'],0,10,'utf-8') ; ?></a></td>
  </tr>
  <?php } // Show if recordset not empty ?>
      <?php } while ($row_RecActive = mysql_fetch_assoc($RecActive)); ?>
  </table>

</div>
<?php
mysql_free_result($RecActive);
?>
