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

//刪除資料
if ((isset($_GET['id'])) && ($_GET['id'] != "") && (isset($_GET['delbanner']))) {
  $deleteSQL = sprintf("DELETE FROM banner_test WHERE id=%s",
                       GetSQLValueString($_GET['id'], "int"));

  mysql_select_db($database_ksnews3, $ksnews3);
  $Result1 = mysql_query($deleteSQL, $ksnews3) or die(mysql_error());

  $deleteGoTo = "admin_bannerDow.php";
  header(sprintf("Location: %s", $deleteGoTo));
}
//讀取下架資料
$maxRows_RecBanner = 10;
$pageNum_RecBanner = 0;
if (isset($_GET['pageNum_RecBanner'])) {
  $pageNum_RecBanner = $_GET['pageNum_RecBanner'];
}
$startRow_RecBanner = $pageNum_RecBanner * $maxRows_RecBanner;

mysql_select_db($database_ksnews3, $ksnews3);
$query_RecBanner = sprintf("SELECT * FROM banner WHERE CURDATE()>=  DATE_ADD( `startdate`  , INTERVAL `downdate` DAY ) ORDER BY banner_id ASC");
$query_limit_RecBanner = sprintf("%s LIMIT %d, %d", $query_RecBanner, $startRow_RecBanner, $maxRows_RecBanner);
$RecBanner = mysql_query($query_limit_RecBanner, $ksnews3) or die(mysql_error());
$row_RecBanner = mysql_fetch_assoc($RecBanner);
if (isset($_GET['totalRows_RecBanner'])) {
  $totalRows_RecBanner = $_GET['totalRows_RecBanner'];
} else {
  $all_RecBanner = mysql_query($query_RecBanner);
  $totalRows_RecBanner = mysql_num_rows($all_RecBanner);
}
$totalPages_RecBanner = ceil($totalRows_RecBanner/$maxRows_RecBanner)-1;

//廣告位置
mysql_select_db($database_ksnews3, $ksnews3);
$query_RecPosition = "SELECT * FROM banner_position";
$RecPosition = mysql_query($query_RecPosition, $ksnews3) or die(mysql_error());
$row_RecPosition = mysql_fetch_assoc($RecPosition);
$totalRows_RecPosition = mysql_num_rows($RecPosition);

//廣告區塊
mysql_select_db($database_ksnews3, $ksnews3);
$query_RecZone = "SELECT * FROM `city`";
$RecZone = mysql_query($query_RecZone, $ksnews3) or die(mysql_error());
$row_RecZone = mysql_fetch_assoc($RecZone);
$totalRows_RecZone = mysql_num_rows($RecZone);

if((isset($_POST["b_id"])) && ($_POST["b_id"] !="")) // 重新上架部分！
{
	mysql_select_db($database_ksnews3,$ksnews3); // banner table 上架時間更新為今日
	$query_update = sprintf("UPDATE banner SET startdate = %s WHERE banner_id = %s",GetSQLValueString(date("Y-m-d"),"date"),GetSQLValueString($_POST['b_id'],"int"));
	mysql_query($query_update);
	
	$query_search = sprintf("SELECT * FROM banner WHERE banner_id = %s",GetSQLValueString($_POST['b_id'],"int")); // banner 資訊
	$result = mysql_query($query_search,$ksnews3);
	$row_search = mysql_fetch_assoc($result);
	
	//寫入到ad_show table 中
	$query_insert = sprintf("INSERT INTO ad_show (`banner_id`,`level`,`position`,`class`,`sorting`) VALUES (%s,%s,%s,%s,%s)",GetSQLValueString($row_search['banner_id'],"int"),GetSQLValueString($row_search['level'],"text"),GetSQLValueString($row_search['banner_position'],"text"),GetSQLValueString($row_search['class'],"text"),GetSQLValueString($row_search['sorting'],"int"));
	mysql_query($query_insert);
	header(sprintf("Location:admin_bannerDow.php"));
}

