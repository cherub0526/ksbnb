<?php require_once('../Connections/connSQL.php'); ?>
<?php
if(isset($_POST['s_search']))
{
	if(isset($_POST['s_city']))
	header("Location:bnb_landscape_detail.php?s_search=".$_POST['s_search']."&s_city=".$_POST['s_city']);
	else
	header("Location:bnb_landscape_detail.php?s_search=".$_POST['s_search']);
}
else
{
	if(isset($_POST['s_city']))
	header("Location:bnb_landscape_detail.php?s_city=".$_POST['s_city']);
}

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



mysql_select_db($database_connSQL, $connSQL);
$query_RecCity = "SELECT * FROM zipcode WHERE City = '花蓮縣' ORDER BY Id ASC";
$RecCity = mysql_query($query_RecCity, $connSQL) or die(mysql_error());
$row_RecCity = mysql_fetch_assoc($RecCity);
$totalRows_RecCity = mysql_num_rows($RecCity);

mysql_select_db($database_connSQL, $connSQL);
$query_RecLandscape = "SELECT * FROM bnb_landscape ORDER BY l_id ASC";
$RecLandscape = mysql_query($query_RecLandscape, $connSQL) or die(mysql_error());
$row_RecLandscape = mysql_fetch_assoc($RecLandscape);
$totalRows_RecLandscape = mysql_num_rows($RecLandscape);

$colname_RecSearch = "";
if (isset($_GET['s_search'])) {
  $colname_RecSearch = "WHERE l_title LIKE '%".$_GET['s_search']."%'";
}
$zip_RecSearch = "";
if($_GET['s_city']!="") {
	if(isset($_GET['s_search'])){
	  $zip_RecSearch = " AND l_zip =".$_GET['s_city'];
	}
	else
	{
	  $zip_RecSearch = "WHERE l_zip =".$_GET['s_city'];	
	}	
}
else
{
	$zip_RecSearch = "";
}
mysql_select_db($database_connSQL, $connSQL);
$query_RecSearch = sprintf("SELECT * FROM bnb_landscape %s%s ORDER BY l_id ASC", $colname_RecSearch,$zip_RecSearch);
$RecSearch = mysql_query($query_RecSearch, $connSQL) or die(mysql_error());
$row_RecSearch = mysql_fetch_assoc($RecSearch);
$totalRows_RecSearch = mysql_num_rows($RecSearch);

if ((isset($_GET['id'])) && ($_GET['id'] != "") && (isset($_GET['delbnb']))) {
  $deleteSQL = sprintf("DELETE FROM bnb_landscape WHERE l_id=%s",
                       GetSQLValueString($_GET['id'], "int"));

  mysql_select_db($database_connSQL, $connSQL);
  $Result1 = mysql_query($deleteSQL, $connSQL) or die(mysql_error());
  $deleteGoTo = "bnb_landscape_detail.php";
  header(sprintf("Location: %s", $deleteGoTo));
}


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>旅遊景點 總覽</title>
<link href="../css/admin_style.css" rel="stylesheet" type="text/css" />
<style type="text/css">
#content {
	background-color: #F3F3F3;
	float: left;
	width: 835px;
}
</style>
<script language="javascript">
function reSize(){
　　//parent.document.all.frameid.height=document.body.scrollHeight; 
　　parent.document.getElementById("frm").height=document.body.scrollHeight;
} 
window.onload=reSize;
</script>
</head>

<body>

<div id="content">
<div id="top_nav">
  <table width="835" border="0" cellpadding="0" cellspacing="0" height="28">
    <tr>
      <td width="21" background="../images/board10.gif">&nbsp;</td>
      <td width="100" background="../images/board04.gif" align="left" style="font-size:0.8em">旅遊景點 總覽</td>
      <td width="681" background="../images/board04.gif" style="font-size:0.8em"><form id="form1" name="form1" method="POST" action="bnb_landscape_detail.php" target="frm">
        <label for="a_search"></label>
        查詢：
        <label for="s_city"></label>
        <select name="s_city" id="s_city">
          <option value="">請選擇鄉鎮</option>
          <?php
do {  
?>
          <option value="<?php echo $row_RecCity['ZipCode']?>"><?php echo $row_RecCity['Area']?></option>
          <?php
} while ($row_RecCity = mysql_fetch_assoc($RecCity));
  $rows = mysql_num_rows($RecCity);
  if($rows > 0) {
      mysql_data_seek($RecCity, 0);
	  $row_RecCity = mysql_fetch_assoc($RecCity);
  }
?>
        </select>
        <input type="text" name="s_search" id="s_search" />
        <input type="submit" value="查詢" />
      </form></td>
      <td width="33" background="../images/board04.gif"><span style="font-size:0.8em; text-align:right"><a href="bnbeconomy.php" target="frm">新增</a></span></td>
    </tr>
  </table>
