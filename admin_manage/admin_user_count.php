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

if ((isset($_GET['id'])) && ($_GET['id'] != "") && (isset($_GET['delmember']))) {
  $deleteSQL = sprintf("DELETE FROM admin_root WHERE a_id=%s",
                       GetSQLValueString($_GET['id'], "int"));

  mysql_select_db($database_ksnews3, $ksnews3);
  $Result1 = mysql_query($deleteSQL, $ksnews3) or die(mysql_error());

  $deleteGoTo = "member_detail.php";
  header(sprintf("Location: %s", $deleteGoTo));
}

$maxRows_RecMember = 20;
$pageNum_RecMember = 0;
if (isset($_GET['pageNum_RecMember'])) {
  $pageNum_RecMember = $_GET['pageNum_RecMember'];
}
$startRow_RecMember = $pageNum_RecMember * $maxRows_RecMember;

mysql_select_db($database_ksnews3, $ksnews3);
$query_RecMember = "SELECT * FROM user_count ORDER BY view_id DESC";
$query_limit_RecMember = sprintf("%s LIMIT %d, %d", $query_RecMember, $startRow_RecMember, $maxRows_RecMember);
$RecMember = mysql_query($query_limit_RecMember, $ksnews3) or die(mysql_error());
$row_RecMember = mysql_fetch_assoc($RecMember);

if (isset($_GET['totalRows_RecMember'])) {
  $totalRows_RecMember = $_GET['totalRows_RecMember'];
} else {
  $all_RecMember = mysql_query($query_RecMember);
  $totalRows_RecMember = mysql_num_rows($all_RecMember);
}
$totalPages_RecMember = ceil($totalRows_RecMember/$maxRows_RecMember)-1;

$maxRows_RecSearch = 20;
$pageNum_RecSearch = 0;
if (isset($_GET['pageNum_RecSearch'])) {
  $pageNum_RecSearch = $_GET['pageNum_RecSearch'];
}
$startRow_RecSearch = $pageNum_RecSearch * $maxRows_RecSearch;

// 搜尋時間要修改
$colname_RecSearch = "-1";
if (isset($_POST['a_search'])) {
  $colname_RecSearch = $_POST['a_search'];
}
mysql_select_db($database_ksnews3, $ksnews3);
$query_RecSearch = sprintf("SELECT * FROM user_count WHERE user_id LIKE %s ORDER BY view_id DESC", GetSQLValueString("%" . $colname_RecSearch . "%", "text"));
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

$queryString_RecMember = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_RecMember") == false && 
        stristr($param, "totalRows_RecMember") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_RecMember = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_RecMember = sprintf("&totalRows_RecMember=%d%s", $totalRows_RecMember, $queryString_RecMember);

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
<title>管理者總覽</title>
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
<script type="text/javascript" src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="js/date.js"></script>
</head>

<body>
<div id="content">
<div id="top_nav">
  <table width="835" border="0" cellpadding="0" cellspacing="0" height="28">
    <tr>
      <td width="21" background="../images/board10.gif">&nbsp;</td>
      <td width="100" background="../images/board04.gif" align="left" style="font-size:0.8em">登入紀錄 總覽</td>
      <td width="681" background="../images/board04.gif" style="font-size:0.8em"><form id="form1" name="form1" method="post" action="admin_viewCount.php" target="frm">
        <select name="f_year" id="f_year">
      <?php for($i= date("Y"); $i > date("Y")-10; $i--){ ?>
        <option value="<?php echo $i ;?>"><?php echo $i ;?></option>
      <?php } ?>
      </select>
      年
      <label for="f_month"></label> 
      <select name="f_month" id="f_month">
      <?php for($i=1;$i<=12;$i++) { ?>
        <option value="<?php if($i<10) echo "0";echo $i ;?>" <?php //if (!(strcmp($i, (int)date("m")))) {echo "selected=\"selected\"";} ?> ><?php if($i<10) echo "0";echo $i ;?></option>
      <?php } ?>
      </select>
      月
<label for="f_day"></label>
      <select name="f_day" id="f_day">
	  <?php for($i=1;$i<=31;$i++) { ?>
      <option value="<?php if($i<10) echo "0";echo $i ;?>"><?php if($i<10) echo "0";echo $i ;?></option>
	  <?php } ?>
      </select>
      日
<input type="submit" value="查詢" />
    
      
      </form></td>
      <td width="33" background="../images/board04.gif">&nbsp;</td>
    </tr>
  </table>
