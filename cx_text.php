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


//地區搜尋
$colname_RecSearch = "";
if ($_POST['b_zip']!="") {
  $colname_RecSearch = "WHERE level2_id =".$_POST['b_zip'];
}


//低價搜尋
$lowprice_RecSearch = "";
if ($_POST['lowprice']!="") {
	if ($_POST['b_zip']!="") {	
    $lowprice_RecSearch = " AND price >=".$_POST['lowprice'];
  }
  else
  {
   $lowprice_RecSearch = "WHERE price >=".$_POST['lowprice'];
 }
}
else


//高價搜尋
  $highprice_RecSearch = "";
if ($_POST['highprice']!="") 
{
  if ($_POST['b_zip']!="" || $_POST['lowprice']!="") {
    $highprice_RecSearch = " AND price <=".$_POST['highprice'];
  }
  else
  {
    $highprice_RecSearch = "WHERE price <=".$_POST['highprice'];
  }
}


//關鍵字搜尋
$key_RecSearch = "";
if ($_POST['key']!="") {
	if ($_POST['b_zip']!="" || $_POST['lowprice']!="" || $_POST['highprice']!="") {
   $key_RecSearch = " AND n_name LIKE '%".$_POST['key']."%'";
 }
 else
 {
  $key_RecSearch = "WHERE n_name LIKE '%".$_POST['key']."%'";
}
}

//城市搜尋
$city_RecSearch="";
if ($_POST['city']!="") {
	if ($_POST['b_zip']!="" || $_POST['lowprice']!="" || $_POST['highprice']!="" || $_POST['key']!="") {
   $city_RecSearch = " AND level1_id = "."'".$_POST['city']."'";
 }
 else
 {
  $city_RecSearch = "WHERE level1_id = "."'".$_POST['city']."'";
}
}

mysql_select_db($database_ksnews3, $ksnews3);
$query_RecSearch = sprintf("SELECT * FROM product %s%s%s%s%s ORDER BY n_id ASC",$colname_RecSearch,$lowprice_RecSearch,$highprice_RecSearch,$key_RecSearch,$city_RecSearch);
$RecSearch = mysql_query($query_RecSearch, $ksnews3) or die(mysql_error());
$row_RecSearch = mysql_fetch_assoc($RecSearch);
$totalRows_RecSearch = mysql_num_rows($RecSearch);

mysql_select_db($database_ksnews3, $ksnews3);
$query_RecHualien = "SELECT * FROM product ORDER BY n_id ASC";
$RecHualien = mysql_query($query_RecHualien, $ksnews3) or die(mysql_error());
$row_RecHualien = mysql_fetch_assoc($RecHualien);
$totalRows_RecHualien = mysql_num_rows($RecHualien);
?>
<?php if (isset($_POST['b_zip']) || isset($_POST['lowprice']) || isset($_POST['highprice']) || isset($_POST['key'])) { 
  if($totalRows_RecSearch==0){ ?>
  <h1 align="center">沒有找尋到符合的資料！</h1>
  <?php } else { ?>
  <?php if ($totalRows_RecSearch > 0) { // Show if recordset not empty ?>
  <?php do { ?>

  <?php if($row_RecSearch['b_url']!=""){ ?>
  <div id="cx_text">
    <div class="item">  
      <a href="<?php echo $row_RecSearch['b_url']; ?>" title="<?php echo $row_RecSearch['n_name']; ?>"><img src="timthumb.php?src=images/bnb/<?php echo $row_RecSearch['big_pic']; ?>&w=130&h=98"/></a>
    </div>
  </div>      
  <?php } else { ?>
  <div id="cx_text">
    <div class="item">  
      <a href="cx_bnb_detail.php?id=<?php echo $row_RecSearch['n_id']; ?>&amp;hits=true" title="<?php echo $row_RecSearch['n_name']; ?>"><img src="timthumb.php?src=images/bnb/<?php echo $row_RecSearch['big_pic']; ?>&w=130&h=98"/></a> 
    </div>
  </div>    
  <?php }} while ($row_RecSearch = mysql_fetch_assoc($RecSearch));   ?>
  <?php }} // Show if recordset not empty ?>

  <?php }else{  ?>

  <?php do { ?>

  <?php if($row_RecHualien['b_url']!=""){ ?>
  <div id="cx_text">
    <div class="item">        
      <a href="<?php echo $row_RecHualien['b_url']; ?>" title="<?php echo $row_RecHualien['n_name']; ?>"><img src="timthumb.php?src=images/bnb/<?php echo $row_RecHualien['big_pic']; ?>&w=130&h=98"/></a>
    </div>
  </div>
  <?php } else { ?>
  <div id="cx_text">
    <div class="item"> 
      <a href="cx_bnb_detail.php?id=<?php echo $row_RecHualien['n_id']; ?>&amp;hits=true" title="<?php echo $row_RecHualien['n_name']; ?>"><img src="timthumb.php?src=images/bnb/<?php echo $row_RecHualien['big_pic']; ?>&w=130&h=98"/></a>	
    </div>
  </div>    
  <?php }} while ($row_RecHualien = mysql_fetch_assoc($RecHualien)); } ?>
<?php
mysql_free_result($RecHualien);
mysql_free_result($RecSearch);
?>