</div>
<?php if(isset($_GET['s_search']) || isset($_GET['s_city'])) { ?>
  <div id="content" class="cx_admin_table">
    
    <table width="835" border="0" align="center" cellpadding="1" a>
      <tr>
        <td width="139">旅遊景點 名稱</td>
        <td width="200">旅遊景點 圖片</td>
        <td>旅遊景點內容</td>
        <td width="150">旅遊景點網址</td>
        <td width="80">編輯選項</td>
      </tr>
      <?php do { ?>
        <?php if ($totalRows_RecSearch > 0) { // Show if recordset not empty ?>
          <tr>
            <td><?php echo $row_RecSearch['l_title']; ?></td>
            <td><img src="../images/landscape/<?php echo $row_RecSearch['l_images']; ?>" width="100%" /></td>
            <td><?php echo $row_RecSearch['l_text']; ?></td>
            <td width="150"><?php echo $row_RecSearch['l_url']; ?></td>
            <td width="80"><a href="bnb_landscape_update.php?id=<?php echo $row_RecSearch['l_id']; ?>" target="frm">修改</a> <a href="bnb_landscape_detail.php?delbnb=true&amp;id=<?php echo $row_RecSearch['l_id']; ?>" target="frm">刪除</a></td>
          </tr>
          <?php } // Show if recordset not empty ?>
        <?php } while ($row_RecSearch = mysql_fetch_assoc($RecSearch)); ?>
    </table>
    <table border="0" align="center">
      <tr>
        <td><?php if ($pageNum_RecSearch > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_RecSearch=%d%s", $currentPage, 0, $queryString_RecSearch); ?>">第一頁</a>
          <?php } // Show if not first page ?></td>
        <td><?php if ($pageNum_RecSearch > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_RecSearch=%d%s", $currentPage, max(0, $pageNum_RecSearch - 1), $queryString_RecSearch); ?>">上一頁</a>
          <?php } // Show if not first page ?></td>
        <td><?php if ($pageNum_RecSearch < $totalPages_RecSearch) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_RecSearch=%d%s", $currentPage, min($totalPages_RecSearch, $pageNum_RecSearch + 1), $queryString_RecSearch); ?>">下一頁</a>
          <?php } // Show if not last page ?></td>
        <td><?php if ($pageNum_RecSearch < $totalPages_RecSearch) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_RecSearch=%d%s", $currentPage, $totalPages_RecSearch, $queryString_RecSearch); ?>">最後一頁</a>
          <?php } // Show if not last page ?></td>
      </tr>
    </table>
    <p align="center">
      <input type="button" onclick="window.history.back();" value="回上一頁"/></p>
  </div>
<?php } else { ?>
<div id="content" class="cx_admin_table">
<table width="835" border="0" align="center" cellpadding="1" a>
      <tr>
        <td width="139">旅遊景點 名稱</td>
        <td width="200">旅遊景點 圖片</td>
        <td>旅遊景點內容</td>
        <td width="150">旅遊景點網址</td>
        <td width="80">編輯選項</td>
      </tr>
      <?php do { ?>
          <?php if ($totalRows_RecLandscape > 0) { // Show if recordset not empty ?>
  <tr>
    <td><?php echo $row_RecLandscape['l_title']; ?></td>
    <td><img src="../images/landscape/<?php echo $row_RecLandscape['l_images']; ?>" width="100%" /></td>
    <td><?php echo $row_RecLandscape['l_text']; ?></td>
    <td width="150"><?php echo $row_RecLandscape['l_url']; ?></td>
    <td width="80"><a href="bnb_landscape_update.php?id=<?php echo $row_RecLandscape['l_id']; ?>" target="frm">修改</a> <a href="bnb_landscape_detail.php?delbnb=true&amp;id=<?php echo $row_RecLandscape['l_id']; ?>" target="frm">刪除</a></td>
  </tr>
  <?php } // Show if recordset not empty ?>
<?php } while ($row_RecLandscape = mysql_fetch_assoc($RecLandscape)); ?>
    </table>
    <table border="0" align="center">
      <tr>
        <td><?php if ($pageNum_RecLandscape > 0) { // Show if not first page ?>
            <a href="<?php printf("%s?pageNum_RecLandscape=%d%s", $currentPage, 0, $queryString_RecLandscape); ?>">第一頁</a>
        <?php } // Show if not first page ?></td>
        <td><?php if ($pageNum_RecLandscape > 0) { // Show if not first page ?>
            <a href="<?php printf("%s?pageNum_RecLandscape=%d%s", $currentPage, max(0, $pageNum_RecLandscape - 1), $queryString_RecLandscape); ?>">上一頁</a>
        <?php } // Show if not first page ?></td>
        <td><?php if ($pageNum_RecLandscape < $totalPages_RecLandscape) { // Show if not last page ?>
            <a href="<?php printf("%s?pageNum_RecLandscape=%d%s", $currentPage, min($totalPages_RecLandscape, $pageNum_RecLandscape + 1), $queryString_RecLandscape); ?>">下一頁</a>
        <?php } // Show if not last page ?></td>
        <td><?php if ($pageNum_RecLandscape < $totalPages_RecLandscape) { // Show if not last page ?>
            <a href="<?php printf("%s?pageNum_RecLandscape=%d%s", $currentPage, $totalPages_RecLandscape, $queryString_RecLandscape); ?>">最後一頁</a>
        <?php } // Show if not last page ?></td>
      </tr>
    </table>
<p align="center">
  <input type="button" onclick="window.history.back();" value="回上一頁"/></p>
  <?php } ?>
  </div>
</div>

</body>
</html>