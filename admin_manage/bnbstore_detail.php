<?php require_once('../Connections/ksnews3.php'); ?>
<?php
if(isset($_POST['s_search']) || isset($_POST['s_city']) || isset($_POST['b_zip'])||isset($_POST['type']))
{
	header("Location:bnbstore_detail.php?s_search=".$_POST['s_search']."&s_city=".$_POST['s_city']."&b_zip=".$_POST['b_zip']."&type=".$_POST['type']);
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

$currentPage = $_SERVER["PHP_SELF"];

if ((isset($_GET['id'])) && ($_GET['id'] != "") && (isset($_GET['delbnb']))) {
  $deleteSQL = sprintf("DELETE FROM product WHERE n_id=%s",
                       GetSQLValueString($_GET['id'], "int"));

  mysql_select_db($database_ksnews3, $ksnews3);
  $Result1 = mysql_query($deleteSQL, $ksnews3) or die(mysql_error());

  $deleteGoTo = "bnbstore_detail.php";
  header(sprintf("Location: %s", $deleteGoTo));
}

$maxRows_RecBnb = 10;
$pageNum_RecBnb = 0;
if (isset($_GET['pageNum_RecBnb'])) {
  $pageNum_RecBnb = $_GET['pageNum_RecBnb'];
}
$startRow_RecBnb = $pageNum_RecBnb * $maxRows_RecBnb;

mysql_select_db($database_ksnews3, $ksnews3);
$query_RecBnb = "SELECT * FROM product ORDER BY n_id ASC";
$query_limit_RecBnb = sprintf("%s LIMIT %d, %d", $query_RecBnb, $startRow_RecBnb, $maxRows_RecBnb);
$RecBnb = mysql_query($query_limit_RecBnb, $ksnews3) or die(mysql_error());
$row_RecBnb = mysql_fetch_assoc($RecBnb);

if (isset($_GET['totalRows_RecBnb'])) {
  $totalRows_RecBnb = $_GET['totalRows_RecBnb'];
} else {
  $all_RecBnb = mysql_query($query_RecBnb);
  $totalRows_RecBnb = mysql_num_rows($all_RecBnb);
}
$totalPages_RecBnb = ceil($totalRows_RecBnb/$maxRows_RecBnb)-1;

$maxRows_RecSearch = 10;
$pageNum_RecSearch = 0;
if (isset($_GET['pageNum_RecSearch'])) {
  $pageNum_RecSearch = $_GET['pageNum_RecSearch'];
}
$startRow_RecSearch = $pageNum_RecSearch * $maxRows_RecSearch;

$colname_RecSearch = "";
if ($_GET['s_search']!="") {
  $colname_RecSearch = "WHERE n_name LIKE '%".$_GET['s_search']."%'";
}

$city_RecSearch = "";
if($_GET['s_city']!="") {
	if($_GET['s_search']!=""){
	  $city_RecSearch = " AND level1_id =".$_GET['s_city'];
	}
	else
	{
	  $city_RecSearch = "WHERE level1_id =".$_GET['s_city'];	
	}	
}
else
{
	$city_RecSearch = "";
}

$zip_RecSearch = "";
if($_GET['b_zip']!="") {
	if($_GET['s_search']!="" || $_GET['s_city']!=""){
	  $zip_RecSearch = " AND level2_id =".$_GET['b_zip'];
	}
	else
	{
	  $zip_RecSearch = "WHERE level2_id =".$_GET['b_zip'];	
	}	
}
else
{
	$zip_RecSearch = "";
}

$type_RecSearch = "";
if($_GET['type']!="") {
	if($_GET['s_search']!="" || $_GET['s_city']!="" || $_GET['b_zip']!=""){
	  $type_RecSearch = " AND ".$_GET['type'] . "=1";
	}
	else
	{
	  $type_RecSearch = "WHERE ".$_GET['type'] . "=1";
	}	
}
else
{
	$type_RecSearch = "";
}

mysql_select_db($database_ksnews3, $ksnews3);
$query_RecSearch = sprintf("SELECT * FROM product %s%s%s%s ORDER BY n_id ASC", $colname_RecSearch,$city_RecSearch,$zip_RecSearch,$type_RecSearch);
$query_limit_RecSearch = sprintf("%s LIMIT %d, %d", $query_RecSearch, $startRow_RecSearch, $maxRows_RecSearch);
$RecSearch = mysql_query($query_limit_RecSearch, $ksnews3) or die(mysql_error());
$row_RecSearch = mysql_fetch_assoc($RecSearch);

if (isset($_GET['totalRows_RecSearch'])) {
  $totalRows_RecSearch = $_GET['totalRows_RecSearch'];
} else {
  $all_RecSearch = mysql_query($query_RecSearch);
  $totalRows_RecSearch = mysql_num_rows($all_RecSearch);
}
$totalPages_RecSearch = ceil($totalRows_RecSearch/$maxRows_RecSearch)-1;

mysql_select_db($database_ksnews3, $ksnews3);
$query_RecCity = "SELECT * FROM level1 ORDER BY level_id ASC";
$RecCity = mysql_query($query_RecCity, $ksnews3) or die(mysql_error());
$row_RecCity = mysql_fetch_assoc($RecCity);
$totalRows_RecCity = mysql_num_rows($RecCity);

$queryString_RecBnb = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_RecBnb") == false && 
        stristr($param, "totalRows_RecBnb") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_RecBnb = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_RecBnb = sprintf("&totalRows_RecBnb=%d%s", $totalRows_RecBnb, $queryString_RecBnb);

$queryString_RecSearch = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_RecSearch") == false && 
        stristr($param, "totalRows_RecSearch") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_RecSearch = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_RecSearch = sprintf("&totalRows_RecSearch=%d%s", $totalRows_RecSearch, $queryString_RecSearch);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>民宿 總覽</title>
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
<script type="text/javascript" src="../js/jquery-1.7.1.min.js"></script>
<script type="text/javascript">
            $(document).ready(function(){
                //利用jQuery的ajax把縣市編號(CNo)傳到Town_ajax.php把相對應的區域名稱回傳後印到選擇區域(鄉鎮)下拉選單
                $('#s_city').change(function(){
                    var CNo= $('#s_city').val();
                    $.ajax({
                        type: "POST",
                        url: 'Town_ajax.php',
                        cache: false,
                        data:'city='+CNo,
                        error: function(){
                            alert('Ajax request 發生錯誤');
                        },
                        success: function(data){
                            $('#b_zip').html(data);
                        }
                    });
                });
            });        
</script>
</head>

<body>
<div id="content">
<div id="top_nav">
  <table width="835" border="0" cellpadding="0" cellspacing="0" height="28">
    <tr>
      <td width="21" background="../images/board10.gif">&nbsp;</td>
      <td width="100" background="../images/board04.gif" align="left" style="font-size:0.8em">民宿 總覽</td>
      <td width="681" background="../images/board04.gif" style="font-size:0.8em"><form id="form1" name="form1" method="POST" action="bnbstore_detail.php" target="frm" accept-charset="utf8" >
        <label for="a_search"></label>
        查詢：
        <label for="s_city"></label>
        <select name="s_city" id="s_city">
          <option value="">請選擇鄉鎮</option>
          <?php
do {  
if($row_RecCity['name'] != ""){
?>
          <option value="<?php echo $row_RecCity['level_id']?>"><?php echo $row_RecCity['name']?></option>
          <?php
}} while ($row_RecCity = mysql_fetch_assoc($RecCity));
  $rows = mysql_num_rows($RecCity);
  if($rows > 0) {
      mysql_data_seek($RecCity, 0);
	  $row_RecCity = mysql_fetch_assoc($RecCity);
  }
?>
        </select>
        <select name="b_zip" id="b_zip">  
        </select>
        <select name="type" id="type">
          <option value="">特殊優惠選擇</option>
          <option value="v_id">精選民宿</option>
          <option value="hot">超值民宿</option>
        </select>
        <input type="text" name="s_search" id="s_search" />
        <input type="submit" value="查詢" />
      </form></td>
      <td width="33" background="../images/board04.gif"><span style="font-size:0.8em; text-align:right"><a href="bnbadd.php" target="frm">新增</a></span></td>
    </tr>
  </table>
</div>
<div id="content" class="cx_admin_table">
<?php if(isset($_GET['s_search']) || isset($_GET['s_city'])) { ?>
<table width="835" border="0" align="center" cellpadding="1" a>
      <tr>
        <td width="139">民宿 中文名稱</td>
        <td width="200">民宿 圖片</td>
        <td width="120">經營者姓名</td>
        <td width="165">民宿地址</td>
        <td width="105">民宿點擊次數</td>
        <td width="80">編輯選項</td>
      </tr>
      <?php do { ?>
          <?php if ($totalRows_RecSearch > 0) { // Show if recordset not empty ?>
            <tr>
              <td><?php echo $row_RecSearch['n_name']; ?></td>
              <td><img src="../images/bnb/<?php echo $row_RecSearch['big_pic']; ?>" width="100%" /></td>
              <td width="120"><?php echo $row_RecSearch['place']; ?></td>
              <td width="165"><?php echo $row_RecSearch['address']; ?></td>
              <td width="105"><?php echo $row_RecSearch['times']; ?></td>
              <td width="80"><a href="bnbadd_update.php?id=<?php echo $row_RecSearch['n_id']; ?>" target="frm">修改</a> <a href="bnbstore_detail.php?delbnb=true&amp;id=<?php echo $row_RecSearch['n_id']; ?>" target="frm">刪除</a><br />
              <a href="bnbstore_detail_add.php?id=<?php echo $row_RecSearch['n_id']; ?>">新增詳細資訊</a></td>
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
        <td width="139">民宿 中文名稱</td>
        <td width="200">民宿 圖片</td>
        <td width="120">經營者姓名</td>
        <td width="165">民宿地址</td>
        <td width="105">民宿點擊次數</td>
        <td width="80">編輯選項</td>
      </tr>
      <?php do { ?>
          <?php if ($totalRows_RecBnb > 0) { // Show if recordset not empty ?>
  <tr>
    <td><?php echo $row_RecBnb['n_name']; ?></td>
    <td><img src="../images/bnb/<?php echo $row_RecBnb['big_pic']; ?>" width="100%" /></td>
    <td width="120"><?php echo $row_RecBnb['place']; ?></td>
    <td width="120"><?php echo $row_RecBnb['address']; ?></td>
    <td width="150"><?php echo $row_RecBnb['times']; ?></td>
    <td width="80"><a href="bnbadd_update.php?id=<?php echo $row_RecBnb['n_id']; ?>" target="frm">修改</a> <a href="bnbstore_detail.php?delbnb=true&amp;id=<?php echo $row_RecBnb['n_id']; ?>" target="frm">刪除</a><br />
<a href="bnbstore_detail_add.php?id=<?php echo $row_RecBnb['n_id']; ?>">新增詳細資訊</a></td>
  </tr>
  <?php } // Show if recordset not empty ?>
<?php } while ($row_RecBnb = mysql_fetch_assoc($RecBnb)); ?>
    </table>
    <table border="0" align="center">
      <tr>
        <td><?php if ($pageNum_RecBnb > 0) { // Show if not first page ?>
            <a href="<?php printf("%s?pageNum_RecBnb=%d%s", $currentPage, 0, $queryString_RecBnb); ?>">第一頁</a>
        <?php } // Show if not first page ?></td>
        <td><?php if ($pageNum_RecBnb > 0) { // Show if not first page ?>
            <a href="<?php printf("%s?pageNum_RecBnb=%d%s", $currentPage, max(0, $pageNum_RecBnb - 1), $queryString_RecBnb); ?>">上一頁</a>
        <?php } // Show if not first page ?></td>
        <td><?php if ($pageNum_RecBnb < $totalPages_RecBnb) { // Show if not last page ?>
            <a href="<?php printf("%s?pageNum_RecBnb=%d%s", $currentPage, min($totalPages_RecBnb, $pageNum_RecBnb + 1), $queryString_RecBnb); ?>">下一頁</a>
        <?php } // Show if not last page ?></td>
        <td><?php if ($pageNum_RecBnb < $totalPages_RecBnb) { // Show if not last page ?>
            <a href="<?php printf("%s?pageNum_RecBnb=%d%s", $currentPage, $totalPages_RecBnb, $queryString_RecBnb); ?>">最後一頁</a>
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
<?php
mysql_free_result($RecBnb);

mysql_free_result($RecSearch);

?>
