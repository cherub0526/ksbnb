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

$currentPage = $_SERVER["PHP_SELF"];

if ((isset($_GET['id'])) && ($_GET['id'] != "") && (isset($_GET['delbanner']))) {
  $deleteSQL = sprintf("DELETE FROM ad_show WHERE id=%s",
                       GetSQLValueString($_GET['id'], "int"));

  mysql_select_db($database_ksnews3, $ksnews3);
  $Result1 = mysql_query($deleteSQL, $ksnews3) or die(mysql_error());

  $deleteGoTo = "admin_banner.php";
  header(sprintf("Location: %s", $deleteGoTo));
}

$maxRows_RecShow = 10;
$pageNum_RecShow = 0;
if (isset($_GET['pageNum_RecShow'])) {
  $pageNum_RecShow = $_GET['pageNum_RecShow'];
}
$startRow_RecShow = $pageNum_RecShow * $maxRows_RecShow;

mysql_select_db($database_ksnews3, $ksnews3);
$query_RecShow = sprintf("SELECT * FROM ad_show ORDER BY id DESC");
$query_limit_RecShow = sprintf("%s LIMIT %d, %d", $query_RecShow, $startRow_RecShow, $maxRows_RecShow);
$RecShow = mysql_query($query_limit_RecShow, $ksnews3) or die(mysql_error());
$row_RecShow = mysql_fetch_assoc($RecShow);

if (isset($_GET['totalRows_RecShow'])) {
  $totalRows_RecShow = $_GET['totalRows_RecShow'];
} else {
  $all_RecShow = mysql_query($query_RecShow);
  $totalRows_RecShow = mysql_num_rows($all_RecShow);
}
$totalPages_RecShow = ceil($totalRows_RecShow/$maxRows_RecShow)-1;

mysql_select_db($database_ksnews3, $ksnews3);
$query_RecPosition = "SELECT * FROM `banner_position`";
$RecPosition = mysql_query($query_RecPosition, $ksnews3) or die(mysql_error());
$row_RecPosition = mysql_fetch_assoc($RecPosition);
$totalRows_RecPosition = mysql_num_rows($RecPosition);

mysql_select_db($database_ksnews3, $ksnews3);
$query_RecZone = "SELECT * FROM `city` ORDER BY id ASC";
$RecZone = mysql_query($query_RecZone, $ksnews3) or die(mysql_error());
$row_RecZone = mysql_fetch_assoc($RecZone);
$totalRows_RecZone = mysql_num_rows($RecZone);

$queryString_RecShow = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_RecShow") == false && 
        stristr($param, "totalRows_RecShow") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_RecShow = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_RecShow = sprintf("&totalRows_RecShow=%d%s", $totalRows_RecShow, $queryString_RecShow);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>廣告管理</title>

<link href="../css/admin_manage.css" rel="stylesheet" type="text/css" />
<script src="../Scripts/swfobject_modified.js" type="text/javascript"></script>
<script language="javascript">
function reSize(){
　　//parent.document.all.frameid.height=document.body.scrollHeight; 
　　parent.document.getElementById("frm").height=document.body.scrollHeight;
} 
window.onload=reSize;
function tfm_confirmLink(message) { //v1.0
	if(message == "") message = "Ok to continue?";	
	document.MM_returnValue = confirm(message);
}
</script>
</head>

<body>
<div id="body">
<div id="top_nav">
  <table width="821" border="0" cellpadding="0" cellspacing="0" height="28">
    <tr>
      <td width="23" background="../images/board10.gif">&nbsp;</td>
      <td width="144" background="../images/board04.gif" align="left" style="font-size:0.8em">上架圖文廣告管理區 </td>
      <td width="650" background="../images/board04.gif"><a href="admin_banner_addswf.php" target="frm"><img src="../images/icon_addswf.gif" width="61" height="19" alt="增加SWF動畫廣告" /></a><a href="admin_banner_add.php" target="frm"><img src="../images/icon_addpic.gif" width="61" height="19" alt="增加圖像廣告" /></a><a href="admin_banner_add_newsdetail.php" target="frm"><img src="../images/icon_addfont.gif" width="61" height="19" alt="增加跑馬燈廣告" /></a><a href="admin_banner_add_newsClass.php" target="frm"><img src="../images/icon_addpic_news1.gif" width="113" height="19" alt="新聞分類整批增加" /></a><a href="admin_banner_add_newsdetails.php" target="frm"><img src="../images/icon_addpic_news2.gif" width="113" height="19" alt="新聞內文整批增加" /></a>共：<?php echo $totalRows_RecShow ; ?> 筆</td>
      <td width="10" background="../images/board05.gif">&nbsp;</td>
    </tr>
  </table>
