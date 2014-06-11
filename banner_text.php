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
//table ad_show

//$b_level_RecBanner = "B2"; // 廣告變數(level)
//$b_position_RecBanner = "B"; // 廣告位置變數(position)A~Z
$b_totalshow = 30;//顯示數量
//$b_cookie_time = 60; // cookie 紀錄時間(s)

$array = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");	
foreach($array as $key)
{
	if($b_position_RecBanner == $key)
	{
		$key .= $b_level_RecBanner;
		if (isset($_COOKIE[$key])) {
		  $b_cookie_RecBanner = $_COOKIE[$key];
		}
		else{
		  $b_cookie_RecBanner = "0";
		}
	}
}

if( isset($_POST['b_zip']) && $_POST['b_zip'] != "")
{
	$colname_zip = " AND level = ".$_POST['b_zip'];
}
else
{
	$colname_zip = "";
}

mysql_select_db($database_ksnews3, $ksnews3);
$query_RecBanner = sprintf("SELECT * FROM ad_show WHERE class = %s AND position = %s %s AND `on` = 0 AND banner_id > %s GROUP BY banner_id ORDER BY id ASC LIMIT %s", GetSQLValueString($b_level_RecBanner, "text"),GetSQLValueString($b_position_RecBanner, "text"),$colname_zip,GetSQLValueString($b_cookie_RecBanner, "int"),GetSQLValueString($b_totalshow, "int"));
$RecBanner = mysql_query($query_RecBanner, $ksnews3) or die(mysql_error());
$row_RecBanner = mysql_fetch_assoc($RecBanner);
$totalRows_RecBanner = mysql_num_rows($RecBanner);
if($totalRows_RecBanner == 0)
{
	mysql_select_db($database_ksnews3, $ksnews3);
	$query_RecBanner = sprintf("SELECT * FROM ad_show WHERE class = %s AND position = %s %s AND `on` = 0 GROUP BY banner_id ORDER BY id ASC LIMIT %s", GetSQLValueString($b_level_RecBanner, "text"),GetSQLValueString($b_position_RecBanner, "text"),$colname_zip,GetSQLValueString($b_totalshow, "int"));
	$RecBanner = mysql_query($query_RecBanner, $ksnews3) or die(mysql_error());
	$row_RecBanner = mysql_fetch_assoc($RecBanner);
	$totalRows_RecBanner = mysql_num_rows($RecBanner);
}
?>
<?php if($totalRows_RecBanner > 0) { ?>
<div style="width:693px; height:100px; background-color:#FFF; border: 1px solid #666 ">
<?php do {    
	$banner_RecAd = $row_RecBanner['banner_id'];
	mysql_select_db($database_ksnews3, $ksnews3);
	$query_RecAd = sprintf("SELECT * FROM banner WHERE banner_id = %s AND CURDATE() <= DATE_ADD( `startdate`  , INTERVAL `downdate` DAY ) ",GetSQLValueString($banner_RecAd,"int"));
	$RecAd = mysql_query($query_RecAd, $ksnews3) or die(mysql_error());
	$row_RecAd = mysql_fetch_assoc($RecAd);
	$totalRows_RecAd = mysql_num_rows($RecAd);
	
	mysql_select_db($database_ksnews3, $ksnews3);
	$query_RecDetail = sprintf("SELECT * FROM banner_detail WHERE adv_id = %s", GetSQLValueString($banner_RecAd,"int"));
	$RecDetail = mysql_query($query_RecDetail, $ksnews3) or die(mysql_error());
	$row_RecDetail = mysql_fetch_assoc($RecDetail);
	$totalRows_RecDetail = mysql_num_rows($RecDetail);
	
	if($totalRows_RecAd>0){
?>
<?php if($row_RecAd['banner_url']!=""){?>
<a href="<?php echo $row_RecAd['banner_url'];?>" title="<?php echo $row_RecAd['banner_title'];?>" target="_new"><span style="display:inline-block; width:130px"><?php echo mb_substr($row_RecAd['banner_title'],0,15,'utf-8'); if(strlen($row_RecAd['banner_title'])>15) echo "...";?></span></a>
<?php } else { ?>
<?php if($totalRows_RecDetail>0) {?>
  <a href="banner_detail.php?id=<?php echo $row_RecAd['banner_id'];?>&amp;hits=true" title="<?php echo $row_RecAd['banner_title'];?>"><span style="display:inline-block; width:130px"><?php echo mb_substr($row_RecAd['banner_title'],0,15,'utf-8'); if(strlen($row_RecAd['banner_title'])>15) echo "...";?></span></a>
<?php } else { ?>
  <a target="_new" href="banner_detail_pic.php?id=<?php echo $row_RecAd['banner_id'];?>&amp;hits=true" title="<?php echo $row_RecAd['banner_title'];?>">
  <span style="display:inline-block; width:130px"><?php echo mb_substr($row_RecAd['banner_title'],0,15,'utf-8'); if(strlen($row_RecAd['banner_title'])>15) echo "...";?></span></a>  
<?php }} ?>
<?php
	$array = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");	
	foreach($array as $key)
	{
		if($b_position_RecBanner == $key)
		{
			$key .= $b_level_RecBanner;
			setcookie($key,$row_RecBanner['banner_id'],time()+ $b_cookie_time);			
		}
	}
?>	
<?php }} while($row_RecBanner = mysql_fetch_assoc($RecBanner));  ?>
</div>
<?php 
$array = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");	
foreach($array as $key)
{
	if($b_position_RecBanner == $key)
	{
		if($totalRows_RecBanner != $b_totalshow)
		{
			$key .= $b_level_RecBanner;
			setcookie($key,"0",time()+ $b_cookie_time);
			//unset($_COOKIE['banenr']);
		}
	}
}
}
?>

<?php
mysql_free_result($RecBanner);
//mysql_free_result($RecAd);
?>
