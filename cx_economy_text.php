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

$colname_RecSearchEconomy = "-1";
if (isset($_GET['id'])) {
  $colname_RecSearchEconomy = $_GET['id'];
}
mysql_select_db($database_ksnews3, $ksnews3);
$query_RecSearchEconomy = sprintf("SELECT * FROM product WHERE n_id = %s", GetSQLValueString($colname_RecSearchEconomy, "int"));
$RecSearchEconomy = mysql_query($query_RecSearchEconomy, $ksnews3) or die(mysql_error());
$row_RecSearchEconomy = mysql_fetch_assoc($RecSearchEconomy);
$totalRows_RecSearchEconomy = mysql_num_rows($RecSearchEconomy);
?> 

<div class="row-bot" style="margin-left:5px">
<div class="slider-wrapper">    
    <div class="slider">
      <ul class="items">        
        <?php if(isset($row_RecSearchEconomy['big_pic'])) { ?>
        <li> <img src="timthumb.php?src=images/bnb/<?php echo $row_RecSearchEconomy['big_pic']; ?>&w=680&h=350&zc=0&q=100" alt="" /></li>
		<?php } ?>
      </ul>
    </div>
</div>
<table border="0" cellspacing="0" cellpadding="0" width="100%">
  <tr>
    <td><h1><?php echo $row_RecSearchEconomy['n_name']; ?></h1></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><?php echo nl2br(htmlspecialchars($row_RecSearchEconomy['n_detail'])); ?></td>
    </tr>
</table>


</div>