</div>
<div align="center" id="content">
    <table width="821" border="0" cellpadding="0">
      <tr bordercolor="#000066" >
        <td width="46" class="cx_admin_table"><div align="center">編號</div></td>
        <td width="62" class="cx_admin_table"><div align="center">標題</div></td>
        <td width="180" class="cx_admin_table"><div align="center">圖片</div></td>
        <td width="61" class="cx_admin_table"><div align="center">商家</div></td>
        <td width="76" class="cx_admin_table"><div align="center">上架日</div></td>
        <td width="88" class="cx_admin_table"><div align="center">上架期限</div></td>
        <td width="107" class="cx_admin_table"><div align="center">廣告位置/區塊</div></td>
        
        <td width="63" class="cx_admin_table"><div align="center">排序</div></td>
        <td width="80" class="cx_admin_table"><div align="center">編輯</div></td>
      </tr>
      <?php do { ?>
      <?php 
	  mysql_select_db($database_ksnews3, $ksnews3);
	  $query_RecBanner = sprintf("SELECT * FROM banner WHERE banner_id = %s",GetSQLValueString($row_RecShow['banner_id'],"int"));
	  $RecBanner = mysql_query($query_RecBanner ,$ksnews3) or die(mysql_error());
	  $row_RecBanner = mysql_fetch_assoc($RecBanner);
	  ?>
        <tr style="text-align:center">
          <td class="cx_admin_table"><?php echo $row_RecBanner['banner_id']; ?></td>
          <td class="cx_admin_table"><?php echo $row_RecBanner['banner_title']; ?></td>
          <td class="cx_admin_table">
          <?php if(isset($row_RecBanner['banner_pic'])) {
		  if($row_RecBanner['banner_type'] == 0) {  
			  ?>
            <object id="FlashID<?php echo $row_RecBanner['id']; ?>" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="100%">
                <param name="movie" value="../images/ksad/<?php echo $row_RecBanner['banner_pic'];?>" />
                <param name="quality" value="high" />
                <param name="wmode" value="opaque" />
                <param name="swfversion" value="8.0.35.0" />
                <!-- 此 param 標籤會提示使用 Flash Player 6.0 r65 和更新版本的使用者下載最新版本的 Flash Player。如果您不想讓使用者看到這項提示，請將其刪除。 -->
                <param name="expressinstall" value="../Scripts/expressInstall.swf" />
                <!-- 下一個物件標籤僅供非 IE 瀏覽器使用。因此，請使用 IECC 將其自 IE 隱藏。 -->
                <!--[if !IE]>-->
                <object type="application/x-shockwave-flash" data="../images/ksad/31401.swf" width="100" height="100">
                  <!--<![endif]-->
                  <param name="quality" value="high" />
                  <param name="wmode" value="opaque" />
                  <param name="swfversion" value="8.0.35.0" />
                  <param name="expressinstall" value="../Scripts/expressInstall.swf" />
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
			swfobject.registerObject("FlashID<?php echo $row_RecBanner['id']; ?>");
			</script>
<?php } else { ?>
          <img src="../images/ksad/<?php echo $row_RecBanner['banner_pic']; ?>" width="100%" /><?php }} else { echo "沒有圖片!!"; }?> </td>
          <td class="cx_admin_table"><?php echo $row_RecBanner['commerce']; ?></td>
          <td class="cx_admin_table"><?php echo $row_RecBanner['startdate']; ?></td>
          <td class="cx_admin_table"><?php echo $row_RecBanner['downdate']; ?> 天</td>
          <td class="cx_admin_table"><label for="b_position"></label>
            <select name="b_position" id="b_position" disabled="disabled">
              <?php
do {  
?>
              <option value="<?php echo $row_RecPosition['chained']?>"<?php if (!(strcmp($row_RecPosition['chained'], $row_RecBanner['banner_position']))) {echo "selected=\"selected\"";} ?>><?php echo $row_RecPosition['type_name']?></option>
              <?php
} while ($row_RecPosition = mysql_fetch_assoc($RecPosition));
  $rows = mysql_num_rows($RecPosition);
  if($rows > 0) {
      mysql_data_seek($RecPosition, 0);
	  $row_RecPosition = mysql_fetch_assoc($RecPosition);
  }
?>
            </select>
            <label for="b_zone"></label>
            <select name="b_zone" id="b_zone" disabled="disabled">
              <?php
do {  
?>
              <option value="<?php echo $row_RecZone['c_zone']?>"<?php if (!(strcmp($row_RecZone['c_zone'].$row_RecZone['c_zip'], $row_RecBanner['banner_position'].$row_RecBanner['class']))) {echo "selected=\"selected\"";} ?>><?php echo $row_RecZone['c_name']?></option>
              <?php
} while ($row_RecZone = mysql_fetch_assoc($RecZone));
  $rows = mysql_num_rows($RecZone);
  if($rows > 0) {
      mysql_data_seek($RecZone, 0);
	  $row_RecZone = mysql_fetch_assoc($RecZone);
  }
?>
          </select></td>
          
          <td class="cx_admin_table"><?php echo $row_RecBanner['sorting']; ?></td>
          <td class="cx_admin_table"><a href="admin_banner_update.php?id=<?php echo $row_RecBanner['banner_id'];?>">編輯</a> <a href="admin_banner.php?delbanner=true&amp;id=<?php echo $row_RecShow['id']; ?>" onclick="tfm_confirmLink('確定要刪除這筆資料？');return document.MM_returnValue" >刪除</a><br/>
          <a href="banner_detail_add.php?id=<?php echo $row_RecBanner['banner_id'];?>">新增詳細資訊</a></td>
        </tr>
        <?php } while ($row_RecShow = mysql_fetch_assoc($RecShow)); ?>
    </table>
  </div>
</div><br />


<table border="0" align="center">
  <tr>
    <td><?php if ($pageNum_RecShow > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_RecShow=%d%s", $currentPage, 0, $queryString_RecShow); ?>" target="frm">第一頁</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_RecShow > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_RecShow=%d%s", $currentPage, max(0, $pageNum_RecShow - 1), $queryString_RecShow); ?>" target="frm">上一頁</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_RecShow < $totalPages_RecShow) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_RecShow=%d%s", $currentPage, min($totalPages_RecShow, $pageNum_RecShow + 1), $queryString_RecShow); ?>" target="frm">下一頁</a>
        <?php } // Show if not last page ?></td>
    <td><?php if ($pageNum_RecShow < $totalPages_RecShow) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_RecShow=%d%s", $currentPage, $totalPages_RecShow, $queryString_RecShow); ?>" target="frm">最後一頁</a>
        <?php } // Show if not last page ?></td>
  </tr>
</table>

</body>
</html>
<?php
mysql_free_result($RecShow);

mysql_free_result($RecPosition);

mysql_free_result($RecZone);
?>
