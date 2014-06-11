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
$query_RecEconomy = "SELECT * FROM product WHERE hot = 1 ORDER BY n_id ASC";
$RecEconomy = mysql_query($query_RecEconomy, $ksnews3) or die(mysql_error());
$row_RecEconomy = mysql_fetch_assoc($RecEconomy);
$totalRows_RecEconomy = mysql_num_rows($RecEconomy);
?>

  <table width="100%" id="economy">
    <tr>
      <td colspan="2" id="th"></td>
    </tr>
	<?php if ($totalRows_RecEconomy > 0) { // Show if recordset not empty ?>
    <?php do { ?>
      <tr style="font-size:0.8em" >
        <td width="68" rowspan="2"><div align="center"><a href="cx_economy_detail.php?id=<?php echo $row_RecEconomy['n_id']; ?>&amp;hits=true"><img src="images/bnb/<?php echo $row_RecEconomy['big_pic']; ?>" width="79" /></a></div></td>
        <td width="148" height="17"><?php echo mb_substr($row_RecEconomy['n_name'],0,6,'utf-8'); ?><span id="morebtn" style="width:50px; float:right"><a href="cx_bnb_detail.php?id=<?php echo $row_RecEconomy['n_id']; ?>&amp;hits=true">more</a></span></td>
      </tr>
      <tr style="font-size:0.8em">
        <td height="34"><?php echo mb_substr($row_RecEconomy['n_name'],0,20,'utf-8'); ?>
        </td>
        </tr> 
	<tr height="5px">
        <td colspan="2"><hr/>
        </td>
      </tr>       
      <?php } while ($row_RecEconomy = mysql_fetch_assoc($RecEconomy)); ?>
	  <?php } // Show if recordset not empty ?>              
  </table>

<?php
mysql_free_result($RecEconomy);
?>