</div>
<?php if(isset($_POST['a_search'])) { ?>
<div id="content" class="cx_admin_table">
    <table width="835" border="0" align="center" cellpadding="1" a>
      <tr>
      	<td width="111">總數:<?php echo $totalRows_RecSearch;?></td>
        <td width="125">&nbsp;</td>
        <td width="160">&nbsp;</td>
        <td width="194">&nbsp;</td>
        <td width="160">&nbsp;</td>
      </tr>
      <tr>
      	<td width="111">編號</td>
        <td width="125">會員帳號</td>
        <td width="160">登入時間</td>
        <td width="194">登出時間</td>
        <td width="160">IP位置</td>
        <td width="59">國家</td>
      </tr>
      <?php do { ?>
          <?php if ($totalRows_RecSearch > 0) { // Show if recordset not empty ?>
            <tr>
              <td><?php echo $row_RecSearch['view_id']; ?></td>
              <td><?php echo $row_RecSearch['user_id']; ?></td>
              <td><?php echo $row_RecSearch['in_time']; ?></td>
              <td><?php echo $row_RecSearch['out_time']; ?></td>
              <td width="160"><?php echo $row_RecSearch['user_ip']; ?></td>
              <td width="59">
			  <?php 
			  $sql = 'SELECT c.country FROM ip2nationCountries c,ip2nation i WHERE i.ip < INET_ATON("'.$row_user_count['user_ip'].'") AND c.code = i.country ORDER BY i.ip DESC LIMIT 0,1';	
			  list($countryName) = mysql_fetch_row(mysql_query($sql));	
			  // Output full country name
			  echo $countryName;
			  ?>
              </td>
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
      	<td width="122">總數:<?php echo $totalRows_RecMember;?></td>
        <td width="136">&nbsp;</td>
        <td width="421">&nbsp;</td>
        <td width="122">&nbsp;</td>
        <td width="12">&nbsp;</td>
      </tr>
      <tr>
      	<td width="111">編號</td>
        <td width="125">會員帳號</td>
        <td width="160">登入時間</td>
        <td width="194">登出時間</td>
        <td width="160">IP位置</td>
        <td width="59">國家</td>
      </tr>
      <?php do { ?>
          <?php if ($totalRows_RecMember > 0) { // Show if recordset not empty ?>
  <tr>
              <td><?php echo $row_RecMember['view_id']; ?></td>
              <td><?php echo $row_RecMember['user_id']; ?></td>
              <td><?php echo $row_RecMember['in_time']; ?></td>
              <td><?php echo $row_RecMember['out_time']; ?></td>
              <td width="160"><?php echo $row_RecMember['user_ip']; ?></td>
              <td width="59">
			  <?php 
			  $sql = 'SELECT c.country FROM ip2nationCountries c,ip2nation i WHERE i.ip < INET_ATON("'.$row_user_count['user_ip'].'") AND c.code = i.country ORDER BY i.ip DESC LIMIT 0,1';	
			  list($countryName) = mysql_fetch_row(mysql_query($sql));	
			  // Output full country name
			  echo $countryName;
			  ?>
              </td>
          </tr>
  <?php } // Show if recordset not empty ?>
<?php } while ($row_RecMember = mysql_fetch_assoc($RecMember)); ?>
    </table>
    <table border="0" align="center">
      <tr>
        <td><?php if ($pageNum_RecMember > 0) { // Show if not first page ?>
            <a href="<?php printf("%s?pageNum_RecMember=%d%s", $currentPage, 0, $queryString_RecMember); ?>">第一頁</a>
        <?php } // Show if not first page ?></td>
        <td><?php if ($pageNum_RecMember > 0) { // Show if not first page ?>
            <a href="<?php printf("%s?pageNum_RecMember=%d%s", $currentPage, max(0, $pageNum_RecMember - 1), $queryString_RecMember); ?>">上一頁</a>
        <?php } // Show if not first page ?></td>
        <td><?php if ($pageNum_RecMember < $totalPages_RecMember) { // Show if not last page ?>
            <a href="<?php printf("%s?pageNum_RecMember=%d%s", $currentPage, min($totalPages_RecMember, $pageNum_RecMember + 1), $queryString_RecMember); ?>">下一頁</a>
        <?php } // Show if not last page ?></td>
        <td><?php if ($pageNum_RecMember < $totalPages_RecMember) { // Show if not last page ?>
            <a href="<?php printf("%s?pageNum_RecMember=%d%s", $currentPage, $totalPages_RecMember, $queryString_RecMember); ?>">最後一頁</a>
        <?php } // Show if not last page ?></td>
      </tr>
    </table>
<p align="center">
    <input type="button" onclick="window.history.back();" value="回上一頁"/></p>
  </div>

<?php } ?>
</div>
</body>
</html>
<?php
mysql_free_result($RecMember);

mysql_free_result($RecSearch);
?>
