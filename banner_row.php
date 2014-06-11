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
/*
$b_level_RecBanner = "182"; // 廣告變數(level)
$b_position_RecBanner = "A"; // 廣告位置變數(position)A~Z
$b_totalshow = 1;//顯示數量
$b_cookie_time = 60; // cookie 紀錄時間(s)
*/
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
mysql_select_db($database_ksnews3, $ksnews3);
$query_RecBanner = sprintf("SELECT * FROM ad_show WHERE class = %s AND position = %s AND `on` = 0 AND banner_id > %s ORDER BY id ASC LIMIT %s", GetSQLValueString($b_level_RecBanner, "text"),GetSQLValueString($b_position_RecBanner, "text"),GetSQLValueString($b_cookie_RecBanner, "int"),GetSQLValueString($b_totalshow, "int"));
$RecBanner = mysql_query($query_RecBanner, $ksnews3) or die(mysql_error());
$row_RecBanner = mysql_fetch_assoc($RecBanner);
$totalRows_RecBanner = mysql_num_rows($RecBanner);
if($totalRows_RecBanner == 0)
{
	mysql_select_db($database_ksnews3, $ksnews3);
	$query_RecBanner = sprintf("SELECT * FROM ad_show WHERE class = %s AND position = %s AND `on` = 0 ORDER BY id ASC LIMIT %s", GetSQLValueString($b_level_RecBanner, "text"),GetSQLValueString($b_position_RecBanner, "text"),GetSQLValueString($b_totalshow, "int"));
	$RecBanner = mysql_query($query_RecBanner, $ksnews3) or die(mysql_error());
	$row_RecBanner = mysql_fetch_assoc($RecBanner);
	$totalRows_RecBanner = mysql_num_rows($RecBanner);
}

?>
<script src="Scripts/swfobject_modified.js" type="text/javascript"></script>

<?php do { ?>
<?php     
	$banner_RecAd = $row_RecBanner['banner_id'];
	mysql_select_db($database_ksnews3, $ksnews3);
	$query_RecAd = sprintf("SELECT * FROM banner WHERE banner_id = %s AND CURDATE() <= DATE_ADD( `startdate`  , INTERVAL `downdate` DAY )",GetSQLValueString($banner_RecAd,"int"));
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
<?php if($row_RecAd['banner_type'] == '0'){ ?>
<!-- 廣告擺放區域-->
<object id="FlashID" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="694" height="145">
  <param name="movie" value="images/ksad/<?php echo $row_RecAd['banner_pic']; ?>" />
  <param name="quality" value="high" />
  <param name="wmode" value="opaque" />
  <param name="swfversion" value="6.0.65.0" />
  <!-- 此 param 標籤會提示使用 Flash Player 6.0 r65 和更新版本的使用者下載最新版本的 Flash Player。如果您不想讓使用者看到這項提示，請將其刪除。 -->
  <param name="expressinstall" value="Scripts/expressInstall.swf" />
  <!-- 下一個物件標籤僅供非 IE 瀏覽器使用。因此，請使用 IECC 將其自 IE 隱藏。 -->
  <!--[if !IE]>-->
  <object type="application/x-shockwave-flash" data="images/ksad/<?php echo $row_RecAd['banner_pic']; ?>" width="694" height="145">
    <!--<![endif]-->
    <param name="quality" value="high" />
    <param name="wmode" value="opaque" />
    <param name="swfversion" value="6.0.65.0" />
    <param name="expressinstall" value="Scripts/expressInstall.swf" />
    <!-- 瀏覽器會為使用 Flash Player 6.0 和更早版本的使用者顯示下列替代內容。 -->
    <div>
      <h4>這個頁面上的內容需要較新版本的 Adobe Flash Player。</h4>
      <p><a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="取得 Adobe Flash Player" width="112" height="33" /></a></p>
    </div>
    <!--[if !IE]>-->
  </object>
  <!--<![endif]-->
</object>
<script type="text/javascript">
swfobject.registerObject("FlashID-<?php echo $row_RecAd['banner_id'];?>");
</script>
<?php } else{ ?>
  <?php if($row_RecAd['banner_url']!=""){?>
  <a href="<?php echo $row_RecAd['banner_url'];?>" target="_new" title="<?php echo $row_RecAd['banner_title'];?>"><img src="images/ksad/<?php echo $row_RecAd['banner_pic']; ?>" width="693" height="150" style="margin-top:10px"/></a>
  <?php } else { ?>
  <?php if($totalRows_RecDetail>0) {?>
  <a target="_new" href="banner_detail.php?id=<?php echo $row_RecAd['banner_id'];?>&amp;hits=true" title="<?php echo $row_RecAd['banner_title'];?>">
  <img src="images/ksad/<?php echo $row_RecAd['banner_pic']; ?>" width="693" height="150" style="margin-top:10px"/></a>
  <?php } else { ?>
  <a target="_new" href="banner_detail_pic.php?id=<?php echo $row_RecAd['banner_id'];?>&amp;hits=true" title="<?php echo $row_RecAd['banner_title'];?>">
  <img src="images/ksad/<?php echo $row_RecAd['banner_pic']; ?>" width="693" height="150" style="margin-top:10px"/></a>  
<?php }}} ?>
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
?>

<?php
mysql_free_result($RecBanner);
mysql_free_result($RecAd);
?>
