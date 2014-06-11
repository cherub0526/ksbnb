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

$colname_RecSearchBanner = "-1";
if (isset($_GET['id'])) {
  $colname_RecSearchBanner = $_GET['id'];
}
mysql_select_db($database_ksnews3, $ksnews3);
$query_RecSearchBanner = sprintf("SELECT * FROM banner WHERE banner_id = %s", GetSQLValueString($colname_RecSearchBanner, "int"));
$RecSearchBanner = mysql_query($query_RecSearchBanner, $ksnews3) or die(mysql_error());
$row_RecSearchBanner = mysql_fetch_assoc($RecSearchBanner);
$totalRows_RecSearchBanner = mysql_num_rows($RecSearchBanner);
?> 

<div class="row-bot">
<div class="slider-wrapper">    
    <div class="slider">
      <ul class="items">        
        <?php if(isset($row_RecSearchBanner['banner_pic'])) { ?>
        <li> <img src="timthumb.php?src=images/ksad/<?php echo $row_RecSearchBanner['banner_pic']; ?>&w=680&h=350" alt="" /></li>
		<?php } if(isset($row_RecSearchBanner['banner_pic2'])){ ?>
        <li> <img src="timthumb.php?src=images/ksad/<?php echo $row_RecSearchBanner['banner_pic2']; ?>&w=680&h=350" alt="" /></li>        
        <?php } ?>
      </ul>
    </div>
</div>
<h1><?php echo $row_RecSearchBanner['banner_title']; ?></h1>
</div>