$queryString_RecBanner = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();

  foreach ($params as $param) {
    if (stristr($param, "pageNum_RecBanner") == false && 
        stristr($param, "totalRows_RecBanner") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_RecBanner = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_RecBanner = sprintf("&totalRows_RecBanner=%d%s", $totalRows_RecBanner, $queryString_RecBanner);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>廣告管理</title>

<link href="../css/admin_manage.css" rel="stylesheet" type="text/css" />
<script language="javascript">
function reSize(){
　　//parent.document.all.frameid.height=document.body.scrollHeight; 
　　parent.document.getElementById("frm").height=document.body.scrollHeight;
} 
window.onload=reSize;
</script>
<script type="text/javascript" src="../js/jquery-1.7.1.min.js"></script>

<script>
$(document).ready(function(){
	$("a#update").click(function(){
		var id = $(this).parents().prevAll("#id").text();
		if(confirm("確定重新上架！"))
		{
			$.ajax({
				type : "POST",
				url : "admin_bannerDow.php",
				data : 
				{
					b_id : id,
				}
			});
		}
	});
})
</script>
</head>

<body>
<div id="body">
<div id="top_nav">
  <table width="821" border="0" cellpadding="0" cellspacing="0" height="28">
    <tr>
      <td width="23" background="../images/board10.gif">&nbsp;</td>
      <td width="144" background="../images/board04.gif" align="left" style="font-size:0.8em">下架圖文廣告管理區 </td>
      <td width="650" background="../images/board04.gif"><a href="admin_banner_addswf.php" target="frm"><img src="../images/icon_addswf.gif" width="61" height="19" alt="增加SWF動畫廣告" /></a><a href="admin_banner_add.php" target="frm"><img src="../images/icon_addpic.gif" width="61" height="19" alt="增加圖像廣告" /></a><a href="admin_banner_add_newsdetail.php" target="frm"><img src="../images/icon_addfont.gif" width="61" height="19" alt="增加跑馬燈廣告" /></a><a href="admin_banner_add_newsClass.php" target="frm"><img src="../images/icon_addpic_news1.gif" width="113" height="19" alt="新聞分類整批增加" /></a><a href="admin_banner_add_newsdetails.php" target="frm"><img src="../images/icon_addpic_news2.gif" width="113" height="19" alt="新聞內文整批增加" /></a></td>
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
        <tr style="text-align:center">
          <td class="cx_admin_table" id="id"><?php echo $row_RecBanner['banner_id']; ?></td>
          <td class="cx_admin_table"><?php echo $row_RecBanner['banner_title']; ?></td>
          <td class="cx_admin_table">
          <?php if(isset($row_RecBanner['banner_pic'])) {?><img src="../images/ksad/<?php echo $row_RecBanner['banner_pic']; ?>" width="100%" /><?php } else { echo "沒有圖片!!"; }?> </td>
          <td class="cx_admin_table"><?php echo $row_RecBanner['commerce']; ?></td>
          <td class="cx_admin_table"><?php echo $row_RecBanner['startdate']; ?></td>
          <td class="cx_admin_table"><?php echo $row_RecBanner['downdate']; ?></td>
          <td class="cx_admin_table"><label for="b_position"></label>
            <select name="b_position" id="b_position" disabled="disabled" >
              <?php
do {  
?>
              <option value="<?php echo $row_RecPosition['chained']?>"<?php if (!(strcmp($row_RecPosition['chained'], $row_RecBanner['chained']))) {echo "selected=\"selected\"";} ?>><?php echo $row_RecPosition['type_name']?></option>
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
          <td class="cx_admin_table">
          <a href="#" id="update" name="update">重新上架</a> <br />
          <a href="admin_banner_update.php?id=<?php echo $row_RecBanner['id']; ?>">編輯</a> <a href="admin_banner.php?delbanner=true&amp;id=<?php echo $row_RecBanner['id']; ?>">刪除</a></td>
        </tr>
        <?php } while ($row_RecBanner = mysql_fetch_assoc($RecBanner)); ?>
    </table>
  </div>
</div><br />


<table border="0" align="center">
  <tr>
    <td><?php if ($pageNum_RecBanner > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_RecBanner=%d%s", $currentPage, 0, $queryString_RecBanner); ?>" target="frm">第一頁</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_RecBanner > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_RecBanner=%d%s", $currentPage, max(0, $pageNum_RecBanner - 1), $queryString_RecBanner); ?>" target="frm">上一頁</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_RecBanner < $totalPages_RecBanner) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_RecBanner=%d%s", $currentPage, min($totalPages_RecBanner, $pageNum_RecBanner + 1), $queryString_RecBanner); ?>" target="frm">下一頁</a>
        <?php } // Show if not last page ?></td>
    <td><?php if ($pageNum_RecBanner < $totalPages_RecBanner) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_RecBanner=%d%s", $currentPage, $totalPages_RecBanner, $queryString_RecBanner); ?>" target="frm">最後一頁</a>
        <?php } // Show if not last page ?></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($RecBanner);

mysql_free_result($RecPosition);

mysql_free_result($RecZone);
?>
