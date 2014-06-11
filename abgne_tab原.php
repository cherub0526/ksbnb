<?php require_once('Connections/connSQL.php'); ?>
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

$colname_RecZip = '花蓮縣';
mysql_select_db($database_connSQL, $connSQL);
$query_RecZip = sprintf("SELECT * FROM zipcode WHERE City = %s ORDER BY Id ASC", GetSQLValueString($colname_RecZip, "text"));
$RecZip = mysql_query($query_RecZip, $connSQL) or die(mysql_error());
$row_RecZip = mysql_fetch_assoc($RecZip);
$totalRows_RecZip = mysql_num_rows($RecZip);

$colname_RecContent = '花蓮縣';
mysql_select_db($database_connSQL, $connSQL);
$query_RecContent = sprintf("SELECT * FROM zipcode WHERE City = %s ORDER BY Id ASC", GetSQLValueString($colname_RecContent, "text"));
$RecContent = mysql_query($query_RecContent, $connSQL) or die(mysql_error());
$row_RecContent = mysql_fetch_assoc($RecContent);
$totalRows_RecContent = mysql_num_rows($RecContent);

?>

<div class="abgne_tab">
    <ul class="tabs">
      <?php do { ?>
        <li><a href="#tab<?php echo $row_RecZip['ZipCode']; ?>"><?php echo $row_RecZip['Area']; ?></a></li>
      <?php } while ($row_RecZip = mysql_fetch_assoc($RecZip)); ?>
    </ul>

    <div class="tab_container">
        <?php do { ?>
      <div id="tab<?php echo $row_RecContent['ZipCode']; ?>" class="tab_content">
        <h2><?php echo $row_RecContent['Area']; ?></h2>        
    <?php 
      $colname_RecZipCode = $row_RecContent['ZipCode'];     
      mysql_select_db($database_connSQL, $connSQL);
      $query_RecZipCode = sprintf("SELECT * FROM bnbhualien WHERE b_zip = %s ORDER BY b_id ASC", GetSQLValueString($colname_RecZipCode, "text"));;
      $RecZipCode = mysql_query($query_RecZipCode, $connSQL) or die(mysql_error());
      $row_RecZipCode = mysql_fetch_assoc($RecZipCode);
      $totalRows_RecZipCode = mysql_num_rows($RecZipCode);
    ?>
        <?php do { ?>
        <span id="reczipcode"><a href="<?php echo $row_RecZipCode['b_url']; ?>" target="_blank"><?php echo $row_RecZipCode['b_name']; ?></a></span>
        <?php } while($row_RecZipCode = mysql_fetch_assoc($RecZipCode)); ?>
      </div>
        <?php } while($row_RecContent = mysql_fetch_assoc($RecContent)) ; ?>
    </div>
  </div>
    
<?php 
mysql_free_result($RecZip);
mysql_free_result($RecContent);
mysql_free_result($RecZipCode);
?>